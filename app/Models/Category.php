<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    public function getImageUrlAttribute()
    {
        return asset('imagesfp/' . $this->image);
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $name = $filters['name'] ?? null;
        if ($name) {
            $builder->where('name', 'LIKE', "%$name%");
        }
    }
}
