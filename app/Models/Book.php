<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author_id',
        'publisher',
        'publishing_date',
        'category_id',
        'edition',
        'pages',
        'num_of_copies',
        'available',
        'shelf_num',
        'num_of_borrowing',
        'num_of_reading',
        'image',
    ];

    protected $hidden = [
        'author_id',
        'category_id',
        'created_at',
        'updated_at',
        // Any other fields you want to hide
    ];   


    public function author()
    {
        return $this->belongsTo(Auther::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute()
    {
        return asset('imagesfp/' . $this->image);
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $title = $filters['title'] ?? null;
        $publisher = $filters['publisher'] ?? null;

        $author = $filters['author'] ?? null;
        $category = $filters['category'] ?? null;

        $availableEqValue = $filters['availableeq'] ?? null;
        $availableLtValue = $filters['availablelt'] ?? null;
        $availableGtValue = $filters['availablegt'] ?? null;


        if ($availableGtValue !== null) {
            $builder->where('available', '>', $availableGtValue);
        }
        
        if ($availableLtValue !== null) {
            $builder->where('available', '<', $availableLtValue);
        }
        
        
        if ($availableEqValue !== null) {
            $builder->where('available', '=', $availableEqValue);
        }
        
        if ($title) {
            $builder->where('title', 'LIKE', "%$title%");
        }

        if ($publisher) {
            $builder->where('publisher', 'LIKE', "%$publisher%");
        }

        if ($author) {
            $builder->whereHas('author', function ($query) use ($author) {
                $query->where('first_name', 'LIKE', "%$author%");
            });
        }

        if ($category) {
            $builder->whereHas('category', function ($query) use ($category) {
                $query->where('name', 'LIKE', "%$category%");
            });
        }
    }
}

