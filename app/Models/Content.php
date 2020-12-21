<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Content extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $casts = [
        'image' => 'array',
        'block' => 'array',
        'data' => 'array',
        'title' => 'array',
        'text' => 'array',
    ];


    protected $fillable = [
        'section', 'title', 'text','data','image','block'
    ];

    public function block() {
        return $this->hasMany(Block::class);
    }

    public $translatable = [
        'title',
        'text',
    ];
}
