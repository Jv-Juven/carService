<?php

class IllegalCityInfoIndex extends Eloquent{

	protected $table = 'illegal_city_info_index';
	protected $hidden = '';

	protected $fillable = array(
			'id',
			'p_code',
			'province',
			'c_code',
			'city',
			'a_code',
			'area',
	);
}