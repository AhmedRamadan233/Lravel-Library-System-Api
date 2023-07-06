<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auther extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'gender',
        'image',
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
