@extends('layouts.app')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- House Image -->
            <div>
                @if ($house->image_url)
                    <img src="{{ asset($house->image_url) }}" alt="{{ $house->title }}" class="w-full h-96 object-cover rounded-lg shadow-md">
                @else
                    <div class="w-full h-96 bg-gray-200 flex items-center justify-center rounded-lg">
                        <span class="text-gray-500">No Image</span>
                    </div>
                @endif
            </div>

            <!-- House Details -->
            <div>
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $house->title }}</h1>
                        <p class="mt-1 text-gray-500">Listed by {{ $house->seller->name }}</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $house->type === 'rent' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                        For {{ ucfirst($house->type) }}
                    </span>
                </div>

                <div class="mt-6">
                    <h2 class="text-lg font-medium text-gray-900">Price</h2>
                    <p class="mt-1 text-3xl font-semibold text-indigo-600">${{ number_format($house->price, 2) }}</p>
                </div>

                <div class="mt-6">
                    <h2 class="text-lg font-medium text-gray-900">Location</h2>
                    <p class="mt-1 text-gray-500">{{ $house->location }}</p>
                </div>

                <div class="mt-6">
                    <h2 class="text-lg font-medium text-gray-900">Description</h2>
                    <p class="mt-1 text-gray-500">{{ $house->description }}</p>
                </div>

                <div class="mt-8">
                    @auth
                        @if(auth()->user()->isBuyer() && $house->isAvailable())
                            <form action="{{ route('requests.store', $house) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="message" class="block text-sm font-medium text-gray-700">Message (Optional)</label>
                                    <textarea name="message" id="message" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Write a message to the seller..."></textarea>
                                </div>
                                <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Send Request
                                </button>
                            </form>
                        @elseif(auth()->user()->isSeller() && auth()->id() === $house->seller_id)
                            <div class="flex space-x-4">
                                <a href="{{ route('houses.edit', $house) }}" class="flex-1 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Edit House
                                </a>
                                <form action="{{ route('houses.destroy', $house) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to delete this house?')">
                                        Delete House
                                    </button>
                                </form>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Login to Send Request
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
