<?php

namespace App\Presenters;

use Nette;

class HomepagePresenter extends BasePresenter
{

protected function startup()
{
    parent::startup();
    if (!$this->getUser()->isLoggedIn()) {
       $this->redirect('Sign:in');
    }
}
	public function renderDefault()
{
	
    
    
}

}
