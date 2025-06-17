<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Favorite;
use App\Models\JobListing;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoriteJobListings(): BelongsToMany
    {
        return $this->belongsToMany(JobListing::class, 'favorites', 'user_id', 'job_listing_id')->withPivot(['comment', 'commented_at'])->withTimestamps();
    }

    public function hasFavorited(JobListing $jobListing): bool
    {
        return $this->favorites()->where('job_listing_id', $jobListing->id)->exists();
    }

    public function favorite(JobListing $jobListing)
    {
        return $this->favorites()->where('job_listing_id', $jobListing->id)->first();
    }
}








