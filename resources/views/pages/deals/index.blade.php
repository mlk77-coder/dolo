@extends('layouts.admin')
@section('content')
    <x-common.page-breadcrumb pageTitle="Deals" />
    <x-common.component-card>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">All Deals</h2>
            <div class="flex gap-2">
                <a href="{{ route('deals.export-csv', request()->all()) }}" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export CSV
                </a>
                <a href="{{ route('deals.create') }}" class="px-4 py-2 bg-brand-500 text-white rounded-lg">Add Deal</a>
            </div>
        </div>

        <form method="GET" class="flex flex-wrap gap-3 mb-4 items-end">
            <div>
                <label class="block text-xs text-gray-600 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" class="px-3 py-2 border rounded-lg" placeholder="Title, SKU, or city">
            </div>
            <div>
                <label class="block text-xs text-gray-600 mb-1">Status</label>
                <select name="status" class="px-3 py-2 border rounded-lg">
                    <option value="">All</option>
                    @foreach(['draft','active','inactive','expired'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-600 mb-1">Category</label>
                <select name="category_id" class="px-3 py-2 border rounded-lg">
                    <option value="">All</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-600 mb-1">Merchant</label>
                <select name="merchant_id" class="px-3 py-2 border rounded-lg">
                    <option value="">All</option>
                    @foreach($merchants ?? [] as $merchant)
                        <option value="{{ $merchant->id }}" @selected(request('merchant_id') == $merchant->id)>{{ $merchant->business_name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="px-4 py-2 bg-gray-200 rounded-lg">Filter</button>
        </form>

        <div class="overflow-x-auto" 
             x-data="sortableTable()"
             @dragover.prevent
             @drop.prevent="handleDrop($event)">
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left w-8"></th>
                        <th class="px-5 py-3 text-left">Title</th>
                        <th class="px-5 py-3 text-left">SKU</th>
                        <th class="px-5 py-3 text-left">Merchant</th>
                        <th class="px-5 py-3 text-left">Category</th>
                        <th class="px-5 py-3 text-left">City</th>
                        <th class="px-5 py-3 text-left">Area</th>
                        <th class="px-5 py-3 text-left">Price</th>
                        <th class="px-5 py-3 text-left">Buyers</th>
                        <th class="px-5 py-3 text-left">Status</th>
                        <th class="px-5 py-3 text-left">Period</th>
                        <th class="px-5 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deals as $deal)
                        <tr 
                            class="border-b border-gray-100 cursor-move hover:bg-gray-50 transition-colors"
                            draggable="true"
                            data-deal-id="{{ $deal->id }}"
                            @dragstart="handleDragStart($event, {{ $deal->id }})"
                            @dragover.prevent="handleDragOver($event)"
                            @dragenter.prevent="handleDragEnter($event)"
                            @dragleave.prevent="handleDragLeave($event)"
                            @drop.prevent="handleRowDrop($event, {{ $deal->id }})"
                            :class="{ 'opacity-50': draggedId === {{ $deal->id }}, 'bg-blue-50 border-blue-300': dragOverId === {{ $deal->id }} }"
                        >
                            <td class="px-2 py-4 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                </svg>
                            </td>
                            <td class="px-5 py-4 font-medium">{{ $deal->title_en }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $deal->sku ?? '—' }}</td>
                            <td class="px-5 py-4">{{ $deal->merchant->business_name ?? '—' }}</td>
                            <td class="px-5 py-4">{{ $deal->category->name ?? '—' }}</td>
                            <td class="px-5 py-4">{{ $deal->city ?? '—' }}</td>
                            <td class="px-5 py-4">{{ $deal->area ?? '—' }}</td>
                            <td class="px-5 py-4">
                                <div class="text-sm">
                                    <span class="line-through text-gray-400">${{ number_format($deal->original_price, 2) }}</span>
                                    <span class="font-semibold text-green-600 ml-1">${{ number_format($deal->discounted_price, 2) }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-sm">{{ $deal->buyer_counter ?? 0 }}</span>
                                @if($deal->show_buyer_counter)
                                    <span class="text-xs text-green-600">(visible)</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <span class="px-2 py-1 text-xs rounded {{ $deal->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">{{ ucfirst($deal->status) }}</span>
                            </td>
                            <td class="px-5 py-4 text-sm">
                                {{ optional($deal->start_date)->format('M d') }} - {{ optional($deal->end_date)->format('M d, Y') }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('deals.show', $deal) }}" class="text-blue-500">View</a>
                                    <a href="{{ route('deals.edit', $deal) }}" class="text-yellow-500">Edit</a>
                                    <form action="{{ route('deals.destroy', $deal) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="11" class="px-5 py-8 text-center">No deals found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $deals->links() }}</div>
    </x-common.component-card>
@endsection

@push('scripts')
<script>
function sortableTable() {
    return {
        draggedId: null,
        dragOverId: null,
        deals: @json($deals->map(function($deal) { return ['id' => $deal->id, 'sort_order' => $deal->sort_order ?? 0]; })),
        
        handleDragStart(event, dealId) {
            this.draggedId = dealId;
            event.dataTransfer.effectAllowed = 'move';
            event.dataTransfer.setData('text/html', event.target);
            event.target.style.opacity = '0.5';
        },
        
        handleDragOver(event) {
            if (event.preventDefault) {
                event.preventDefault();
            }
            event.dataTransfer.dropEffect = 'move';
            return false;
        },
        
        handleDragEnter(event) {
            const row = event.currentTarget;
            const dealId = parseInt(row.dataset.dealId);
            if (dealId !== this.draggedId) {
                this.dragOverId = dealId;
            }
        },
        
        handleDragLeave(event) {
            const row = event.currentTarget;
            const dealId = parseInt(row.dataset.dealId);
            if (dealId !== this.dragOverId) {
                this.dragOverId = null;
            }
        },
        
        handleRowDrop(event, targetDealId) {
            event.preventDefault();
            const sourceDealId = this.draggedId;
            
            if (sourceDealId === targetDealId) {
                this.resetDragState();
                return;
            }
            
            // Find source and target indices in the deals array
            const sourceIndex = this.deals.findIndex(d => d.id === sourceDealId);
            const targetIndex = this.deals.findIndex(d => d.id === targetDealId);
            
            if (sourceIndex === -1 || targetIndex === -1) {
                this.resetDragState();
                return;
            }
            
            // Get the actual table rows
            const tbody = event.currentTarget.closest('tbody');
            if (!tbody) {
                this.resetDragState();
                return;
            }
            
            const rows = Array.from(tbody.querySelectorAll('tr[draggable="true"]'));
            const sourceRow = rows.find(row => parseInt(row.dataset.dealId) === sourceDealId);
            const targetRow = rows.find(row => parseInt(row.dataset.dealId) === targetDealId);
            
            if (!sourceRow || !targetRow) {
                this.resetDragState();
                return;
            }
            
            // Reorder array
            const [removed] = this.deals.splice(sourceIndex, 1);
            this.deals.splice(targetIndex, 0, removed);
            
            // Calculate new sort orders based on current page position
            // We'll use the current sort_order as base and adjust relative positions
            const baseSortOrder = Math.min(...this.deals.map(d => d.sort_order));
            this.deals.forEach((deal, index) => {
                deal.sort_order = baseSortOrder + index;
            });
            
            // Reorder DOM elements immediately
            if (sourceIndex < targetIndex) {
                // Moving down: insert after target
                targetRow.parentNode.insertBefore(sourceRow, targetRow.nextSibling);
            } else {
                // Moving up: insert before target
                targetRow.parentNode.insertBefore(sourceRow, targetRow);
            }
            
            // Send update to server
            this.updateSortOrder();
            
            this.resetDragState();
        },
        
        handleDrop(event) {
            this.resetDragState();
        },
        
        resetDragState() {
            this.draggedId = null;
            this.dragOverId = null;
            document.querySelectorAll('tr[draggable="true"]').forEach(row => {
                row.style.opacity = '';
            });
        },
        
        async updateSortOrder() {
            try {
                const response = await fetch('{{ route("deals.update-sort-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        deals: this.deals.map(deal => ({
                            id: deal.id,
                            sort_order: deal.sort_order
                        }))
                    })
                });
                
                if (response.ok) {
                    const data = await response.json();
                    // Show success message
                    this.showNotification('Sort order updated successfully', 'success');
                } else {
                    const errorData = await response.json();
                    this.showNotification('Failed to update sort order', 'error');
                    console.error('Failed to update sort order:', errorData);
                }
            } catch (error) {
                this.showNotification('Error updating sort order', 'error');
                console.error('Error updating sort order:', error);
            }
        },
        
        showNotification(message, type) {
            // Create a simple notification
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-4 py-2 rounded-lg shadow-lg z-50 ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    }
}
</script>
@endpush

