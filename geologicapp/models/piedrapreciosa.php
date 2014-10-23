<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class PiedraPreciosa extends ORM {

		public $table = 'piedraspreciosas';
        
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