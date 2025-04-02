<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrontPageSection extends Model
{
    use HasFactory;
    protected $table = 'front_page_sections';
    public function products(){
        return $this->belongsToMany(Product::class, 'front_page_section_products', 'front_page_section_id', 'product_id');
         
               }
        
}
