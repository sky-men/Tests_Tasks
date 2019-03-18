<?php

class PurchasesModule extends CWebModule
{
	public function init()
	{
		$this->setImport(array(
			'purchases.models.*',
			'purchases.components.*',
		));
	}
}
