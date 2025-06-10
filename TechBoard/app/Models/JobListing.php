<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'job_type_id',
        'prefecture_id',
        'location',
        'company_name',
        'min_salary',
        'max_salary',
        'employment_type',
        'is_remote_ok',
        'is_inexperienced_ok',
        'industry_id',
    ];

    protected $casts = [
        'is_remote_ok' => 'boolean',
        'is_inexperienced_ok' => 'boolean',
    ];

    public function jobType(): BelongsTo
    {
        return $this->belongsTo(JobType::class);
    }

    public function prefecture(): BelongsTo
    {
        return $this->belongsTo(Prefecture::class);
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class, 'job_technology')->withTimestamps();
    }

    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')->withPivot(['comment', 'commented_at'])->withTimestamps();
    }

    public function getSalaryRangeAttribute(): string
    {
        if ($this->min_salary && $this->max_salary) {
            return number_format($this->min_salary) . '〜' . number_format($this->max_salary) . '万円';
        } elseif ($this->min_salary) {
            return number_format($this->min_salary) . '万円〜';
        } elseif ($this->max_salary) {
            return '〜' . number_format($this->max_salary) . '万円';
        }

        return '応相談';
    }
}







//models
