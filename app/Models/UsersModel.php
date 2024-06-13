<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    use HasFactory;

    protected $table = 'registerd_users';

    protected $fillable = [
        'name',
        'company',
        'email',
        'password',
        'role',
        'active',
    ];

    public function registeredUser()
    {
        return $this->hasOne(User::class);
    }
}
