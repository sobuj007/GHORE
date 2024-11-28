<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodyPart extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'updated_at','created_at'];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    public function serviceProducts()
{
    return $this->belongsToMany(ServiceProduct::class, 'service_product_bodypart', 'bodypart_id', 'service_product_id');
}
}
