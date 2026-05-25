<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanitationReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category',
        'location',
        'description',
        'priority',
        'status',
        'assigned_staff',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
