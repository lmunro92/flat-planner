<?php

class Page extends Eloquent {

	public function flatplan() {
		return $this->belongsTo('Flatplan');
	}

	public function assignments() {
		return $this->hasMany('Assignment');
	}

}