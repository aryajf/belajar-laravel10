<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    private $disableImageAccessor = false;
    protected $fillable = [
        'name',
        'email',
        'password',
        'image'
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
        'password' => 'hashed',
    ];

    public function disableImageAccessor()
    {
        $this->disableImageAccessor = true;
    }

    public function enableImageAccessor()
    {
        $this->disableImageAccessor = false;
    }

    protected function image(): Attribute
    {
        if (!$this->disableImageAccessor) {
            return Attribute::make(
                get: fn ($value) => asset('storage/photo-user/' . $value),
            );
        } else {
            return Attribute::make(
                get: fn ($value) => $value
            );
        }
    }

    public function ktp()
    {
        return $this->hasOne(Ktp::class);
    }
    public function rumah()
    {
        return $this->hasMany(Rumah::class);
    }
    public function assets()
    {
        return $this->belongsToMany(Asset::class, 'users_assets');
    }
}
