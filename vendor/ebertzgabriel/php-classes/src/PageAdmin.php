<?php

namespace Extras;

class PageAdmin extends Page {


	public function __construct($opts = array(), $tpl_dir = "/views/admin/") {

		// Buscando da classe extendida
		parent::__construct($opts, $tpl_dir);
	}
}

?>