<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'address',
        'password',
        'gender',
        'birth_date',
        'image',
        'banded_at',
    ];
    
    // public function getImageUrlAttribute()
    // {
    //     return Storage::disk('images')->url($this->image);
    // }
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
