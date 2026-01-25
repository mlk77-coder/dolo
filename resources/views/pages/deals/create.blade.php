@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Create Deal" />
    <x-common.component-card title="Create Deal">
        <form action="{{ route('deals.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @include('pages.deals.partials.form', ['deal' => null, 'merchants' => $merchants, 'categories' => $categories])
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-brand-500 text-white rounded-lg">Create</button>
                <a href="{{ route('deals.index') }}" class="px-6 py-2 bg-gray-200 rounded-lg">Cancel</a>
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
// Global variables for modal map
let modalMap = null;
let modalMarker = null;
let selectedLat = null;
let selectedLng = null;

// Open modal
function openLocationModal() {
    console.log('openLocationModal called');
    document.getElementById('locationModal').classList.remove('hidden');
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

// Close modal
function closeLocationModal() {
    document.getElementById('locationModal').classList.add('hidden');
    document.body.style.overflow = '';
}

// Initialize the map
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

// Add marker to map
function addModalMarker(lat, lng) {
    if (modalMarker) {
        modalMap.removeLayer(modalMarker);
    }
    
    modalMarker = L.marker([lat, lng]).addTo(modalMap);
    selectedLat = lat.toFixed(7);
    selectedLng = lng.toFixed(7);
    
    updateModalLocationDisplay();
}

// Update location display in modal
function updateModalLocationDisplay() {
    const locationName = document.getElementById('modal-location-name').value || 'Selected Location';
    const area = document.getElementById('modal-area').value || '-';
    
    document.getElementById('modal-selected-location').textContent = 
        locationName + (area !== '-' ? ' - ' + area : '');
    document.getElementById('modal-selected-coords').textContent = 
        `${selectedLat}, ${selectedLng}`;
    document.getElementById('modal-location-info').classList.remove('hidden');
}

// Search location
async function searchLocationInModal() {
    const query = document.getElementById('modal-search-input').value.trim();
    if (!query) {
        showSearchStatus('Please enter a location to search', 'warning');
        return;
    }
    
    showSearchStatus('Searching Damascus...', 'info');
    
    try {
        const encodedQuery = encodeURIComponent(query + ', Damascus, Syria');
        const res = await fetch(
            `https://nominatim.openstreetmap.org/search?format=json&q=${encodedQuery}&limit=5&bounded=1&viewbox=36.2,33.6,36.4,33.4`,
            { headers: { 'Accept-Language': 'ar,en' } }
        );
        
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

// Show search status
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
        setTimeout(() => {
            statusDiv.textContent = '';
            statusDiv.className = 'mt-2';
        }, 5000);
    }
}

// Load existing location from form
function loadExistingLocation() {
    const lat = document.getElementById('latitude-field').value;
    const lng = document.getElementById('longitude-field').value;
    const locationName = document.getElementById('location-name-field').value;
    const area = document.getElementById('area-field').value;
    
    if (lat && lng) {
        addModalMarker(parseFloat(lat), parseFloat(lng));
        modalMap.setView([parseFloat(lat), parseFloat(lng)], 15);
        
        if (locationName) {
            document.getElementById('modal-location-name').value = locationName;
        }
        if (area) {
            document.getElementById('modal-area').value = area;
        }
    }
}

// Confirm location and update form
function confirmLocation() {
    if (!selectedLat || !selectedLng) {
        alert('Please select a location on the map first');
        return;
    }
    
    const locationName = document.getElementById('modal-location-name').value;
    const area = document.getElementById('modal-area').value;
    
    // Update hidden form fields
    document.getElementById('latitude-field').value = selectedLat;
    document.getElementById('longitude-field').value = selectedLng;
    document.getElementById('location-name-field').value = locationName;
    document.getElementById('area-field').value = area;
    
    // Update display in main form
    const displayDiv = document.getElementById('location-display');
    const displayText = document.getElementById('location-display-text');
    const coordsText = document.getElementById('coordinates-display-text');
    
    displayDiv.classList.remove('hidden');
    displayText.textContent = locationName || 'Selected Location' + (area ? ' - ' + area : '');
    coordsText.textContent = `${selectedLat}, ${selectedLng}`;
    
    // Close modal
    closeLocationModal();
    
    // Show success message
    showSuccessNotification();
}

// Show success notification
function showSuccessNotification() {
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 animate-fade-in';
    notification.innerHTML = `
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span>Location saved successfully!</span>
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Clear location function
function clearLocation() {
    document.getElementById('latitude-field').value = '';
    document.getElementById('longitude-field').value = '';
    document.getElementById('location-name-field').value = '';
    document.getElementById('area-field').value = '';
    document.getElementById('location-display').classList.add('hidden');
    
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 z-50 bg-gray-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2';
    notification.innerHTML = `
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
        </svg>
        <span>Location cleared</span>
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 2000);
}

// Update modal location display when inputs change
document.addEventListener('DOMContentLoaded', function() {
    const modalLocationName = document.getElementById('modal-location-name');
    const modalArea = document.getElementById('modal-area');
    
    if (modalLocationName) {
        modalLocationName.addEventListener('input', function() {
            if (selectedLat && selectedLng) {
                updateModalLocationDisplay();
            }
        });
    }
    
    if (modalArea) {
        modalArea.addEventListener('input', function() {
            if (selectedLat && selectedLng) {
                updateModalLocationDisplay();
            }
        });
    }
    
    console.log('✅ Modal functions loaded successfully');
});
</script>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>
@endpush

