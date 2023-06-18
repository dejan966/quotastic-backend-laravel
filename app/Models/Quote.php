<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['quote'];

    public function user()
    {
        return $this->hasOne('App\Models\User','id','user_id')->select(['id','first_name','last_name','email']);
    }
}
