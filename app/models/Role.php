<?php 

class Role extends Eloquent {

	public function user() {
		return $this->belongsTo('User');
	}

	public function organization() {
		return $this->belongsTo('Organization');
	}

}
