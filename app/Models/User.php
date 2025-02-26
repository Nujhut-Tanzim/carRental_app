<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable=["name","email","password","phone","address","otp","role"];
    protected $attributes = [
        'otp' => '0'
    ];

    public function isAdmin()
{
    return $this->role === 'admin';
}

public function isCustomer()
{
    return $this->role === 'customer';
}

public function rentals()
{
    return $this->hasMany(Rental::class);
}
}
