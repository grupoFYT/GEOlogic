<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Yacimiento extends ORM {

		public $table = 'yacimientos';
        
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