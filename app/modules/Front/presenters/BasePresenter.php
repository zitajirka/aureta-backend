<?php

namespace App\FrontModule\Presenters;

use App\Model\Orm\User\User;
use Nette;
use Nette\Application\UI\Form;

/**
 * Front module Base presenter.
 */
class BasePresenter extends \App\Presenters\BasePresenter
{

	/**
	 * @var User
	 */
	protected $passwordResetUser;


	/*
	 * ===== FORMS ======
	 */

	public function createComponentSignInForm()
	{
		$form = new Form;
		$form->addText('email', 'Email:')
			->setRequired('Please enter your email.');

		$form->addPassword('password', 'Password:')
			->setRequired('Please enter your password.');


		if ($this->passwordResetUser) {
			$form->addSubmit('send', 'Change password and Sign in');
			$form['email']
				->setValue($this->passwordResetUser->email)
				->setAttribute('readonly', TRUE);
		} else {
			$form->addSubmit('send', 'Sign in');
		}

		$form->onSuccess[] = array($this, 'signInFormSucceeded');



		return $form;
	}


	public function signInFormSucceeded($form, $values)
	{
		if ($this->passwordResetUser) {
			$this->userFacade->updatePassword($this->passwordResetUser, $values->password);
		}


		$this->user->setExpiration('14 days', FALSE);

		try {
			$this->user->login($values->email, $values->password);
		} catch (Nette\Security\AuthenticationException $e) {
			$form->addError($e->getMessage());
			return;
		}

		$this->redirect(':Admin:Homepage:default');
	}

}
