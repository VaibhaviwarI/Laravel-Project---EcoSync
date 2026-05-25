<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecyclingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'material_type',
        'estimated_weight',
        'status',
        'points_awarded',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
