<?php

namespace App\Model\Services;


use Nette\Application\LinkGenerator;
use Nette\Bridges\ApplicationLatte\UIMacros;
use Nette\Mail\IMailer;
use Nette\Mail\Message;
use Nette\Object;

class EmailService extends Object
{

	private $templateDir, $archiveEmail, $fromEmail, $mailer, $linkGenerator;

	public function __construct($templateDir, $archiveEmail, $fromEmail, IMailer $mailer, LinkGenerator $linkGenerator)
	{
		$this->templateDir = $templateDir;
		$this->archiveEmail = $archiveEmail;
		$this->fromEmail = $fromEmail;
		$this->mailer = $mailer;
		$this->linkGenerator = $linkGenerator;
	}

	/**
	 * @param $to array|string
	 * @param $params array
	 * @param $template string
	 * @return bool|string
	 * @throws \Exception
	 */
	public function send($to, $params, $template)
	{
		$latte = new \Latte\Engine;

		UIMacros::install($latte->getCompiler());

		$latte->addProvider('uiControl', $this->linkGenerator);

		$mail = new Message;
		$mail->setFrom($this->fromEmail)
			->setHtmlBody($latte->renderToString($this->templateDir . '/' . $template, $params));

		if ( ! empty($this->archiveEmail)) {
			$mail->addBcc($this->archiveEmail);
		}

		if (is_string($to)) {
			$mail->addTo($to);
		} elseif (is_array($to) && count($to) > 0) {
			$mail->addTo($to[0]);
			for ($i = 1; $i < count($to) ; $i++) {
				$mail->addCc($to[$i]);
			}
		} else {
			return "Bad 'to' parameter";
		}

		$this->mailer->send($mail);


		return true;

	}




}