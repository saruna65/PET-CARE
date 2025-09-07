<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Add role to fillable
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    /**
     * Get the disease detections for the user.
     */
    public function diseaseDetections()
    {
        return $this->hasMany(DiseaseDetection::class);
    }
    
    /**
     * Check if the user is a pet owner.
     *
     * @return bool
     */
    public function isPetOwner(): bool
    {
        return $this->role === 'pet_owner';
    }

    /**
     * Check if the user is a veterinarian.
     *
     * @return bool
     */
    public function isVet(): bool
    {
        return $this->role === 'vet';
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get the vet profile associated with the user.
     */
    public function vetProfile()
    {
        return $this->hasOne(Vet::class);
    }
}