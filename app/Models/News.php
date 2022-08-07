<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'is_active'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->user_id = Auth::user()->id;
            }
        });

        static::updating(function ($model) {
            if (Auth::check() && !Auth::user()->isAdmin()) {
                $model->is_active = false;
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable')->orderBy('order');
    }

    public function scopeByUser($query, $user)
    {
        return $query->where('user_id', '=', $user->id);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 1);
    }
}
