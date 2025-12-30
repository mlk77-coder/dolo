@php
    use Illuminate\Support\Facades\Storage;
@endphp

<div class="grid md:grid-cols-2 gap-6">
    <div>
        <label class="block mb-2">Title (EN) *</label>
        <input type="text" name="title_en" value="{{ old('title_en', $deal->title_en ?? '') }}" required class="w-full px-4 py-2 border rounded-lg">
        @error('title_en')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block mb-2">Title (AR) *</label>
        <input type="text" name="title_ar" value="{{ old('title_ar', $deal->title_ar ?? '') }}" required class="w-full px-4 py-2 border rounded-lg">
        @error('title_ar')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block mb-2">SKU</label>
        <input type="text" name="sku" value="{{ old('sku', $deal->sku ?? '') }}" class="w-full px-4 py-2 border rounded-lg" placeholder="Stock Keeping Unit">
        @error('sku')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block mb-2">Merchant</label>
        <select name="merchant_id" class="w-full px-4 py-2 border rounded-lg">
            <option value="">Select Merchant</option>
            @foreach($merchants ?? [] as $merchant)
                <option value="{{ $merchant->id }}" @selected(old('merchant_id', $deal->merchant_id ?? '') == $merchant->id)>
                    {{ $merchant->business_name }}
                </option>
            @endforeach
        </select>
        @error('merchant_id')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block mb-2">Category</label>
        <select name="category_id" class="w-full px-4 py-2 border rounded-lg">
            <option value="">Select</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $deal->category_id ?? '') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block mb-2">Original Price *</label>
        <input type="number" step="0.01" name="original_price" value="{{ old('original_price', $deal->original_price ?? '') }}" required class="w-full px-4 py-2 border rounded-lg">
        @error('original_price')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block mb-2">Discounted Price *</label>
        <input type="number" step="0.01" name="discounted_price" value="{{ old('discounted_price', $deal->discounted_price ?? '') }}" required class="w-full px-4 py-2 border rounded-lg">
        @error('discounted_price')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block mb-2">Discount %</label>
        <input type="number" step="0.01" name="discount_percentage" value="{{ old('discount_percentage', $deal->discount_percentage ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
        @error('discount_percentage')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block mb-2">Buyer Counter</label>
        <input type="number" name="buyer_counter" value="{{ old('buyer_counter', $deal->buyer_counter ?? 0) }}" min="0" class="w-full px-4 py-2 border rounded-lg" placeholder="Number of buyers">
        @error('buyer_counter')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block mb-2">City</label>
        <input type="text" name="city" value="{{ old('city', $deal->city ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
        @error('city')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block mb-2">Area</label>
        <input type="text" name="area" value="{{ old('area', $deal->area ?? '') }}" class="w-full px-4 py-2 border rounded-lg" placeholder="Area within the city">
        @error('area')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
</div>

<!-- Deal Location Section (Optional) -->
<div class="mt-8 border-t-2 border-gray-300 pt-8 bg-gray-50 -mx-6 px-6 py-6 rounded-lg w-full" 
     x-data="dealLocationMap()"
     x-init="init()">
    <div class="flex items-center gap-2 mb-2">
        <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
        <h3 class="text-xl font-bold text-gray-800">Deal Location in Damascus (Optional)</h3>
    </div>
    <p class="text-sm text-gray-600 mb-4">Select only if the deal has a physical location in Damascus city</p>
    
    <div class="grid md:grid-cols-2 gap-6 mb-4">
        <div>
            <label class="block mb-2">Location Name (Optional)</label>
            <input 
                type="text" 
                name="location_name" 
                x-model="locationName"
                value="{{ old('location_name', $deal->location_name ?? '') }}" 
                class="w-full px-4 py-2 border rounded-lg" 
                placeholder="e.g., Main Branch Damascus">
            @error('location_name')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
        </div>
        <div class="flex items-end gap-2">
            <button 
                type="button" 
                @click="searchAreaOnMap()"
                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Search Area
            </button>
            <button 
                type="button" 
                @click="clearLocation()"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                Clear
            </button>
        </div>
    </div>

    <!-- Search Box -->
    <div class="mb-4">
        <label class="block mb-2 text-sm font-medium">Search Location in Damascus (Arabic or English)</label>
        <div class="flex gap-2">
            <input 
                type="text" 
                x-model="searchQuery"
                @keyup.enter="searchLocation()"
                class="flex-1 px-4 py-2 border rounded-lg" 
                placeholder="e.g., المزة، الشعلان، Mazzeh, Shaalan, Old Damascus, Umayyad Mosque...">
            <button 
                type="button" 
                @click="searchLocation()"
                :disabled="searchLoading"
                class="px-6 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition disabled:opacity-50">
                <span x-show="!searchLoading">Search</span>
                <span x-show="searchLoading">...</span>
            </button>
        </div>
        <p x-show="searchError" x-text="searchError" class="text-red-500 text-xs mt-1"></p>
        <p x-show="searchLoading" class="text-blue-500 text-xs mt-1">Searching Damascus...</p>
        <p x-show="searchSuccess" x-text="searchSuccess" class="text-green-600 text-xs mt-1"></p>
    </div>

    <!-- Map Container -->
    <div class="w-full bg-white rounded-lg border-2 border-gray-300 overflow-hidden shadow-lg">
        <div id="deal-map" style="height: 450px; width: 100%; min-width: 100%;"></div>
    </div>
    
    <p class="text-xs text-gray-500 mt-2">
        <strong>Tip:</strong> Click on the map to select a location, or use the search box above to find specific areas in Damascus.
    </p>
    
    <!-- Hidden inputs for coordinates -->
    <input type="hidden" name="latitude" id="latitude" x-model="latitude" value="{{ old('latitude', $deal->latitude ?? '') }}">
    <input type="hidden" name="longitude" id="longitude" x-model="longitude" value="{{ old('longitude', $deal->longitude ?? '') }}">
    
    <!-- Coordinates Display -->
    <div x-show="latitude && longitude" class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
        <p class="text-sm text-green-800">
            <strong>Selected Coordinates:</strong> 
            Latitude: <span x-text="latitude"></span>, 
            Longitude: <span x-text="longitude"></span>
        </p>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-6">
    @if(isset($deal))
    <div>
        <label class="block mb-2">Sort Order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $deal->sort_order ?? 0) }}" min="0" class="w-full px-4 py-2 border rounded-lg" placeholder="Lower numbers appear first">
        @error('sort_order')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    @endif

    <div>
        <label class="block mb-2">Start Date *</label>
        <input type="datetime-local" name="start_date" value="{{ old('start_date', isset($deal)? optional($deal->start_date)->format('Y-m-d\TH:i'): '') }}" required class="w-full px-4 py-2 border rounded-lg">
        @error('start_date')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block mb-2">End Date *</label>
        <input type="datetime-local" name="end_date" value="{{ old('end_date', isset($deal)? optional($deal->end_date)->format('Y-m-d\TH:i'): '') }}" required class="w-full px-4 py-2 border rounded-lg">
        @error('end_date')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block mb-2">Status *</label>
        <select name="status" required class="w-full px-4 py-2 border rounded-lg">
            @foreach(['draft','active','inactive','expired'] as $status)
                <option value="{{ $status }}" @selected(old('status', $deal->status ?? '') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        @error('status')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div class="flex items-center gap-2">
        <input type="checkbox" name="featured" value="1" @checked(old('featured', $deal->featured ?? false)) class="h-4 w-4">
        <label class="block">Featured</label>
        @error('featured')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div class="flex items-center gap-2">
        <input type="checkbox" name="show_buyer_counter" value="1" @checked(old('show_buyer_counter', $deal->show_buyer_counter ?? true)) class="h-4 w-4">
        <label class="block">Show Buyer Counter</label>
        @error('show_buyer_counter')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div class="flex items-center gap-2">
        <input type="checkbox" name="show_savings_percentage" value="1" @checked(old('show_savings_percentage', $deal->show_savings_percentage ?? true)) class="h-4 w-4">
        <label class="block">Show Savings Percentage</label>
        @error('show_savings_percentage')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>

    <div class="md:col-span-2">
        <label class="block mb-2">Description</label>
        <textarea name="description" rows="4" class="w-full px-4 py-2 border rounded-lg">{{ old('description', $deal->description ?? '') }}</textarea>
        @error('description')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div class="md:col-span-2">
        <label class="block mb-2">Deal Information</label>
        <textarea name="deal_information" rows="4" class="w-full px-4 py-2 border rounded-lg" placeholder="Additional deal information (separate from description)">{{ old('deal_information', $deal->deal_information ?? '') }}</textarea>
        @error('deal_information')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div class="md:col-span-2">
        <label class="block mb-2">Video URL</label>
        <input type="url" name="video_url" value="{{ old('video_url', $deal->video_url ?? '') }}" class="w-full px-4 py-2 border rounded-lg" placeholder="https://example.com/video.mp4 or YouTube/Vimeo URL">
        <p class="text-xs text-gray-500 mt-1">Or upload a video file below</p>
        @error('video_url')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div class="md:col-span-2">
        <label class="block mb-2">Upload Video File</label>
        <input type="file" name="video" accept="video/*" class="w-full px-4 py-2 border rounded-lg">
        <p class="text-xs text-gray-500 mt-1">Max 10MB. Supported formats: MP4, AVI, MOV, WMV, FLV, WEBM</p>
        @if(isset($deal) && $deal->video_url)
            <p class="text-xs text-green-600 mt-1">Current video: {{ basename($deal->video_url) }}</p>
        @endif
        @error('video')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
</div>

<!-- Image Gallery Section - Available in both Create and Edit -->
<div class="mt-8 border-t-2 border-gray-300 pt-8 bg-gray-50 -mx-6 px-6 py-6 rounded-lg" 
     x-data="imageGallery()">
    <div class="flex items-center gap-2 mb-4">
        <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        <h3 class="text-xl font-bold text-gray-800">Deal Images Gallery</h3>
    </div>
    
    <!-- Existing Images (Edit Mode Only) -->
    @if(isset($deal) && $deal->images && $deal->images->count() > 0)
        <div class="mb-6">
            <h4 class="font-medium mb-3 text-gray-700">Existing Images</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($deal->images as $image)
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $image->image_url) }}" alt="Deal Image" class="w-full h-32 object-cover rounded-lg border shadow-sm">
                        @if($image->is_primary)
                            <span class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded">Primary</span>
                        @endif
                        <form action="{{ route('deal-images.destroy', $image) }}" method="POST" class="absolute top-2 right-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')" class="bg-red-500 text-white p-1 rounded hover:bg-red-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Image Upload Area with Preview -->
    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 bg-white hover:border-brand-500 transition-colors">
        <h4 class="font-medium mb-3 text-gray-700">Upload New Images</h4>
        
        <!-- Drop Zone -->
        <div 
            @click="$refs.fileInput.click()"
            @dragover.prevent="isDragging = true"
            @dragleave.prevent="isDragging = false"
            @drop.prevent="handleDrop($event)"
            :class="isDragging ? 'border-brand-500 bg-brand-50' : 'border-gray-300'"
            class="border-2 border-dashed rounded-lg p-8 text-center cursor-pointer transition-all"
        >
            <input type="file" x-ref="fileInput" id="deal-images-input" name="images[]" accept="image/*" multiple class="hidden" @change="handleFiles($event.target.files)">
            <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
            <p class="text-gray-600 mb-1">Click to upload or drag and drop</p>
            <p class="text-sm text-gray-500">Multiple images supported (PNG, JPG, WEBP, max 2MB each)</p>
        </div>

        <!-- Preview Gallery -->
        <div x-show="previewImages.length > 0" class="mt-6">
            <h5 class="font-medium mb-3 text-gray-700">Preview (<span x-text="previewImages.length"></span> images)</h5>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <template x-for="(image, index) in previewImages" :key="index">
                    <div class="relative group">
                        <img :src="image.preview" :alt="'Preview ' + (index + 1)" class="w-full h-32 object-cover rounded-lg border shadow-sm">
                        <button 
                            @click="removeImage(index)"
                            type="button"
                            class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded hover:bg-red-600 transition opacity-0 group-hover:opacity-100"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <div x-show="index === 0" class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded">Primary</div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function imageGallery() {
    return {
        previewImages: [],
        isDragging: false,
        
        handleFiles(files) {
            const validFiles = Array.from(files).filter(file => file.type.startsWith('image/'));
            let loadedCount = 0;
            
            validFiles.forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.previewImages.push({
                        file: file,
                        preview: e.target.result
                    });
                    loadedCount++;
                    // Update file input after all files are loaded
                    if (loadedCount === validFiles.length) {
                        this.updateFileInput();
                    }
                };
                reader.readAsDataURL(file);
            });
            
            // If no valid files, still update (to clear if needed)
            if (validFiles.length === 0) {
                this.updateFileInput();
            }
        },
        
        handleDrop(event) {
            this.isDragging = false;
            const files = event.dataTransfer.files;
            this.handleFiles(files);
        },
        
        removeImage(index) {
            this.previewImages.splice(index, 1);
            this.updateFileInput();
        },
        
        updateFileInput() {
            const input = document.getElementById('deal-images-input');
            if (input && this.previewImages.length > 0) {
                const dt = new DataTransfer();
                this.previewImages.forEach(item => {
                    dt.items.add(item.file);
                });
                input.files = dt.files;
            }
        }
    }
}

function dealLocationMap() {
    return {
        map: null,
        marker: null,
        latitude: '{{ old('latitude', $deal->latitude ?? '') }}',
        longitude: '{{ old('longitude', $deal->longitude ?? '') }}',
        locationName: '{{ old('location_name', $deal->location_name ?? '') }}',
        searchQuery: '',
        searchLoading: false,
        searchError: '',
        searchSuccess: '',
        areaField: '{{ old('area', $deal->area ?? '') }}',
        
        init() {
            // Wait for DOM to be fully rendered
            this.$nextTick(() => {
                // Additional wait to ensure container has final dimensions
                setTimeout(() => {
                    this.initializeMap();
                }, 100);
            });
        },
        
        initializeMap() {
            if (!window.L) {
                console.error('Leaflet not loaded');
                return;
            }
            
            // Default center: Damascus
            const defaultLat = 33.5146;
            const defaultLng = 36.2776;
            
            // Initialize map with proper options
            this.map = L.map('deal-map', {
                center: [defaultLat, defaultLng],
                zoom: 12,
                zoomControl: true,
                scrollWheelZoom: true,
                preferCanvas: true
            });
            
            // Add OpenStreetMap tiles with proper attribution
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                maxZoom: 19,
                minZoom: 10
            }).addTo(this.map);
            
            // CRITICAL: Force Leaflet to recalculate size after container finishes rendering
            // This fixes the "small map" issue caused by Leaflet calculating size too early
            setTimeout(() => {
                this.map.invalidateSize();
            }, 200);
            
            // Additional resize for extra stability (dashboard/dynamic layouts)
            setTimeout(() => {
                this.map.invalidateSize();
            }, 500);
            
            // Final resize to ensure full width is applied
            setTimeout(() => {
                this.map.invalidateSize();
            }, 1000);
            
            // If coordinates exist, show marker
            if (this.latitude && this.longitude) {
                const lat = parseFloat(this.latitude);
                const lng = parseFloat(this.longitude);
                if (!isNaN(lat) && !isNaN(lng)) {
                    this.addMarker(lat, lng);
                    this.map.setView([lat, lng], 15);
                }
            }
            
            // Add click listener
            this.map.on('click', (e) => {
                this.addMarker(e.latlng.lat, e.latlng.lng);
                this.searchSuccess = 'Location selected on map';
                setTimeout(() => { this.searchSuccess = ''; }, 3000);
            });
            
            // Handle window resize to keep map properly sized
            window.addEventListener('resize', () => {
                if (this.map) {
                    this.map.invalidateSize();
                }
            });
        },
        
        addMarker(lat, lng) {
            // Remove existing marker if any
            if (this.marker) {
                this.map.removeLayer(this.marker);
            }
            
            // Add new marker with custom popup
            this.marker = L.marker([lat, lng]).addTo(this.map);
            
            if (this.locationName) {
                this.marker.bindPopup(this.locationName).openPopup();
            }
            
            // Update coordinates
            this.latitude = lat.toFixed(7);
            this.longitude = lng.toFixed(7);
        },
        
        async searchLocation() {
            if (!this.searchQuery.trim()) {
                this.searchError = 'Please enter a location to search';
                return;
            }
            
            this.searchLoading = true;
            this.searchError = '';
            this.searchSuccess = '';
            
            try {
                // Use Nominatim API to search within Damascus
                const query = encodeURIComponent(this.searchQuery + ', Damascus, Syria');
                const response = await fetch(
                    `https://nominatim.openstreetmap.org/search?format=json&q=${query}&limit=5&bounded=1&viewbox=36.2,33.6,36.4,33.4`,
                    {
                        headers: {
                            'Accept-Language': 'ar,en'
                        }
                    }
                );
                
                const results = await response.json();
                
                if (results && results.length > 0) {
                    const result = results[0];
                    const lat = parseFloat(result.lat);
                    const lng = parseFloat(result.lon);
                    
                    // Add marker and center map
                    this.addMarker(lat, lng);
                    this.map.setView([lat, lng], 16);
                    
                    this.searchSuccess = `Found: ${result.display_name}`;
                    setTimeout(() => { this.searchSuccess = ''; }, 5000);
                } else {
                    this.searchError = 'Location not found in Damascus. Try different keywords.';
                }
            } catch (error) {
                console.error('Search error:', error);
                this.searchError = 'Search failed. Please try again.';
            } finally {
                this.searchLoading = false;
            }
        },
        
        async searchAreaOnMap() {
            // Get area from the area input field
            const areaInput = document.querySelector('input[name="area"]');
            if (areaInput && areaInput.value.trim()) {
                this.searchQuery = areaInput.value.trim();
                await this.searchLocation();
            } else {
                this.searchError = 'Please enter an area name in the Area field first';
                setTimeout(() => { this.searchError = ''; }, 3000);
            }
        },
        
        clearLocation() {
            // Remove marker
            if (this.marker) {
                this.map.removeLayer(this.marker);
                this.marker = null;
            }
            
            // Clear coordinates and location name
            this.latitude = '';
            this.longitude = '';
            this.locationName = '';
            this.searchQuery = '';
            this.searchError = '';
            this.searchSuccess = '';
            
            // Reset map view to Damascus
            this.map.setView([33.5146, 36.2776], 12);
        }
    }
}
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
      crossorigin=""/>
<style>
    /* Ensure map container takes full width */
    #deal-map {
        width: 100% !important;
        min-width: 100% !important;
        max-width: 100% !important;
        display: block !important;
    }
    
    /* Fix Leaflet container sizing */
    .leaflet-container {
        width: 100% !important;
        height: 100% !important;
    }
    
    /* Ensure parent containers don't restrict width */
    #deal-map .leaflet-pane,
    #deal-map .leaflet-map-pane {
        width: 100% !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" 
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" 
        crossorigin=""></script>
@endpush

