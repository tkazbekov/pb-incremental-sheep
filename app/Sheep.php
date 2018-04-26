<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sheep extends Model
{
    use SoftDeletes;
    protected $fillable = ['pen_id'];
    protected $dates = ['deleted_at'];

    public function scopePen($query, $pen_id) {
        if (!is_null($pen_id)) {
            return $query->where(compact('pen_id'));
        }
        return $query;
    }
}
