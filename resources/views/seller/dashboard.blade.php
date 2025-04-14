@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Seller Dashboard</h2>
                        <a href="{{ route('houses.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add New House
                        </a>
                    </div>

                    <!-- Dashboard Metrics -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                        <!-- Total Houses Card -->
                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Total Houses</p>
                                    <p class="text-lg font-semibold text-gray-700">{{ $totalHouses }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Available Houses Card -->
                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Available</p>
                                    <p class="text-lg font-semibold text-gray-700">{{ $availableHouses }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Total Requests Card -->
                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Total Requests</p>
                                    <p class="text-lg font-semibold text-gray-700">{{ $totalRequests }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card -->
                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Pending Requests</p>
                                    <p class="text-lg font-semibold text-gray-700">{{ $pendingRequests }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- House Type Distribution -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <h3 class="text-lg font-semibold mb-4">Houses by Type</h3>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-gray-600">For Sale</p>
                                    <p class="text-lg font-semibold">{{ $housesForSale }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">For Rent</p>
                                    <p class="text-lg font-semibold">{{ $housesForRent }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <h3 class="text-lg font-semibold mb-4">Houses by Status</h3>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-gray-600">Available</p>
                                    <p class="text-lg font-semibold">{{ $availableHouses }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Sold</p>
                                    <p class="text-lg font-semibold">{{ $soldHouses }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Rented</p>
                                    <p class="text-lg font-semibold">{{ $rentedHouses }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-xl font-semibold mb-4">Your Houses</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Title</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Price</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Requests</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(auth()->user()->houses as $house)
                                        <tr>
                                            <td class="px-6 py-4 border-b border-gray-200">
                                                <a href="{{ route('houses.show', $house) }}" class="text-blue-500 hover:text-blue-700">
                                                    {{ $house->title }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 border-b border-gray-200">
                                                <span class="px-2 py-1 text-sm rounded {{ $house->type === 'rent' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                                    {{ ucfirst($house->type) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 border-b border-gray-200">
                                                ${{ number_format($house->price) }}
                                            </td>
                                            <td class="px-6 py-4 border-b border-gray-200">
                                                <span class="px-2 py-1 text-sm rounded {{ $house->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ ucfirst($house->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 border-b border-gray-200">
                                                {{ $house->requests->count() }}
                                            </td>
                                            <td class="px-6 py-4 border-b border-gray-200">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('houses.edit', $house) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a>
                                                    <form action="{{ route('houses.destroy', $house) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this house?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-4 border-b border-gray-200 text-center text-gray-500">
                                                No houses listed yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold mb-4">Recent Requests</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">House</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Buyer</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Message</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($requests as $request)
                                        <tr>
                                            <td class="px-6 py-4 border-b border-gray-200">
                                                <a href="{{ route('houses.show', $request->house) }}" class="text-blue-500 hover:text-blue-700">
                                                    {{ $request->house->title }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 border-b border-gray-200">
                                                {{ $request->buyer->name }}
                                                <br>
                                                <span class="text-sm text-gray-500">{{ $request->buyer->phone }}</span>
                                            </td>
                                            <td class="px-6 py-4 border-b border-gray-200">
                                                {{ Str::limit($request->message, 50) }}
                                            </td>
                                            <td class="px-6 py-4 border-b border-gray-200">
                                                <span class="px-2 py-1 text-sm rounded
                                                    @if($request->isPending()) bg-yellow-100 text-yellow-800
                                                    @elseif($request->isAccepted()) bg-green-100 text-green-800
                                                    @else bg-red-100 text-red-800
                                                    @endif">
                                                    {{ ucfirst($request->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 border-b border-gray-200">
                                                {{ $request->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 border-b border-gray-200">
                                                @if($request->isPending())
                                                    <form action="{{ route('requests.update', [$request->house, $request]) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="accepted">
                                                        <button type="submit" class="text-green-500 hover:text-green-700 mr-2">Accept</button>
                                                    </form>
                                                    <form action="{{ route('requests.update', [$request->house, $request]) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="text-red-500 hover:text-red-700">Reject</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-4 border-b border-gray-200 text-center text-gray-500">
                                                No requests found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 