<?php

class Organization extends Eloquent {

	public function roles() {
		return $this->hasMany('Role');
	}

	public function flatplans() {
		return $this->hasMany('Flatplan');
	}

}