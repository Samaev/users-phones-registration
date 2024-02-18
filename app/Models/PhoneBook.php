<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneBook extends Model
{
    use HasFactory;
    protected $table = 'user_phone_book';
    protected $fillable = ['user_id', 'phone_number'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
