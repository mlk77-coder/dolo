@extends('layouts.admin')
@section('title', 'View Deal Location')

@section('content')
{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

<style>
    #map {
        height: 75vh;
        width: 100%;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
    }
    
    .leaflet-popup-content {
        direction: rtl;
        text-align: right;
    }
</style>

<x-common.page-breadcrumb pageTitle="View Deal Location" />

<div class="card shadow-sm">
    <div class="card-body p-4">
        <!-- Deal Info -->
        <div class="bg-light p-4 rounded-3 mb-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h4 class="mb-2 fw-bold">📍 {{ $deal->title_en }}</h4>
                    <p class="text-muted mb-0">{{ $deal->title_ar }}</p>
                </div>
                <a href="{{ route('deals.show', $deal) }}" class="btn btn-outline-secondary">
                    ← Back to Deal
                </a>
            </div>

            @if($deal->location_name || $deal->area || ($deal->latitude && $deal->longitude))
                <div class="row g-3">
                    @if($deal->location_name)
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-muted small">Location Name</label>
                            <p class="mb-0 fw-bold">{{ $deal->location_name }}</p>
                        </div>
                    @endif
                    
                    @if($deal->area)
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-muted small">Area</label>
                            <p class="mb-0 fw-bold">{{ $deal->area }}</p>
                        </div>
                    @endif
                    
                    @if($deal->latitude && $deal->longitude)
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-muted small">Coordinates</label>
                            <p class="mb-0 fw-bold font-monospace small">{{ $deal->latitude }}, {{ $deal->longitude }}</p>
                        </div>
                    @endif
                </div>
            @else
                <div class="alert alert-warning mb-0">
                    <strong>⚠️ No Location Data</strong><br>
                    This deal doesn't have a location set.
                </div>
            @endif
        </div>

        @if($deal->latitude && $deal->longitude)
            <!-- Map -->
            <div id="map" class="mb-3"></div>
            
            <div class="alert alert-info mb-0">
                <strong>💡 Info:</strong> This is a read-only view of the deal location. To edit the location, go to the deal edit page.
            </div>
        @else
            <div class="alert alert-secondary text-center py-5">
                <h5>🗺️ No Map Available</h5>
                <p class="mb-0">This deal doesn't have coordinates set. Edit the deal to add a location.</p>
            </div>
        @endif
    </div>
</div>

@if($deal->latitude && $deal->longitude)
    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const lat = {{ $deal->latitude }};
        const lng = {{ $deal->longitude }};
        
        // Initialize map
        const map = L.map('map').setView([lat, lng], 15);
        
        // OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);
        
        // Fix map size issue
        setTimeout(() => {
            map.invalidateSize();
        }, 300);
        
        // Add marker
        const marker = L.marker([lat, lng]).addTo(map);
        
        @if($deal->location_name)
            marker.bindPopup('<strong>{{ $deal->location_name }}</strong>').openPopup();
        @endif
    });
    </script>
@endif

@endsection
