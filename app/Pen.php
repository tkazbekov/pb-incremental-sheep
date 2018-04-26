<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pen extends Model
{
    public function sheeps() {
        return $this->hasMany('App\Sheep');
    }
}
