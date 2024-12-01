<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourItineraryHighlight extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_itinerary_id',
        'highlight',
    ];

    public function itinerary()
    {
        return $this->belongsTo(TourItinerary::class);
    }
}
