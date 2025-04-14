<?php

namespace App\Http\Controllers;

use App\Models\HouseRequest;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        // Get total houses
        $totalHouses = $user->houses()->count();

        // Get houses by status
        $availableHouses = $user->houses()->where('status', 'available')->count();
        $soldHouses = $user->houses()->where('status', 'sold')->count();
        $rentedHouses = $user->houses()->where('status', 'rented')->count();

        // Get houses by type
        $housesForSale = $user->houses()->where('type', 'sale')->count();
        $housesForRent = $user->houses()->where('type', 'rent')->count();

        // Get total requests
        $totalRequests = HouseRequest::whereHas('house', function ($query) {
            $query->where('seller_id', auth()->id());
        })->count();

        // Get requests by status
        $pendingRequests = HouseRequest::whereHas('house', function ($query) {
            $query->where('seller_id', auth()->id());
        })->where('status', 'pending')->count();

        $acceptedRequests = HouseRequest::whereHas('house', function ($query) {
            $query->where('seller_id', auth()->id());
        })->where('status', 'accepted')->count();

        // Get recent requests for the table
        $requests = HouseRequest::whereHas('house', function ($query) {
            $query->where('seller_id', auth()->id());
        })->with(['buyer', 'house'])->latest()->paginate(10);

        return view('seller.dashboard', compact(
            'requests',
            'totalHouses',
            'availableHouses',
            'soldHouses',
            'rentedHouses',
            'housesForSale',
            'housesForRent',
            'totalRequests',
            'pendingRequests',
            'acceptedRequests'
        ));
    }
}