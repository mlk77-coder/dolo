@php
    use Illuminate\Support\Facades\Storage;
@endphp

{{-- Display all validation errors --}}
@if ($errors->any())
<div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
    <div class="flex items-start gap-3">
        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="flex-1">
            <p class="text-sm font-semibold text-red-800 mb-2">⚠️ Please fix the following errors:</p>
            <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button onclick="this.parentElement.parentElement.remove()" class="text-red-400 hover:text-red-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>
@endif

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
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $deal->category_id ?? '') == $category->id)>{{ $category->name_en }} - {{ $category->name_ar }}</option>
            @endforeach
        </select>
        @error('category_id')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block mb-2">Original Price *</label>
        <input type="number" step="0.01" name="original_price" id="original_price" value="{{ old('original_price', $deal->original_price ?? '') }}" required class="w-full px-4 py-2 border rounded-lg">
        @error('original_price')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block mb-2">Discounted Price *</label>
        <input type="number" step="0.01" name="discounted_price" id="discounted_price" value="{{ old('discounted_price', $deal->discounted_price ?? '') }}" required class="w-full px-4 py-2 border rounded-lg">
        @error('discounted_price')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block mb-2">Discount % (Auto-calculated)</label>
        <input type="number" step="0.01" name="discount_percentage" id="discount_percentage" value="{{ old('discount_percentage', $deal->discount_percentage ?? '') }}" readonly class="w-full px-4 py-2 border rounded-lg bg-gray-100 cursor-not-allowed">
        <p class="text-xs text-gray-500 mt-1">Automatically calculated from original and discounted prices</p>
        @error('discount_percentage')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block mb-2">Quantity</label>
        <input type="number" name="quantity" value="{{ old('quantity', $deal->quantity ?? 0) }}" min="0" class="w-full px-4 py-2 border rounded-lg" placeholder="Available quantity">
        <p class="text-xs text-gray-500 mt-1">Number of items available for this deal</p>
        @error('quantity')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
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
        <input type="text" name="area" id="area-field" value="{{ old('area', $deal->area ?? '') }}" class="w-full px-4 py-2 border rounded-lg" placeholder="Area within the city">
        @error('area')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
</div>

<!-- Deal Location Section (Button to Map Page) -->
<div class="mt-8 border-t-2 border-gray-300 pt-8 -mx-6 px-6 py-6 rounded-lg bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    <div class="flex items-center gap-3 mb-3">
        <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                Deal Location in Damascus
                <span class="text-sm font-normal text-gray-500 bg-white px-3 py-1 rounded-full border border-gray-200">Optional</span>
            </h3>
            <p class="text-sm text-gray-600 mt-1">📍 Select a physical location for this deal on the map</p>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div class="space-y-2">
                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Location Name
                    <span class="text-xs text-gray-400 font-normal">(Optional)</span>
                </label>
                <div class="relative">
                    <input 
                        type="text" 
                        name="location_name" 
                        id="location-name-field"
                        value="{{ old('location_name', $deal->location_name ?? '') }}" 
                        class="w-full px-4 py-3 pl-11 border-2 border-gray-200 rounded-xl bg-gray-50 text-gray-700 font-medium focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200" 
                        placeholder="e.g., Main Branch Damascus">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
                @error('location_name')<p class="text-red-500 text-xs mt-1 flex items-center gap-1"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>{{ $message }}</p>@enderror
            </div>
            <div class="space-y-2">
                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                    Coordinates
                </label>
                <div class="relative">
                    <input 
                        type="text" 
                        id="coordinates-display"
                        class="w-full px-4 py-3 pl-11 border-2 border-gray-200 rounded-xl bg-gray-50 text-gray-700 font-mono text-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200" 
                        placeholder="Not selected yet"
                        readonly>
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Hidden inputs for coordinates -->
        <input type="hidden" name="latitude" id="latitude-field" value="{{ old('latitude', $deal->latitude ?? '') }}">
        <input type="hidden" name="longitude" id="longitude-field" value="{{ old('longitude', $deal->longitude ?? '') }}">
        
        <div class="flex flex-wrap gap-3">
            <button 
                type="button" 
                id="choose-location-btn"
                onclick="openLocationModal()"
                class="flex-1 min-w-[200px] group relative px-6 py-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-indigo-700 to-purple-700 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                <div class="relative flex items-center justify-center gap-3">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                    <span class="text-lg">Choose Deal Location on Map</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </div>
            </button>
            
            <button 
                type="button" 
                id="clear-location-btn"
                onclick="clearLocation()"
                class="px-6 py-4 bg-white border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 hover:border-gray-400 hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Clear Location
            </button>
        </div>
        
        <div id="location-status" class="mt-4"></div>
    </div>
    
    <!-- Info Box -->
    <div class="mt-4 bg-blue-50 border-l-4 border-blue-500 rounded-r-xl p-4 flex items-start gap-3">
        <svg class="w-6 h-6 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="text-sm text-blue-800">
            <p class="font-semibold mb-1">💡 How to add location:</p>
            <ul class="space-y-1 text-blue-700">
                <li>• Click the button above to open the interactive map</li>
                <li>• Search for areas in Damascus (Arabic or English)</li>
                <li>• Click on the map to place a marker</li>
                <li>• Confirm and return to save the location</li>
            </ul>
        </div>
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
        <input type="datetime-local" name="start_date" value="{{ old('start_date', (isset($deal)? optional($deal->start_date)->format('Y-m-d\TH:i'): '')) }}" required class="w-full px-4 py-2 border rounded-lg">
        @error('start_date')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block mb-2">End Date *</label>
        <input type="datetime-local" name="end_date" value="{{ old('end_date', (isset($deal)? optional($deal->end_date)->format('Y-m-d\TH:i'): '')) }}" required class="w-full px-4 py-2 border rounded-lg">
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
        <p class="text-xs text-gray-500 mt-1">Max 100MB. Supported formats: MP4, AVI, MOV, WMV, FLV, WEBM</p>
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
            <p class="text-sm text-gray-600 mb-3">💡 The primary image will be shown on the home page and deal listings</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($deal->images as $image)
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $image->image_url) }}" alt="Deal Image" class="w-full h-32 object-cover rounded-lg border-2 shadow-sm {{ $image->is_primary ? 'border-green-500' : 'border-gray-200' }}">
                        
                        <!-- Primary Badge -->
                        @if($image->is_primary)
                            <span class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full font-semibold flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                Primary
                            </span>
                        @else
                            <!-- Set as Primary Button -->
                            <button 
                                type="button" 
                                onclick="setPrimaryImage({{ $image->id }}, {{ $deal->id }})"
                                class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-2 py-1 rounded-full font-semibold opacity-0 group-hover:opacity-100 transition-opacity hover:bg-blue-600 flex items-center gap-1"
                            >
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                Set Primary
                            </button>
                        @endif
                        
                        <!-- Delete Button -->
                        <button 
                            type="button" 
                            onclick="deleteImage({{ $image->id }}, '{{ route('deal-images.destroy', $image) }}')" 
                            class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded hover:bg-red-600 transition opacity-0 group-hover:opacity-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Image Upload Area with Preview -->
    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 bg-white hover:border-brand-500 transition-colors">
        <h4 class="font-medium mb-3 text-gray-700">Upload New Images</h4>
        
        <!-- Hidden input to store primary index -->
        <input type="hidden" name="primary_index" :value="primaryIndex">
        
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
            <p class="text-sm text-gray-500">Multiple images supported (PNG, JPG, WEBP, max 20MB each)</p>
        </div>
        
        {{-- Display validation errors for images --}}
        @error('images')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror
        @error('images.*')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

        <!-- Preview Gallery -->
        <div x-show="previewImages.length > 0" class="mt-6">
            <h5 class="font-medium mb-3 text-gray-700">Preview (<span x-text="previewImages.length"></span> images)</h5>
            <p class="text-sm text-gray-600 mb-3">💡 Click on an image to set it as primary (will be shown on home page)</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <template x-for="(image, index) in previewImages" :key="index">
                    <div class="relative group cursor-pointer" @click="setPrimaryPreview(index)">
                        <img :src="image.preview" :alt="'Preview ' + (index + 1)" 
                             :class="primaryIndex === index ? 'border-green-500 border-4' : 'border-gray-200 border-2'"
                             class="w-full h-32 object-cover rounded-lg shadow-sm transition-all">
                        
                        <!-- Primary Badge -->
                        <div x-show="primaryIndex === index" class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full font-semibold flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            Primary
                        </div>
                        
                        <!-- Set Primary Hint -->
                        <div x-show="primaryIndex !== index" class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-2 py-1 rounded-full font-semibold opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            Click to set primary
                        </div>
                        
                        <!-- Delete Button -->
                        <button 
                            @click.stop="removeImage(index)"
                            type="button"
                            class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded hover:bg-red-600 transition opacity-0 group-hover:opacity-100"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Set primary image for existing images
function setPrimaryImage(imageId, dealId) {
    if (!confirm('Set this image as primary? It will be shown on the home page.')) {
        return;
    }
    
    // Create a form to submit the request
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/deal-images/${imageId}/set-primary`;
    form.style.display = 'none';
    
    // Add CSRF token
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    form.appendChild(csrfInput);
    
    // Append form to body and submit
    document.body.appendChild(form);
    form.submit();
}

// Delete image function
function deleteImage(imageId, deleteUrl) {
    if (!confirm('Are you sure you want to delete this image?')) {
        return;
    }
    
    // Create a hidden form to submit DELETE request
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = deleteUrl;
    form.style.display = 'none';
    
    // Add CSRF token
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    form.appendChild(csrfInput);
    
    // Add DELETE method
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'DELETE';
    form.appendChild(methodInput);
    
    // Append form to body and submit
    document.body.appendChild(form);
    form.submit();
}

// Image gallery Alpine.js component
function imageGallery() {
    return {
        previewImages: [],
        isDragging: false,
        primaryIndex: 0, // First image is primary by default
        
        handleFiles(files) {
            const validFiles = Array.from(files).filter(file => file.type.startsWith('image/'));
            
            validFiles.forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.previewImages.push({
                        file: file,
                        preview: e.target.result
                    });
                };
                reader.readAsDataURL(file);
            });
        },
        
        handleDrop(event) {
            this.isDragging = false;
            const files = event.dataTransfer.files;
            this.handleFiles(files);
        },
        
        removeImage(index) {
            this.previewImages.splice(index, 1);
            
            // Adjust primary index if needed
            if (this.primaryIndex === index) {
                this.primaryIndex = 0; // Reset to first image
            } else if (this.primaryIndex > index) {
                this.primaryIndex--; // Adjust if primary was after deleted image
            }
            
            // Update file input
            const input = document.getElementById('deal-images-input');
            if (input && this.previewImages.length === 0) {
                input.value = '';
            }
        },
        
        setPrimaryPreview(index) {
            this.primaryIndex = index;
            console.log('Primary image set to index:', index);
        }
    }
}

// Location button functionality (for clearing location)
document.addEventListener('DOMContentLoaded', function() {
    console.log('Location button script loaded');
    
    const chooseLocationBtn = document.getElementById('choose-location-btn');
    const clearLocationBtn = document.getElementById('clear-location-btn');
    const locationNameField = document.getElementById('location-name-field');
    const areaField = document.getElementById('area-field');
    const latitudeField = document.getElementById('latitude-field');
    const longitudeField = document.getElementById('longitude-field');
    const coordinatesDisplay = document.getElementById('coordinates-display');
    const locationStatus = document.getElementById('location-status');
    
    console.log('Choose location button found:', chooseLocationBtn !== null);
    console.log('Clear location button found:', clearLocationBtn !== null);
    
    // Load location data from session storage on page load
    function loadLocationData() {
        const locationData = sessionStorage.getItem('dealLocation');
        if (locationData) {
            console.log('Loading location data...');
            const data = JSON.parse(locationData);
            
            if (data.location_name) {
                locationNameField.value = data.location_name;
            }
            if (data.area) {
                areaField.value = data.area;
            }
            if (data.latitude && data.longitude) {
                latitudeField.value = data.latitude;
                longitudeField.value = data.longitude;
                coordinatesDisplay.value = `${data.latitude}, ${data.longitude}`;
                
                locationStatus.innerHTML = `
                    <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-r-xl shadow-sm animate-fade-in">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-green-800">✓ Location Successfully Selected!</p>
                                <p class="text-xs text-green-700 mt-1">
                                    ${data.location_name ? '<strong>' + data.location_name + '</strong> - ' : ''}
                                    Coordinates: ${data.latitude}, ${data.longitude}
                                </p>
                            </div>
                        </div>
                    </div>
                `;
            }
            
            // Clear location data after loading
            sessionStorage.removeItem('dealLocation');
            console.log('Location data loaded and cleared from session');
        }
    }
    
    // Load location data on page load
    loadLocationData();
    
    /* OLD CODE COMMENTED OUT - NOW USING MODAL APPROACH
    // Choose location button
    if (chooseLocationBtn) {
        console.log('Attaching click handler to choose location button');
        chooseLocationBtn.addEventListener('click', function(e) {
            console.log('Choose location button clicked!');
            e.preventDefault();
            // ... old code removed ...
        });
    } else {
        console.error('Choose location button not found!');
    }
    */
    
    // Clear location button
    if (clearLocationBtn) {
        clearLocationBtn.addEventListener('click', function() {
            locationNameField.value = '';
            areaField.value = '';
            latitudeField.value = '';
            longitudeField.value = '';
            coordinatesDisplay.value = '';
            locationStatus.innerHTML = '';
            
            // Clear session storage
            sessionStorage.removeItem('dealLocation');
        });
    }
});
</script>
@endpush

@push('styles')
@endpush


<script>
// Auto-calculate discount percentage
document.addEventListener('DOMContentLoaded', function() {
    const originalPriceInput = document.getElementById('original_price');
    const discountedPriceInput = document.getElementById('discounted_price');
    const discountPercentageInput = document.getElementById('discount_percentage');

    function calculateDiscountPercentage() {
        const originalPrice = parseFloat(originalPriceInput.value) || 0;
        const discountedPrice = parseFloat(discountedPriceInput.value) || 0;

        if (originalPrice > 0 && discountedPrice >= 0 && discountedPrice <= originalPrice) {
            const discount = ((originalPrice - discountedPrice) / originalPrice) * 100;
            discountPercentageInput.value = discount.toFixed(2);
        } else {
            discountPercentageInput.value = '';
        }
    }

    // Calculate on page load if values exist
    if (originalPriceInput && discountedPriceInput && originalPriceInput.value && discountedPriceInput.value) {
        calculateDiscountPercentage();
    }

    // Calculate when original price changes
    if (originalPriceInput) {
        originalPriceInput.addEventListener('input', calculateDiscountPercentage);
        originalPriceInput.addEventListener('change', calculateDiscountPercentage);
    }

    // Calculate when discounted price changes
    if (discountedPriceInput) {
        discountedPriceInput.addEventListener('input', calculateDiscountPercentage);
        discountedPriceInput.addEventListener('change', calculateDiscountPercentage);
    }
});
</script>

