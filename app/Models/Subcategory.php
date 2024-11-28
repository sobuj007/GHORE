<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subcategory extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bodyParts()
    {
        return $this->hasMany(BodyPart::class);
    }
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => getAssetUrl($value, 'uploads/subcategory'),
        );
    }
}
