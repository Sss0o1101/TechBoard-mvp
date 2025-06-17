<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Technology extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function jobListings(): BelongsToMany
    {
        return $this->belongsToMany(JobListing::class, 'job_technology')->withTimestamps();
    }

}








