<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    
    public function getImageUrlAtteribute(){
        return Storage::disk('images')->url($this->image);
    }
}
