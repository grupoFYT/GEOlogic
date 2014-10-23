<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Pais extends ORM {

		public $table = 'paises';
        public $primary_key = 'id';

        function _init()
        {
			self::$fields = array(
					'id'                    =>              ORM::field('auto[10]')
			);
			
			self::$relationships = array (
				'regiones'   =>     ORM::has_many('\\Model\\Region')
			);
			
        }
}