<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProduct extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    //  protected $casts = [
    //     'bodypart_ids' => 'array',  // Cast bodypart_ids to an array
    //     'location_ids' => 'array',   // Cast location_ids to an array (if not already)
    // ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function bodypart()
    {
        return $this->belongsTo(BodyPart::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function location()
    {
        return $this->belongsToMany(Location::class, 'service_product_location');
    }
        public function locations2()
    {
        return $this->belongsToMany(Location::class, 'service_product_location', 'service_product_id', 'location_id');
    }

    // public function slot()
    // {
    //     return $this->belongsTo(Myslot::class, 'available_slot_id');
    // }

    // public function appointmentSlots()
    // {
    //     return $this->belongsToMany(Appointmentslot::class, 'service_product_appointment_slot');
    // }
    public function bodyParts()
{
    return $this->belongsToMany(BodyPart::class, 'service_product_bodypart', 'service_product_id', 'bodypart_id');
}
     public function reviewRatings()
    {
        return $this->hasMany(ReviewRating::class, 'serviceproduct_id');
    }
    protected function image(): Attribute
    {
        // return Attribute::make(
        //     get: fn(string $value) => getAssetUrl($value, 'uploads/servicesproduct'),
        // );
        return Attribute::make(
           get: fn(?string $value) =>  $value ? getAssetUrl($value, 'uploads/servicesproduct') : '',
        );
    }
}
