<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordsActivity;

class Favorite extends Model
{
	use RecordsActivity;

    protected $fillable = ['user_id'];
    protected $with = ['favoritable'];
	
    public function favoritable()
    {
    	return $this->morphTo();
    }
}
