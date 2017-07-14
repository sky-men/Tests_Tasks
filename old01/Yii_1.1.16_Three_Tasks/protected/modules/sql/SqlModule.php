<?php

class SqlModule extends CWebModule
{
	public function init()
	{
		$this->setImport(array(
			'sql.models.*',
			'sql.components.*',
		));
	}
}
