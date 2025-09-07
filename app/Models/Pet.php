<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'pet_name',
        'pet_type',
        'pet_breed',
        'age',
        'sex',
        'allergies',
        'image_path',
    ];

    /**
     * Get the user that owns the pet.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the pet's age as a formatted string.
     *
     * @return string
     */
    public function getFormattedAgeAttribute(): string
    {
        return $this->age . ' ' . ($this->age == 1 ? 'year' : 'years');
    }

    /**
     * Get the pet's sex with first letter capitalized.
     *
     * @return string
     */
    public function getCapitalizedSexAttribute(): string
    {
        return ucfirst($this->sex);
    }

    /**
     * Get the pet's image URL.
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        
        return asset('images/default-pet.jpg');
    }
        /**
     * Get the disease detections for the pet.
     */
    public function diseaseDetections()
    {
        return $this->hasMany(DiseaseDetection::class);
    }
}