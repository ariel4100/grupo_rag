<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $casts = [
        'gallery' => 'array'
    ];

    protected $fillable = [
        'title', 'text','order','slug','video','image','description','file','family_id','text_video','gallery'
    ];

    public $translatable = [
        'title',
        'text',
        'text_video',
        'description',
        'slug',
    ];

    public function family() {
        return $this->belongsTo(Family::class);
    }



    public function related() {
        return $this->belongsToMany(Product::class,'related_products','product_id','related_id');
    }
    public function industrias()
    {
        return $this->belongsToMany(Block::class, 'product_blocks','product_id','block_id');
    }

}
