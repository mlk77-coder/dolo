<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    public function exportCsv(Request $request)
    {
        $model = $request->input('model');
        $data = $request->input('data', []);
        $filename = $request->input('filename', 'export');
        
        if (empty($data)) {
            return redirect()->back()->with('error', 'No data to export.');
        }
        
        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}.csv\"",
        );
        
        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Write headers
            if (!empty($data)) {
                $headers = array_keys($data[0]);
                fputcsv($file, $headers);
                
                // Write data
                foreach ($data as $row) {
                    fputcsv($file, array_values($row));
                }
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
}

