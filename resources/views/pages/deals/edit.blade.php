@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Edit Deal" />
    <x-common.component-card title="Edit Deal">
        <form action="{{ route('deals.update', $deal) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf 
            @method('PUT')
            @include('pages.deals.partials.form', ['deal' => $deal, 'merchants' => $merchants, 'categories' => $categories])
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition-colors">Update</button>
                <a href="{{ route('deals.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">Cancel</a>
            </div>
        </form>
    </x-common.component-card>

    {{-- Include Location Modal --}}
    @include('pages.deals.partials.location-modal')
@endsection

@push('scripts')
{{-- Leaflet JS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// Modal map functionality
let modalMap = null;
let modalMarker = null;
let selectedLat = null;
let selectedLng = null;

function openLocationModal() {
    const modal = document.getElementById('locationModal');
    if (!modal) {
        alert('Error: Location modal not loaded. Please refresh the page.');
        return;
    }
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    setTimeout(() => {
        if (!modalMap) {
            initializeModalMap();
        } else {
            modalMap.invalidateSize();
        }
        loadExistingLocation();
    }, 100);
}

function closeLocationModal() {
    const modal = document.getElementById('locationModal');
    if (!modal) return;
    modal.classList.add('hidden');
    document.body.style.overflow = '';
}

function initializeModalMap() {
    modalMap = L.map('modal-map').setView([33.5102, 36.2781], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(modalMap);
    modalMap.on('click', function(e) {
        addModalMarker(e.latlng.lat, e.latlng.lng);
        showSearchStatus('✓ Location selected on map', 'success');
    });
}

function addModalMarker(lat, lng) {
    if (modalMarker) modalMap.removeLayer(modalMarker);
    modalMarker = L.marker([lat, lng]).addTo(modalMap);
    selectedLat = lat.toFixed(7);
    selectedLng = lng.toFixed(7);
    reverseGeocode(lat, lng);
    updateModalLocationDisplay();
}

async function reverseGeocode(lat, lng) {
    try {
        const res = await fetch(
            `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=ar,en`,
            { headers: { 'Accept-Language': 'ar,en' } }
        );
        const data = await res.json();
        if (data && data.address) {
            const locationName = data.address.neighbourhood || 
                                data.address.suburb || 
                                data.address.quarter || 
                                data.address.district || 
                                data.address.city_district || 
                                data.address.road || 
                                'Damascus Location';
            const area = data.address.suburb || 
                        data.address.neighbourhood || 
                        data.address.quarter || 
                        data.address.district || 
                        '';
            document.getElementById('modal-location-name').value = locationName;
            if (area) {
                document.getElementById('modal-area').value = area;
            }
            updateModalLocationDisplay();
        }
    } catch (e) {
        console.error('Reverse geocoding failed:', e);
    }
}

function updateModalLocationDisplay() {
    const locationName = document.getElementById('modal-location-name').value || 'Selected Location';
    const area = document.getElementById('modal-area').value || '-';
    document.getElementById('modal-selected-location').textContent = locationName + (area !== '-' ? ' - ' + area : '');
    document.getElementById('modal-selected-coords').textContent = `${selectedLat}, ${selectedLng}`;
    document.getElementById('modal-location-info').classList.remove('hidden');
}

async function searchLocationInModal() {
    const query = document.getElementById('modal-search-input').value.trim();
    if (!query) {
        showSearchStatus('Please enter a location to search', 'warning');
        return;
    }
    showSearchStatus('Searching Damascus...', 'info');
    try {
        const encodedQuery = encodeURIComponent(query + ', Damascus, Syria');
        const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodedQuery}&limit=5&bounded=1&viewbox=36.2,33.6,36.4,33.4`, { headers: { 'Accept-Language': 'ar,en' } });
        const data = await res.json();
        if (data.length) {
            const lat = parseFloat(data[0].lat);
            const lng = parseFloat(data[0].lon);
            addModalMarker(lat, lng);
            modalMap.setView([lat, lng], 16);
            showSearchStatus(`✓ Found: ${data[0].display_name}`, 'success');
        } else {
            showSearchStatus('Location not found in Damascus. Try different keywords.', 'error');
        }
    } catch (e) {
        console.error(e);
        showSearchStatus('Search failed. Please try again.', 'error');
    }
}

function showSearchStatus(message, type) {
    const statusDiv = document.getElementById('modal-search-status');
    const colors = {
        success: 'bg-green-100 text-green-800 border-green-300',
        error: 'bg-red-100 text-red-800 border-red-300',
        warning: 'bg-yellow-100 text-yellow-800 border-yellow-300',
        info: 'bg-blue-100 text-blue-800 border-blue-300'
    };
    statusDiv.className = `mt-2 p-3 rounded border ${colors[type]}`;
    statusDiv.textContent = message;
    if (type === 'success' || type === 'error') {
        setTimeout(() => { statusDiv.textContent = ''; statusDiv.className = 'mt-2'; }, 5000);
    }
}

function loadExistingLocation() {
    const lat = document.getElementById('latitude-field').value;
    const lng = document.getElementById('longitude-field').value;
    const locationName = document.getElementById('location-name-field').value;
    const area = document.getElementById('area-field').value;
    if (lat && lng) {
        addModalMarker(parseFloat(lat), parseFloat(lng));
        modalMap.setView([parseFloat(lat), parseFloat(lng)], 15);
        if (locationName) document.getElementById('modal-location-name').value = locationName;
        if (area) document.getElementById('modal-area').value = area;
    }
}

function confirmLocation() {
    if (!selectedLat || !selectedLng) {
        alert('Please select a location on the map first');
        return;
    }
    const locationName = document.getElementById('modal-location-name').value;
    const area = document.getElementById('modal-area').value;
    document.getElementById('latitude-field').value = selectedLat;
    document.getElementById('longitude-field').value = selectedLng;
    document.getElementById('location-name-field').value = locationName;
    document.getElementById('area-field').value = area;
    const coordinatesDisplay = document.getElementById('coordinates-display');
    if (coordinatesDisplay) {
        coordinatesDisplay.value = `${selectedLat}, ${selectedLng}`;
    }
    closeLocationModal();
    showSuccessNotification();
}

function showSuccessNotification() {
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 animate-fade-in';
    notification.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span>Location saved successfully!</span>`;
    document.body.appendChild(notification);
    setTimeout(() => { notification.remove(); }, 3000);
}

function clearLocation() {
    document.getElementById('latitude-field').value = '';
    document.getElementById('longitude-field').value = '';
    document.getElementById('location-name-field').value = '';
    document.getElementById('area-field').value = '';
    const coordinatesDisplay = document.getElementById('coordinates-display');
    if (coordinatesDisplay) {
        coordinatesDisplay.value = '';
    }
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 z-50 bg-gray-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2';
    notification.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg><span>Location cleared</span>`;
    document.body.appendChild(notification);
    setTimeout(() => { notification.remove(); }, 2000);
}

document.addEventListener('DOMContentLoaded', function() {
    const modalLocationName = document.getElementById('modal-location-name');
    const modalArea = document.getElementById('modal-area');
    if (modalLocationName) {
        modalLocationName.addEventListener('input', function() {
            if (selectedLat && selectedLng) updateModalLocationDisplay();
        });
    }
    if (modalArea) {
        modalArea.addEventListener('input', function() {
            if (selectedLat && selectedLng) updateModalLocationDisplay();
        });
    }
    
    // Load existing coordinates into display field
    const latField = document.getElementById('latitude-field');
    const lngField = document.getElementById('longitude-field');
    const coordsDisplay = document.getElementById('coordinates-display');
    
    if (latField && lngField && coordsDisplay && latField.value && lngField.value) {
        coordsDisplay.value = `${latField.value}, ${lngField.value}`;
    }
});
</script>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in { animation: fade-in 0.3s ease-out; }
</style>
@endpush
