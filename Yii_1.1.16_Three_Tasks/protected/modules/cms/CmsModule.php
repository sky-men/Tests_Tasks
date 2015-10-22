<?php

class CmsModule extends CWebModule
{
	public function init()
	{
		$this->setImport(array(
			'cms.models.*',
		));
	}
}
