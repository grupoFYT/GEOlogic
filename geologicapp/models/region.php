<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Region extends ORM {

		public $table = 'regiones';
        public $primary_key = 'id';
		
        function _init()
        {
			self::$fields = array(
					'id'                    =>              ORM::field('auto[10]')
			);
			
			self::$relationships = array (
				'zonas'          =>     ORM::has_many('\\Model\\Zona')
			);
        }
}