<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne('App\Models\User','id','user_id')->select(['id','first_name','last_name','email']);
    }

    public function quote()
    {
        return $this->hasOne('App\Models\Quote','id','quote_id')->select(['id','quote','karma','user_id']);
    }
}
