<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email'
    ];

    public function userCountry(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(UserCountry::class);
    }

    public function phoneBook(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PhoneBook::class);
    }
}
