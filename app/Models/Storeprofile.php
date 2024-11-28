<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storeprofile extends Model
{
    use HasFactory;


    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'location_ids' => 'array', // Automatically cast JSON to array
    ];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function getLocationsAttribute()
    {
        return Location::whereIn('id', $this->location_ids)->get();
    }
    protected function coverImage(): Attribute
    {
        return Attribute::make(
           get: fn(?string $value) =>  $value ? getAssetUrl($value, 'uploads/storeImages') : '',
        );
    }
    protected function logo(): Attribute
    {
        return Attribute::make(
           get: fn(?string $value) =>  $value ? getAssetUrl($value, 'uploads/storeImages') : '',
        );
    }
}
