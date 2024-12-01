<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourInclusion extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'inclusion',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
