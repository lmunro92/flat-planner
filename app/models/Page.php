<?php

class Page extends Eloquent {

	public function flatplan() {
		$this->belongsTo('Flatplan');
	}

	public function assignments() {
		$this->belongsToMany('Assignment');
	}

}