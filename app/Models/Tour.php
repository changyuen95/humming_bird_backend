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
        'region',
        'minimum_pax',
        'leader',
        'price',
        'total_fare',
        'additional_fare',
        'return_fare',
        'status',
    ];

    protected $with = [ 'itineraries', 'validity', 'paymentTerms', 'inclusions', 'exclusions', 'types'];
    protected $appends = ['images,tags'];




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
        $types = $this->types->pluck('type')->toArray();

        $tags[] = $this->destination;
        $tags[] = $this->region;
        $tags[] = $this->season;
        $tags = array_merge($types);
        return $tags;
    }

    public function getImageAttribute()
    {

        $image = $this->images->first();
        if ($image) {
            return $image->image;
        }
        return null;
    }

    public function getImagesAttribute()
{
    // Flatten the collection of images from all itineraries
    return $this->itineraries->flatMap(function ($itinerary) {
        return $itinerary->images;
    });
}

}
