<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'destination',
        'image',
        'season',
        'from_date',
        'to_date',
        'days',
        'nights',
        'minimum_pax',
        'leader',
        'price',
        'total_fare',
        'additional_fare',
        'return_fare',
        'status',
    ];

    protected $with = ['images', 'itineraries', 'validity', 'paymentTerms', 'inclusions', 'exclusions', 'types'];

    protected $appends = ['tags'];
    public function images()
    {
        return $this->hasMany(TourImage::class);
    }

    public function itineraries()
    {
        return $this->hasMany(TourItinerary::class);
    }

    public function validity()
    {
        return $this->hasMany(TourValidity::class);
    }

    public function paymentTerms()
    {
        return $this->hasMany(TourPaymentTerm::class);
    }

    public function inclusions()
    {
        return $this->hasMany(TourInclusion::class);
    }

    public function exclusions()
    {
        return $this->hasMany(TourExclusion::class);
    }

    public function types()
    {
        return $this->hasMany(TourType::class);
    }

    public function getTagsAttribute()
    {
        $tags = [];
        $tags[] = $this->destination;
        $tags[] = $this->region;
        $tags[] = $this->season;
        $tags[] = $this->types->pluck('name');
        return implode(', ', $tags);
    }
}
