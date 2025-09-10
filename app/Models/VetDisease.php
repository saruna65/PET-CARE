<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VetDisease extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'user_id',
        'image_path',
        'primary_diagnosis',
        'confidence_score',
        'results',
        'is_reviewed',
        'detection_reason',
        // New fields for vet review
        'vet_diagnosis',
        'vet_treatment',
        'vet_notes',
        'is_critical',
        'reviewed_at',
        'reviewed_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'results' => 'array',
        'confidence_score' => 'float',
        'is_reviewed' => 'boolean',
        'is_critical' => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the pet that owns the disease detection
     */
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    /**
     * Get the user that owns the disease detection
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the vet who reviewed this case
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}