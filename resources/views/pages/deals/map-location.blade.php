@extends('layouts.admin')
@section('title', 'Choose Deal Location')

@section('content')

{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<style>
/* =====================================================
   STYLES SCOPED ONLY TO SEARCH LOCATION SECTION
   ===================================================== */

.deal-location-search {
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    padding: 24px;
    border-radius: 14px;
    margin-bottom: 24px;
}

.deal-location-search .deal-title {
    font-weight: 700;
    margin-bottom: 16px;
    color: #111827;
}

.deal-location-search .deal-search-row {
    display: flex;
    gap: 12px;
    margin-bottom: 18px;
}

.deal-location-search .deal-input {
    width: 100%;
    padding: 12px 14px;
    border-radius: 10px;
    border: 1px solid #d1d5db;
    font-size: 0.95rem;
    transition: .2s ease;
}

.deal-location-search .deal-input:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,.15);
}

.deal-location-search .deal-label {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 6px;
    color: #374151;
}

.deal-location-search .deal-search-btn {
    padding: 12px 20px;
    border-radius: 10px;
    border: none;
    background: linear-gradient(135deg,#2563eb,#1e40af);
    color: #fff;
    font-weight: 600;
    cursor: pointer;
    transition: .25s ease;
}

.deal-location-search .deal-search-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 18px rgba(37,99,235,.35);
}

.deal-location-search .deal-form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 16px;
}

/* =====================================================
   MAP (NO GLOBAL STYLING)
   ===================================================== */
#map {
    height: 70vh;
    width: 100%;
    border-radius: 12px;
    border: 2px solid #e5e7eb;
}
</style>

<x-common.page-breadcrumb pageTitle="Choose Deal Location" />

<div class="card shadow-sm">
    <div class="card-body p-4">

        <!-- SEARCH LOCATION SECTION -->
        <div class="deal-location-search">

            <h4 class="deal-title">🔍 Search Location in Damascus</h4>

            <div class="deal-search-row">
                <input
                    type="text"
                    id="searchInput"
                    class="deal-input"
                    placeholder="Search: Mazzeh, Shaalan, Old Damascus">

                <button id="searchBtn" class="deal-search-btn">
                    Search
                </button>
            </div>

            <div class="deal-form-grid">
                <div>
                    <label class="deal-label">Location Name (Optional)</label>
                    <input
                        type="text"
                        id="locationNameInput"
                        class="deal-input"
                        placeholder="e.g., Main Branch, Downtown Store">
                </div>

                <div>
                    <label class="deal-label">Area</label>
                    <input
                        type="text"
                        id="areaInput"
                        class="deal-input"
                        placeholder="e.g., Mazzeh, Shaalan">
                </div>
            </div>

            <div id="searchStatus" class="mt-3"></div>
        </div>

        <!-- MAP -->
        <div id="map" class="mb-3"></div>

        <!-- LOCATION INFO -->
        <div id="locationInfo" class="alert alert-success d-none">
            <h5 class="mb-3 fw-bold">📍 Selected Location</h5>
            <div class="row g-2 mb-3">
                <div class="col-md-4">
                    <small class="text-muted">Location Name:</small>
                    <p class="mb-0 fw-semibold" id="displayLocationName">-</p>
                </div>
                <div class="col-md-4">
                    <small class="text-muted">Area:</small>
                    <p class="mb-0 fw-semibold" id="displayArea">-</p>
                </div>
                <div class="col-md-4">
                    <small class="text-muted">Coordinates:</small>
                    <p class="mb-0 fw-semibold font-monospace small" id="displayCoords">-</p>
                </div>
            </div>
        <div class="d-flex gap-2">
    <button
        id="confirmBtn"
        class="btn btn-lg
               px-6 py-3
               rounded-xl
               font-semibold text-white
               bg-[#2563eb]
               shadow-lg
               transition-all duration-200
               hover:bg-[#1e40af]
               hover:-translate-y-0.5
               hover:shadow-2xl
               focus:outline-none
               focus:ring-4 focus:ring-[#2563eb]/40">
        ✓ Confirm & Return to Deal Form
    </button>

    <button
        id="clearBtn"
        class="btn
               px-5 py-2.5
               rounded-xl
               font-medium
               text-gray-700
               border border-gray-300
               bg-white
               transition-all duration-200
               hover:bg-gray-100
               hover:-translate-y-0.5
               focus:outline-none
               focus:ring-4 focus:ring-gray-300">
        Clear Location
    </button>
</div>

        </div>

        <div class="alert alert-info mb-0">
            <strong>💡 Tip:</strong> Click on the map or search to select a deal location.
        </div>
    </div>
</div>

{{-- Leaflet JS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ================= MAP INIT ================= */
    const map = L.map('map').setView([33.5102, 36.2781], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    setTimeout(() => map.invalidateSize(), 300);

    let marker = null;
    let selectedLat = null;
    let selectedLng = null;

    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const locationNameInput = document.getElementById('locationNameInput');
    const areaInput = document.getElementById('areaInput');
    const searchStatus = document.getElementById('searchStatus');
    const locationInfo = document.getElementById('locationInfo');
    const confirmBtn = document.getElementById('confirmBtn');
    const clearBtn = document.getElementById('clearBtn');

    /* ================= LOAD EXISTING DATA ================= */
    const existingData = sessionStorage.getItem('dealLocation');
    if (existingData) {
        const data = JSON.parse(existingData);
        if (data.latitude && data.longitude) {
            addMarker(parseFloat(data.latitude), parseFloat(data.longitude));
            map.setView([parseFloat(data.latitude), parseFloat(data.longitude)], 15);
        }
        if (data.location_name) {
            locationNameInput.value = data.location_name;
        }
        if (data.area) {
            areaInput.value = data.area;
        }
    }

    /* ================= ADD MARKER ================= */
    function addMarker(lat, lng) {
        if (marker) map.removeLayer(marker);

        marker = L.marker([lat, lng]).addTo(map);
        selectedLat = lat.toFixed(7);
        selectedLng = lng.toFixed(7);

        updateLocationDisplay();
    }

    /* ================= UPDATE DISPLAY ================= */
    function updateLocationDisplay() {
        document.getElementById('displayLocationName').textContent = locationNameInput.value || '-';
        document.getElementById('displayArea').textContent = areaInput.value || '-';
        document.getElementById('displayCoords').textContent = `${selectedLat}, ${selectedLng}`;
        locationInfo.classList.remove('d-none');
    }

    /* ================= MAP CLICK ================= */
    map.on('click', function (e) {
        addMarker(e.latlng.lat, e.latlng.lng);
        searchStatus.innerHTML = '<div class="alert alert-success mt-2">✓ Location selected on map</div>';
        setTimeout(() => { searchStatus.innerHTML = ''; }, 3000);
    });

    /* ================= SEARCH ================= */
    async function searchLocation() {
        const query = searchInput.value.trim();
        if (!query) {
            searchStatus.innerHTML = '<div class="alert alert-warning mt-2">Please enter a location to search</div>';
            return;
        }

        searchStatus.innerHTML = '<div class="alert alert-info mt-2">Searching Damascus...</div>';

        try {
            const encodedQuery = encodeURIComponent(query + ', Damascus, Syria');
            const res = await fetch(
                `https://nominatim.openstreetmap.org/search?format=json&q=${encodedQuery}&limit=5&bounded=1&viewbox=36.2,33.6,36.4,33.4`,
                {
                    headers: {
                        'Accept-Language': 'ar,en'
                    }
                }
            );

            const data = await res.json();
            if (data.length) {
                const lat = parseFloat(data[0].lat);
                const lng = parseFloat(data[0].lon);

                addMarker(lat, lng);
                map.setView([lat, lng], 16);
                
                searchStatus.innerHTML = `<div class="alert alert-success mt-2">✓ Found: ${data[0].display_name}</div>`;
                setTimeout(() => { searchStatus.innerHTML = ''; }, 5000);
            } else {
                searchStatus.innerHTML = '<div class="alert alert-danger mt-2">Location not found in Damascus. Try different keywords.</div>';
            }
        } catch (e) {
            console.error(e);
            searchStatus.innerHTML = '<div class="alert alert-danger mt-2">Search failed. Please try again.</div>';
        }
    }

    searchBtn.addEventListener('click', searchLocation);
    searchInput.addEventListener('keyup', e => {
        if (e.key === 'Enter') searchLocation();
    });

    /* ================= UPDATE DISPLAY ON INPUT CHANGE ================= */
    locationNameInput.addEventListener('input', function() {
        if (selectedLat && selectedLng) {
            updateLocationDisplay();
        }
    });

    areaInput.addEventListener('input', function() {
        if (selectedLat && selectedLng) {
            updateLocationDisplay();
        }
    });

    /* ================= CONFIRM BUTTON ================= */
    confirmBtn.addEventListener('click', function() {
        if (!selectedLat || !selectedLng) {
            alert('Please select a location on the map first');
            return;
        }

        // Save to session storage
        const locationData = {
            latitude: selectedLat,
            longitude: selectedLng,
            location_name: locationNameInput.value,
            area: areaInput.value
        };

        sessionStorage.setItem('dealLocation', JSON.stringify(locationData));

        // Redirect back to deal form (use session return URL or default to create)
        const returnUrl = '{{ session("deal_form_return_url", route("deals.create")) }}';
        window.location.href = returnUrl;
    });

    /* ================= CLEAR BUTTON ================= */
    clearBtn.addEventListener('click', function() {
        if (marker) {
            map.removeLayer(marker);
            marker = null;
        }
        selectedLat = null;
        selectedLng = null;
        locationNameInput.value = '';
        areaInput.value = '';
        searchInput.value = '';
        locationInfo.classList.add('d-none');
        searchStatus.innerHTML = '';
        map.setView([33.5102, 36.2781], 12);

        // Clear session storage
        sessionStorage.removeItem('dealLocation');
    });
});
</script>

@endsection
