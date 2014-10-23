<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Zona extends ORM {

		public $table = 'zonas';
        
        function _init()
        {
            self::$fields = array(
					'id'                    =>              ORM::field('auto[10]')
			);			
			self::$relationships = array (
				//'region'          =>     ORM::belongs_to('\\Model\\Region')
			);
        }
}