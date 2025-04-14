@extends('layouts.app')

@section('title', 'Property Requests')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="h3">
            @if(auth()->user()->role === 'seller')
                Received Requests
            @else
                My Requests
            @endif
        </h2>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>House</th>
                @if(auth()->user()->role === 'seller')
                    <th>Buyer</th>
                @endif
                <th>Type</th>
                <th>Price</th>
                <th>Message</th>
                <th>Status</th>
                <th>Date</th>
                @if(auth()->user()->role === 'seller')
                    <th>Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $request)
                <tr>
                    <td>
                        <a href="{{ route('houses.show', $request->house) }}" class="text-decoration-none">
                            {{ $request->house->title }}
                        </a>
                    </td>
                    @if(auth()->user()->role === 'seller')
                        <td>
                            {{ $request->buyer->name }}
                            <div class="small text-muted">{{ $request->buyer->email }}</div>
                        </td>
                    @endif
                    <td>
                        <span class="badge bg-primary">
                            {{ ucfirst($request->house->type) }}
                        </span>
                    </td>
                    <td>${{ number_format($request->house->price, 2) }}</td>
                    <td>{{ $request->message ?? 'No message' }}</td>
                    <td>
                        <span class="badge 
                            @if($request->status === 'pending') bg-warning
                            @elseif($request->status === 'accepted') bg-success
                            @else bg-danger
                            @endif">
                            {{ ucfirst($request->status) }}
                        </span>
                    </td>
                    <td>{{ $request->created_at->format('M d, Y') }}</td>
                    @if(auth()->user()->role === 'seller' && $request->status === 'pending')
                        <td>
                            <form action="{{ route('requests.update', $request) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="accepted">
                                <button type="submit" class="btn btn-sm btn-success">Accept</button>
                            </form>
                            <form action="{{ route('requests.update', $request) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ auth()->user()->role === 'seller' ? 8 : 7 }}" class="text-center">
                        No requests found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="row mt-4">
    <div class="col-12">
        {{ $requests->links() }}
    </div>
</div>
@endsection 