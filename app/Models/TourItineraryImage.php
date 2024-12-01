<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourItineraryImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_itinerary_id',
        'image',
    ];

    public function itinerary()
    {
        return $this->belongsTo(TourItinerary::class);
    }
}
