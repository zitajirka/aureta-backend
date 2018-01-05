<?php

namespace App\AdminModule\Presenters;


/**
 * Homepage presenter.
 */
class BasePresenter extends \App\Presenters\BasePresenter
{

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

}
