<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
	protected $primaryKey = 'driver_id';
	
    //
    public function operator(){
    	return $this->belongsTo(Operator::Class, 'operator_id');
    }
    public function van(){
    	return $this->hasOne(Van::Class, 'plate_number');
    }

}