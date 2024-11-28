<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',

    ];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
      protected function image(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => getAssetUrl($value, 'uploads/certificates'),
        );
    }
}
