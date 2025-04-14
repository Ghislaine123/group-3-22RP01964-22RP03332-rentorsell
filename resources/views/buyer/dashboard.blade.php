@extends('layouts.app')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Buyer Dashboard</h1>

                <!-- My Requests Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">My Requests</h2>
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <ul role="list" class="divide-y divide-gray-200">
                            @forelse(auth()->user()->requests()->with('house')->latest()->take(5)->get() as $request)
                                <li>
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                @if($request->house->image_url)
                                                    <img src="{{ asset($request->house->image_url) }}" alt="{{ $request->house->title }}" class="h-16 w-16 object-cover rounded-md mr-4">
                                                @else
                                                    <div class="h-16 w-16 bg-gray-200 rounded-md mr-4 flex items-center justify-center">
                                                        <span class="text-gray-500 text-xs">No Image</span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <p class="text-sm font-medium text-indigo-600 truncate">
                                                        {{ $request->house->title }}
                                                    </p>
                                                    <p class="mt-1 text-sm text-gray-500">
                                                        {{ $request->house->location }} • ${{ number_format($request->house->price, 2) }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ 
                                                    $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                    ($request->status === 'accepted' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') 
                                                }}">
                                                    {{ ucfirst($request->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        @if($request->message)
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500">{{ $request->message }}</p>
                                            </div>
                                        @endif
                                        <div class="mt-2 text-sm text-gray-500">
                                            Requested {{ $request->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="px-4 py-4 sm:px-6">
                                    <p class="text-gray-500 text-sm">You haven't made any requests yet.</p>
                                </li>
                            @endforelse
                        </ul>
                        @if(auth()->user()->requests()->count() > 5)
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <a href="{{ route('requests.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                    View all requests <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Available Houses Section -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">Available Houses</h2>
                        <a href="{{ route('houses.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                            View all houses <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse(App\Models\House::where('status', 'available')->latest()->take(6)->get() as $house)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                @if($house->image_url)
                                    <img src="{{ asset($house->image_url) }}" alt="{{ $house->title }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-500">No Image</span>
                                    </div>
                                @endif
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $house->title }}</h3>
                                    <p class="text-gray-600 mb-2 truncate">{{ $house->description }}</p>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-gray-700">{{ $house->location }}</span>
                                        <span class="text-indigo-600 font-semibold">${{ number_format($house->price, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $house->type === 'rent' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ ucfirst($house->type) }}
                                        </span>
                                        <a href="{{ route('houses.show', $house) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full">
                                <p class="text-gray-500 text-sm">No houses available at the moment.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 