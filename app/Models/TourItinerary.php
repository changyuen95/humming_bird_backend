<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourItinerary extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'day',
        'title',
        'meal',
        'accommodation',
    ];

    protected $with = [
        'highlights',
        'images',
    ];

    // Relationship with TourItineraryHighlight
    public function highlights()
    {
        return $this->hasMany(TourItineraryHighlight::class);
    }

    // Relationship with TourItineraryImage
    public function images()
    {
        return $this->hasMany(TourItineraryImage::class);
    }
}
