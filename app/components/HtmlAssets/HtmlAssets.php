<?php

namespace App\Components;

use Nette,
	Nette\Application\UI;


class HtmlAssets extends UI\Control
{
	private $developmentMode, $assets, $basePath;

	public function __construct($developmentMode, Nette\Http\Request $httpRequest)
	{
		$this->developmentMode = $developmentMode;
		$this->basePath = substr($httpRequest->getUrl()->getBasePath(), 0, -1);
		$this->assets = \GuzzleHttp\json_decode(file_get_contents('nette.safe://' . __DIR__ . '/assets.json'), true);
	}

	public function render($type, $domain)
	{
		$this->template->type = $type;
		$this->template->domain = $domain;
		$this->template->developmentMode = $this->developmentMode;
		$this->template->assets = $this->assets;
		$this->template->basePath = $this->basePath;
		$this->template->render(__DIR__ . '/HtmlAssets.latte');
	}

}