<?php 

class Role extends Eloquent {

	public function user() {
		$this->belongsTo('User');
	}

	public function organization() {
		$this->belongsTo('Organization');
	}

}
