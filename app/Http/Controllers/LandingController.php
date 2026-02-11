<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing.index');
    }

    public function privacy()
    {
        return view('landing.privacy');
    }

    public function downloadApk()
    {
        // Path to the APK file in public/downloads folder
        $apkPath = public_path('downloads/dolo-app.apk');
        
        // Check if file exists
        if (!file_exists($apkPath)) {
            abort(404, 'APK file not found. Please upload the APK file to public/downloads/dolo-app.apk');
        }
        
        // Download the file
        return response()->download($apkPath, 'dolo-app.apk', [
            'Content-Type' => 'application/vnd.android.package-archive',
        ]);
    }
}
