<?php

class Flatplan extends Eloquent {

	public function user() {
		$this->belongsTo('User');
	}

	public function organization() {
		$this->belongsTo('Organization');
	}

	public function pages() {
		$this->hasMany('Page');
	}

}