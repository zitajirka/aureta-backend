<?php

namespace App\Forms;

use App\Model\Orm\User\User;
use App\Model\Services\AuthenticatorService;
use Nette\Application\UI;

class SignInForm extends BaseForm
{
	/**
	 * @var AuthenticatorService
	 */
	private $authenticatorService;

	/**
	 * @var User
	 */
	private $passwordResetUser;
	/**
	 * @var \Nette\Security\User
	 */
	private $user;

	/**
	 * SignInForm constructor.
	 * @param User $passwordResetUser |NULL
	 * @param \Nette\Security\User $user
	 * @param AuthenticatorService $authenticatorService
	 */
	public function __construct(User $passwordResetUser = NULL, \Nette\Security\User $user, AuthenticatorService $authenticatorService)
	{
		$this->authenticatorService = $authenticatorService;
		$this->passwordResetUser = $passwordResetUser;
		$this->user = $user;
	}


	public function createComponentForm()
	{
		$form = new UI\Form;
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

		$form->onSuccess[] = array($this, 'formSucceeded');



		return $form;
	}


	public function formSucceeded($form, $values)
	{
		if ($this->passwordResetUser) {
			$this->authenticatorService->updatePassword($this->passwordResetUser, $values->password);
		}

		$this->user->setExpiration('14 days', FALSE);

		try {
			$this->user->login($values->email, $values->password);
		} catch (\Nette\Security\AuthenticationException $e) {
			$form->addError($e->getMessage());
			return;
		}

		$this->redirect('this');
	}

}


interface ISignInFormFactory
{
	/**
	 * @param User $passwordResetUser|NULL
	 * @param \Nette\Security\User $user
	 * @return SignInForm
	 */
	function create(User $passwordResetUser = NULL, \Nette\Security\User $user);
}