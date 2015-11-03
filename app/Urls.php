<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Urls extends Model
{
	use SoftDeletes;
    protected $table 	= 'urls';
    protected $fillable = ['id', 'long_url', 'short_url'];
    protected $dates 	= ['deleted_at'];
}
