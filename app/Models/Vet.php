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
        'availability_hours'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'experience_years' => 'integer',
        'is_available' => 'boolean',
        'consultation_fee' => 'decimal:2',
        'services_offered' => 'json',
        'availability_hours' => 'json',
    ];

    /**
     * Get the user that owns the vet profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the appointments for the vet.
     */
    

    /**
     * Get the image URL attribute.
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return asset('images/default-vet-profile.jpg');
    }

    /**
     * Get the formatted availability hours.
     *
     * @return array
     */
    public function getFormattedAvailabilityAttribute(): array
    {
        $days = [
            'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'
        ];
        
        $availability = $this->availability_hours ?? [];
        $formatted = [];
        
        foreach ($days as $day) {
            $formatted[$day] = [
                'available' => isset($availability[$day]) && $availability[$day]['available'] ?? false,
                'start_time' => $availability[$day]['start_time'] ?? '09:00',
                'end_time' => $availability[$day]['end_time'] ?? '17:00',
            ];
        }
        
        return $formatted;
    }
}