<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prefecture extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function jobListings(): HasMany
    {
        return $this->hasMany(JobListing::class);
    }
}






//仮コード
