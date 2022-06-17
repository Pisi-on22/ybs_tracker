<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSignUp extends Model
{
    use HasFactory;

    protected $table = 'user_sign_ups';

    protected $fillable = ['username','email','password','comfirm_password'];
}
