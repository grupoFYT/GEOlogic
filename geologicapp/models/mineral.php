<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Mineral extends ORM {

		public $table = 'Minerales';
        
        function _init()
        {
            self::$fields = array(
					'id'                    =>              ORM::field('auto[10]')
			);			
			self::$relationships = array (
				//'tipo_pp'          =>     ORM::belongs_to('\\Model\\Tipo_PP')
			);
        }
}