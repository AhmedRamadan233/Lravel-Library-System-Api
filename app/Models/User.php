<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles; // Add this line

class User extends Authenticatable
{
    use HasFactory, HasApiTokens ,HasFactory,Notifiable, HasRoles; // Add the HasRoles trait
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'gender',
        'hire_date',
        'salary',
        'birth_date',
        'image',
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

    public function getImageUrlAttribute()
    {
        return asset('imagesfp/' . $this->image);
    }
    public function scopeFilter(Builder $builder, $filters)
    {
        $first_name = $filters['first_name'] ?? null;
        if ($first_name) {
            $builder->where('first_name', 'LIKE', "%$first_name%");
        }
    }
}
