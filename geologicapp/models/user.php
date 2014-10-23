<?php

class User extends DataMapper {

	var $table = 'users';
	
	public $has_many = array(
		'especialidad'
	);
	
}