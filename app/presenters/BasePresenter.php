<?php

namespace App\Presenters;

use App\Components\HtmlHead;
use Nette;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	/** @var Nette\Mail\IMailer @inject */
	public $mailer;

	/** @var \App\Components\HtmlAssets @inject */
	public $htmlAssetsComponent;

	/**
	 * @var \App\Model\Orm\User\UserRepository
	 * @inject
	 */
	public $userRepository;

	/**
	 * @var \App\Forms\ISignInFormFactory
	 * @inject
	 */
	public $signInFormFactory;

	/**
	 * @var User
	 */
	protected $passwordResetUser;

	/**
	 * Check authorization
	 * @param $element
	 * @return void
	 * @throws Nette\Application\ForbiddenRequestException
	 */
	public function checkRequirements($element)
	{
		if ($element->hasAnnotation('resource')) {
			$resource = $element->getAnnotation('resource');
			if (!$this->user->isAllowed($resource)) {
				if (!$this->user->isLoggedIn()) {
					$this->redirect(':Front:Sign:in', ['backlink' => $this->storeRequest()]);
				} else {
					throw new Nette\Application\ForbiddenRequestException;
				}
			}

			if ($this->user->isLoggedIn() && $resource == 'Front:Sign') {
				$this->redirect(':Admin:Homepage:default');
			}

		}

		parent::checkRequirements($element);
	}


	protected function beforeRender()
	{
	}

	/*
	 * ====== Signals ======
	 */

	public function handleLogOut()
	{
		$this->user->logout();
		$this->redirect(":Front:Sign:in");
	}

	public function handleModal($id)
	{
		$this->template->modal = $id;
		$this->redrawControl('modal');
	}

	/**
	 * Html Head Component
	 * @return \App\Components\HtmlHead
	 */
	protected function createComponentHtmlAssets()
	{
		return $this->htmlAssetsComponent;
	}

	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = $this->signInFormFactory->create($this->passwordResetUser, $this->user);
		$form->onFormSuccess[] = function ($form) {
			$form->getPresenter()->redirect('this');
		};
		return $form;
	}

}
