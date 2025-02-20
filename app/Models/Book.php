<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'cover',
        'author',
        'year',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($book) {
            if (empty($book->slug)) {
                $book->slug = Str::slug($book->title);
            }
        });

        static::updating(function ($book) {
            if (empty($book->slug)) {
                $book->slug = Str::slug($book->title);
            }
        });
    }
}
