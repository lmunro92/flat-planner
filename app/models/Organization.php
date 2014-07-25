<?php

class Organization extends Eloquent {

	public function roles() {
		$this->hasMany('Role');
	}

	public function flatplans() {
		$this->hasMany('Flatplan');
	}

}