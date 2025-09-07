<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'clinic_name',
        'specialization',
        'experience_years',
        'qualification',
        'license_number',
        'biography',
        'services_offered',
        'address',
        'city',
        'state',
        'zip_code',
        'phone_number',
        'website',
        'consultation_fee',
        'image_path',
        'is_available',
        'availability_hours',
        'is_verified'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'experience_years' => 'integer',
        'is_available' => 'boolean',
        'is_verified' => 'boolean',
        'services_offered' => 'array',
        'availability_hours' => 'array',
        'consultation_fee' => 'float'
    ];

    /**
     * Get the user that owns the vet profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the image URL.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        
        return asset('images/default-vet.png');
    }

    /**
     * Get formatted availability.
     */
    public function getFormattedAvailabilityAttribute(): array
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $formattedAvailability = [];
        
        if ($this->availability_hours) {
            foreach ($days as $day) {
                $formattedAvailability[$day] = $this->availability_hours[$day] ?? 'Not Available';
            }
        } else {
            foreach ($days as $day) {
                $formattedAvailability[$day] = 'Not Available';
            }
        }
        
        return $formattedAvailability;
    }
}