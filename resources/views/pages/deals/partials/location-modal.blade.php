{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

{{-- Location Modal --}}
<div id="locationModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeLocationModal()"></div>
    
    {{-- Modal Content --}}
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-5xl max-h-[90vh] overflow-hidden">
            {{-- Modal Header --}}
            <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Select Deal Location</h2>
                        <p class="text-sm text-blue-100">Damascus, Syria</p>
                    </div>
                </div>
                <button onclick="closeLocationModal()" class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            {{-- Modal Body --}}
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-180px)]">
                {{-- Search Section --}}
                <div class="mb-6 bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        🔍 Search Location in Damascus
                    </label>
                    <div class="flex gap-2">
                        <input 
                            type="text" 
                            id="modal-search-input"
                            class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200" 
                            placeholder="e.g., Mezzeh, Malki, Abu Rummaneh..."
                            onkeypress="if(event.key === 'Enter') { event.preventDefault(); searchLocationInModal(); }">
                        <button 
                            type="button"
                            onclick="searchLocationInModal()"
                            class="px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition-all duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Search
                        </button>
                    </div>
                    <div id="modal-search-status" class="mt-2"></div>
                </div>
                
                {{-- Map Container --}}
                <div class="mb-6">
                    <div id="modal-map" class="w-full h-96 rounded-xl border-2 border-gray-300 shadow-inner"></div>
                    <p class="text-sm text-gray-600 mt-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Click anywhere on the map to place a marker
                    </p>
                </div>
                
                {{-- Location Details --}}
                <div class="grid md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Location Name
                        </label>
                        <input 
                            type="text" 
                            id="modal-location-name"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200" 
                            placeholder="e.g., Main Branch Damascus">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Area
                        </label>
                        <input 
                            type="text" 
                            id="modal-area"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200" 
                            placeholder="e.g., Mezzeh, Malki">
                    </div>
                </div>
                
                {{-- Selected Location Display --}}
                <div id="modal-location-info" class="hidden bg-green-50 border-l-4 border-green-500 rounded-r-xl p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="font-semibold text-green-800 mb-1">✓ Location Selected</p>
                            <p class="text-sm text-green-700">
                                <span class="font-medium">Location:</span> 
                                <span id="modal-selected-location">-</span>
                            </p>
                            <p class="text-sm text-green-700 font-mono">
                                <span class="font-medium">Coordinates:</span> 
                                <span id="modal-selected-coords">-</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Modal Footer --}}
            <div class="bg-gray-50 px-6 py-4 flex items-center justify-end gap-3 border-t border-gray-200">
                <button 
                    type="button"
                    onclick="closeLocationModal()"
                    class="px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                    Cancel
                </button>
                <button 
                    type="button"
                    onclick="confirmLocation()"
                    class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg font-semibold hover:from-green-700 hover:to-emerald-700 shadow-lg hover:shadow-xl transition-all duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Confirm Location
                </button>
            </div>
        </div>
    </div>
</div>
