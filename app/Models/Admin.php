<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable implements \Illuminate\Contracts\Auth\Authenticatable
{
    protected $table = 'admins'; // Nama tabel
    protected $fillable = ['username', 'password'];

    protected $hidden = ['password'];
}
