<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [

        'id',
        'created_at',
        'updated_at',
    ];

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => getAssetUrl($value, 'uploads/category'),
        );
    }
}
