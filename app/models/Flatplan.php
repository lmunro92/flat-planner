<?php

class Flatplan extends Eloquent {

	public function user() {
		return $this->belongsTo('User');
	}

	public function organization() {
		return $this->belongsTo('Organization');
	}

	public function pages() {
		return $this->hasMany('Page');
	}

}