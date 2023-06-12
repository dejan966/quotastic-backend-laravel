<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /* protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'avatar',
    ]; */
    /**
     * Always encrypt the password when it is updated.
     *
     * @param $value
     * @return string
     */
    /* public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    } */
}
