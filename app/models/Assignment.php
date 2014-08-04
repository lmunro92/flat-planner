<?php

class Assignment extends Eloquent {

	public function user() {
		return $this->belongsTo('User');
	}

	public function pages() {
		return $this->belongsTo('Page');
	}

}