<?php

namespace App\Forms;

use App\Model\Orm\User\User;
use App\Model\Orm\User\UserRepository;
use Nette\Application\UI;


class SignUpForm extends BaseForm
{
	/**
	 * @var UserRepository
	 */
	private $userRepository;

	/**
	 * SignUpForm constructor.
	 * @param UserRepository $userRepository
	 */
	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * @return Form
	 */
	public function createComponentForm()
	{
		$form = new UI\Form;
		$form->addText('email', 'E-mail:')
			->setRequired('Please enter your email.');
		$form->addText('name', 'Name:')
			->setRequired('Please enter your name.');
		$form->addPassword('password', 'Password:')
			->setRequired('Please enter your password.');

		$form->addSubmit('send', 'Sign up');
		$form->onSuccess[] = array($this, 'formSucceeded');

		return $form;
	}

	public function formSucceeded($form, $values)
	{
			try {
				$user = new User();
				$user->email = $values->email;
				$user->name = $values->name;
				$user->setPassword($values->password);
				$this->userRepository->persistAndFlush($user);

				$this->onFormSuccess($this);

			} catch (\Nextras\Dbal\UniqueConstraintViolationException $exception) {
				$form->addError("User with e-mail {$values->email} already exists.");
			}
	}


}


interface ISignUpFormFactory
{
	/**
	 * @return \App\Forms\SignUpForm
	 */
	function create();
}