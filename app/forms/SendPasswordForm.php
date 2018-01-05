<?php

namespace App\Forms;


use App\Model\Services\AuthenticatorService;
use Nette\Application\UI\Form;

class SendPasswordForm extends BaseForm
{

	/**
	 * @var AuthenticatorService
	 */
	private $authenticatorService;

	public function __construct(AuthenticatorService $authenticatorService)
	{
		$this->authenticatorService = $authenticatorService;
	}

	/**
	 * @return Form
	 */
	public function createComponentForm()
	{
		$form = new Form;
		$form->addEmail('email', 'E-mail:')
			->setRequired('Please enter your e-mail.');

		$form->addSubmit('send', 'Send new password request');

		$form->onSuccess[] = array($this, 'formSucceeded');

		$form->onSuccess[] = array($this, 'formSucceeded');

		return $form;
	}


	public function formSucceeded($form, $values)
	{

		if ($this->authenticatorService->requestPasswordReset($values->email)) {
			$this->onFormSuccess($this);
		} else {
			$form->addError("User with e-mail {$values->email} does not exist.");
		}

	}

}

interface ISendPasswordFormFactory
{
	/**
	 * @return \App\Forms\SendPasswordForm
	 */
	function create();
}