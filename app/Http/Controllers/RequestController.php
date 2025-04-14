<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\HouseRequest;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    /**
     * Display a listing of the requests.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->isBuyer()) {
            $requests = $user->requests()->with('house.seller')->latest()->paginate(10);
            return view('requests.buyer-index', compact('requests'));
        }

        // For sellers, show requests for their houses
        $requests = HouseRequest::whereHas('house', function ($query) use ($user) {
            $query->where('seller_id', $user->id);
        })->with(['buyer', 'house'])->latest()->paginate(10);

        return view('requests.seller-index', compact('requests'));
    }

    /**
     * Store a newly created request in storage.
     */
    public function store(Request $request, House $house)
    {
        // Validate request
        $request->validate([
            'message' => 'nullable|string|max:500',
        ]);

        // Check if house is available
        if (!$house->isAvailable()) {
            return back()->with('error', 'This house is no longer available.');
        }

        // Create request
        $houseRequest = new HouseRequest([
            'buyer_id' => auth()->id(),
            'house_id' => $house->id,
            'message' => $request->message,
        ]);

        $houseRequest->save();

        return redirect()->route('requests.index')
            ->with('success', 'Your request has been sent successfully.');
    }

    /**
     * Update the request status.
     */
    public function update(Request $request, HouseRequest $houseRequest)
    {
        // Load the house relationship first
        $houseRequest->load('house');

        // Check if the house exists
        if (!$houseRequest->house) {
            abort(404, 'House not found');
        }

        // Ensure the user is the seller of the house
        if (auth()->id() !== $houseRequest->house->seller_id) {
            return back()->with('error', 'Unauthorized action.');
        }

        // Validate status
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $houseRequest->update(['status' => $request->status]);

        // If request is accepted, update house status
        if ($request->status === 'accepted') {
            $house = $houseRequest->house;
            $house->status = $house->type === 'rent' ? 'rented' : 'sold';
            $house->save();

            // Reject all other pending requests for this house
            HouseRequest::where('house_id', $house->id)
                ->where('id', '!=', $houseRequest->id)
                ->where('status', 'pending')
                ->update(['status' => 'rejected']);
        }

        return back()->with('success', 'Request has been ' . $request->status . ' successfully.');
    }

    /**
     * Display the specified request.
     */
    public function show(HouseRequest $request)
    {
        // Load the relationships
        $request->load(['house', 'buyer']);

        // Check if the user is authorized to view this request
        if (
            auth()->id() !== $request->buyer_id &&
            auth()->id() !== $request->house->seller_id
        ) {
            abort(403, 'Unauthorized action.');
        }

        return view('requests.show', ['houseRequest' => $request]);
    }
}