<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Meta extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'section', 'keyword','description','title'
    ];

    public $translatable = [
        'description',
        'keyword',
        'url',
        'title',
    ];
}
