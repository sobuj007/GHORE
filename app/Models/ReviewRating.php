<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class ReviewRating extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serviceProduct()
    {
        return $this->belongsTo(ServiceProduct::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
    
    public function serviceProduct2()
    {
        return $this->belongsTo(ServiceProduct::class, 'serviceproduct_id');
    }
    // protected function image(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn(string $value) => getAssetUrl($value, 'uploads/reviews'),
    //     );
    // }
    
}
