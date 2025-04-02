<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FrontPageSectionProduct extends Model
{
    protected $table = 'front_page_section_products';
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function frontPageSection()
    {
        return $this->belongsTo(FrontPageSection::class, 'front_page_section_id');
    }
}
