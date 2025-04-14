<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class House extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'title',
        'description',
        'price',
        'location',
        'type',
        'status',
        'image_url',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function requests()
    {
        return $this->hasMany(HouseRequest::class);
    }

    public function isAvailable()
    {
        return $this->status === 'available';
    }
}