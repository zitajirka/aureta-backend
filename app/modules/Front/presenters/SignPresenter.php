<?php

namespace App\FrontModule\Presenters;

use App\Forms\TemplateControl;
use Nette,
	App\Forms\SignFormFactory;


/**
 * Sign in/out presenters.
 * @resource(Front:Sign)
 */
class SignPresenter extends BasePresenter
{


	/**
	 * @var \App\Forms\ISignUpFormFactory
	 * @inject
	 */
	public $signUpFormFactory;

	/**
	 * @var \App\Forms\ISendPasswordFormFactory
	 * @inject
	 */
	public $sendPasswordFormFactory;



	public function actionIn($newpasshash = "")
	{

		if ($newpasshash) {

			$this->passwordResetUser = $this->userFacade->getUserByValidPasswordResetHash($newpasshash);

			if (!$this->passwordResetUser) {
				$this->flashMessage("We are sorry, but this link is not valid. Maybe it is broken or expired.", 'danger');
			}
		}

	}



	/**
	 * Sign-up form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignUpForm()
	{
		$form = $this->signUpFormFactory->create();
		$form->onFormSuccess[] = function ($form) {
			$this->flashMessage("You have been successfuly registered.", 'success');
			$form->getPresenter()->redirect(':Front:Sign:in');
		};
		return $form;
	}

	/**
	 * Reset password form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSendPasswordForm()
	{
		$form = $this->sendPasswordFormFactory->create();
		$form->onFormSuccess[] = function ($form) {
			$this->flashMessage("Please follow instructions we have sent you to your e-mail.", 'success');
			$form->getPresenter()->redirect(':Front:Homepage:');
		};
		return $form;
	}


}
