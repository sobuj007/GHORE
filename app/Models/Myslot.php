<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Myslot extends Model
{
    use HasFactory;

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function appointmentslots()
    {
        return $this->hasMany(Appointmentslot::class, 'slot_id');
    }
}
