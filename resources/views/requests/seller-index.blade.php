@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-4">House Requests</h2>

                    @if($requests->isEmpty())
                        <p class="text-gray-500">No requests for your houses yet.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($requests as $request)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-semibold">{{ $request->house->title }}</h3>
                                            <p class="text-gray-600">From: {{ $request->buyer->name }}</p>
                                            <p class="text-gray-600">Status: 
                                                <span class="font-medium 
                                                    @if($request->status === 'pending') text-yellow-600
                                                    @elseif($request->status === 'accepted') text-green-600
                                                    @else text-red-600
                                                    @endif">
                                                    {{ ucfirst($request->status) }}
                                                </span>
                                            </p>
                                            @if($request->message)
                                                <p class="mt-2 text-gray-700">{{ $request->message }}</p>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $request->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    @if($request->status === 'pending')
                                        <div class="mt-4 flex space-x-2">
                                            <form action="{{ route('requests.update', $request) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="accepted">
                                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Accept</button>
                                            </form>
                                            <form action="{{ route('requests.update', $request) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Reject</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            {{ $requests->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection 