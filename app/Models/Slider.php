<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'section', 'title', 'text','order','image'
    ];

    public $translatable = [
        'title',
        'text',
    ];
}
