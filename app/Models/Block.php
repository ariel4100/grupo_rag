<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Block extends Model
{
    use HasFactory;
    use HasTranslations;
    use HasFactory;

    protected $fillable = [
        'section', 'title', 'text','description', 'image','content_id','type'
    ];

    public $translatable = [
        'title',
        'text',
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
