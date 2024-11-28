<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyExpart extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'certificate_images' => 'array',
    ];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
 
    
    //   // Use accessor for profile_image
    // protected function profile_image(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn(?string $value) => $value ? getAssetUrl($value, 'uploads/exparts') : '',
    //     );
    // }

    // // Use accessor for certificate_images
    // protected function certificate_images(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn(?string $value) => $value 
    //             ? array_map(fn($img) => getAssetUrl($img, 'uploads/expartscertificate'), json_decode($value, true))
    //             : [],
    //     );
   // }
}
