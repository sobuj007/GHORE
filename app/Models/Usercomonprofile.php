<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usercomonprofile extends Model
{
    use HasFactory;
protected $guarded=['id','created_at','updated_at'];

    // Relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //   protected function img(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn(string $value) => getAssetUrl($value, 'uploads/profile'),
    //     );}
    
}
