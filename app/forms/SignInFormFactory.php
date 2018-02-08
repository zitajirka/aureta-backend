<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;


class SignInFormFactory
{
	use Nette\SmartObject;

	/** @var FormFactory */
	private $factory;

	/** @var User */
	private $user;


	public function __construct(FormFactory $factory, User $user)
	{
		$this->factory = $factory;
		$this->user = $user;

		
	}


	/**
	 * @return Form
	 */
	public function create(callable $onSuccess)
	{

		$form = $this->factory->create();
		$form->addText('username', 'Login:')
			->setRequired('Prosím vložte svůj login.');

		$form->addPassword('password', 'Heslo:')
			->setRequired('Prosím vložte své heslo.');



		//$form->addCheckbox('remember', 'Pamatovat si mě');

		$form->addSubmit('send', 'Přihlásit se');

		$form->onSuccess[] = function (Form $form, $values) use ($onSuccess) {
			try {
				//$this->user->setExpiration($values->remember ? '14 days' : '20 minutes');
				$this->user->login($values->username, $values->password);
			} catch (Nette\Security\AuthenticationException $e) {
				$form->addError('Heslo nebo login jsou nesprávné.');
				return;
			}
			$onSuccess();
		};

		return $form;
	}
}
