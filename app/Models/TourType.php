<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourType extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'type',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
