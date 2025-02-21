<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'cover',
        'author',
        'year',
        'description',
    ];


    protected function cover(): Attribute
    {
        return Attribute::make(
            get: fn ($cover) => url('/storage/cover/' . $cover),
        );
    }
}
