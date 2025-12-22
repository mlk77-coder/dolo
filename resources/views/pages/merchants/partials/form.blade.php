<div class="grid md:grid-cols-2 gap-6">
    <div>
        <label class="block mb-2">Business Name *</label>
        <input type="text" name="business_name" value="{{ old('business_name', $merchant->business_name ?? '') }}" required class="w-full px-4 py-2 border rounded-lg">
        @error('business_name')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block mb-2">Owner Name</label>
        <input type="text" name="owner_name" value="{{ old('owner_name', $merchant->owner_name ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
        @error('owner_name')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block mb-2">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $merchant->phone ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
        @error('phone')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block mb-2">Email</label>
        <input type="email" name="email" value="{{ old('email', $merchant->email ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
        @error('email')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block mb-2">Address</label>
        <input type="text" name="address" value="{{ old('address', $merchant->address ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
        @error('address')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block mb-2">City</label>
        <input type="text" name="city" value="{{ old('city', $merchant->city ?? '') }}" class="w-full px-4 py-2 border rounded-lg">
        @error('city')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block mb-2">Status *</label>
        <select name="status" class="w-full px-4 py-2 border rounded-lg">
            @foreach(['pending','active','inactive'] as $status)
                <option value="{{ $status }}" @selected(old('status', $merchant->status ?? '') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        @error('status')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div class="md:col-span-2">
        <label class="block mb-2">Description</label>
        <textarea name="description" rows="3" class="w-full px-4 py-2 border rounded-lg">{{ old('description', $merchant->description ?? '') }}</textarea>
        @error('description')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
    <div class="md:col-span-2">
        <label class="block mb-2">Documents (one per line)</label>
        <textarea name="documents[]" rows="3" class="w-full px-4 py-2 border rounded-lg" placeholder="http://... or note">{{ old('documents.0', is_array($merchant->documents ?? null) ? implode(PHP_EOL, $merchant->documents) : '') }}</textarea>
        @error('documents')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
    </div>
</div>

