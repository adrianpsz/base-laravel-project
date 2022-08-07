<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'terms',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->roles()->attach(Role::USER);
        });
    }

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function rolesAsIdArray(): array
    {
        return $this->roles()->pluck('roles.id')->toArray();
    }

    public function rolesAsNameArray(): array
    {
        return $this->roles()->pluck('roles.name')->toArray();
    }

    public function rolesNames(): string
    {
        return join(', ', $this->rolesAsNameArray());
    }

    public function isAdmin(): bool
    {
        return in_array(Role::ADMIN, $this->rolesAsIdArray());
    }
}
