<?php

namespace App\Models;

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
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
