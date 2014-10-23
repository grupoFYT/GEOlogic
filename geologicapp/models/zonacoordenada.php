<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class ZonaCoordenada extends ORM {

		public $table = 'zonas_coordenadas';
        public $primary_key = 'id';
		public $foreign_key = array('\\model\\zona' => 'zona_id');

        function _init()
        {
                self::$relationships = array (
					'zona'          =>     ORM::belongs_to('\\Model\\Zona')
                );
        }
}