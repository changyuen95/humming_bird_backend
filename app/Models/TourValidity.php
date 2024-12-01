<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourValidity extends Model
{
    use HasFactory;

    protected $table = 'tour_validity'; // This line was corrected to use the "protected" visibility modifier

    protected $fillable = [
        'tour_id',
        'validity',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
