@extends('layouts.app')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <!-- Search and Filter Form -->
        <form method="GET" action="{{ route('houses.index') }}" class="mb-8" id="searchForm">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" name="location" id="location" value="{{ request('location') }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Enter location">
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                    <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">All Types</option>
                        <option value="rent" {{ request('type') === 'rent' ? 'selected' : '' }}>For Rent</option>
                        <option value="sale" {{ request('type') === 'sale' ? 'selected' : '' }}>For Sale</option>
                    </select>
                </div>

                <div>
                    <label for="min_price" class="block text-sm font-medium text-gray-700">Min Price</label>
                    <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        min="0" step="0.01">
                </div>

                <div>
                    <label for="max_price" class="block text-sm font-medium text-gray-700">Max Price</label>
                    <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        min="0" step="0.01">
                </div>
            </div>

            <div class="mt-4 flex justify-between items-center">
                <div>
                    <label for="sort" class="text-sm font-medium text-gray-700">Sort by:</label>
                    <select name="sort" id="sort" class="ml-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Price (Low to High)</option>
                        <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Price (High to Low)</option>
                    </select>
                </div>

                <button type="submit" id="filterButton" class="inline-flex items-center justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span id="buttonText" class="flex items-center justify-center">Apply Filters</span>
                    <div id="loadingSpinner" class="loader ml-2" style="display: none;"></div>
                </button>
            </div>
        </form>

        <!-- Houses Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($houses as $house)
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <img src="{{ $house->image_url ?? 'https://via.placeholder.com/300x200' }}" alt="{{ $house->title }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $house->title }}</h3>
                        <p class="text-sm text-gray-500">{{ $house->location }}</p>
                        <div class="mt-2 flex justify-between items-center">
                            <span class="text-lg font-bold text-indigo-600">${{ number_format($house->price) }}</span>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $house->type === 'rent' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $house->type === 'rent' ? 'For Rent' : 'For Sale' }}
                            </span>
                        </div>
                        <a href="{{ route('houses.show', $house) }}" class="mt-4 block w-full text-center bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition duration-150 ease-in-out">
                            View Details
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-8">
                    <p class="text-gray-500">No houses found.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $houses->links() }}
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('searchForm');
        const button = document.getElementById('filterButton');
        const buttonText = document.getElementById('buttonText');
        const loadingSpinner = document.getElementById('loadingSpinner');
        
        form.addEventListener('submit', function(e) {
            // Prevent immediate form submission
            e.preventDefault();
            
            // Disable the button
            button.disabled = true;
            
            // Show loading spinner
            buttonText.textContent = 'Searching...';
            loadingSpinner.style.display = 'grid';
            
            // Add a delay to show the spinner properly
            setTimeout(function() {
                form.submit();
            }, 800);
        });
    });
</script>

<style>
/* Modern CSS-based loader */
.loader {
  width: 20px;
  aspect-ratio: 1;
  display: grid;
  border-radius: 50%;
  background:
    linear-gradient(0deg ,rgb(255 255 255/50%) 30%,#0000 0 70%,rgb(255 255 255/100%) 0) 50%/8% 100%,
    linear-gradient(90deg,rgb(255 255 255/25%) 30%,#0000 0 70%,rgb(255 255 255/75% ) 0) 50%/100% 8%;
  background-repeat: no-repeat;
  animation: l23 1s infinite steps(12);
}
.loader::before,
.loader::after {
   content: "";
   grid-area: 1/1;
   border-radius: 50%;
   background: inherit;
   opacity: 0.915;
   transform: rotate(30deg);
}
.loader::after {
   opacity: 0.83;
   transform: rotate(60deg);
}
@keyframes l23 {
  100% {transform: rotate(1turn)}
}
</style>
@endsection 