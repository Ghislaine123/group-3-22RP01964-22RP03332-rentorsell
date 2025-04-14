@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Request Details</h2>
                    <p class="text-sm text-gray-500">Requested {{ $houseRequest->created_at->diffForHumans() }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">House Information</h3>
                        <div class="mt-4 space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Title</p>
                                <p class="mt-1 text-gray-900">{{ $houseRequest->house->title }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Price</p>
                                <p class="mt-1 text-gray-900">${{ number_format($houseRequest->house->price) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Location</p>
                                <p class="mt-1 text-gray-900">{{ $houseRequest->house->location }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Type</p>
                                <p class="mt-1 text-gray-900">{{ ucfirst($houseRequest->house->type) }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Request Information</h3>
                        <div class="mt-4 space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Status</p>
                                <p class="mt-1">
                                    <span class="px-2 py-1 text-sm rounded
                                        @if($houseRequest->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($houseRequest->status === 'accepted') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($houseRequest->status) }}
                                    </span>
                                </p>
                            </div>
                            @if($houseRequest->message)
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Message</p>
                                    <p class="mt-1 text-gray-900">{{ $houseRequest->message }}</p>
                                </div>
                            @endif
                            <div>
                                <p class="text-sm font-medium text-gray-500">{{ auth()->user()->isBuyer() ? 'Seller' : 'Buyer' }}</p>
                                <p class="mt-1 text-gray-900">{{ auth()->user()->isBuyer() ? $houseRequest->house->seller->name : $houseRequest->buyer->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if(auth()->user()->isSeller() && $houseRequest->status === 'pending')
                    <div class="mt-8 flex space-x-4">
                        <form action="{{ route('requests.update', $houseRequest) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="accepted">
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Accept Request</button>
                        </form>
                        <form action="{{ route('requests.update', $houseRequest) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Reject Request</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 