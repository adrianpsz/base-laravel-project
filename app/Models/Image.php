<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;

class Image extends Model
{
    use HasFactory;

    const IMAGE_PATH = "images" . DIRECTORY_SEPARATOR;
    const MAX_IMAGES = 5;

    protected $fillable = [
        'filename',
        'mime',
        'order'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            if (Auth::check()
                && !Auth::user()->isAdmin()
                && $model->imageable_type === 'App\Models\News') {
                $model->imageable->is_active = false;
                $model->imageable->save();
            }
        });
    }

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeByName($query, $name)
    {
        return $query->where('filename', 'like', $name);
    }
}
