<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
	/**
	 * @inheritdoc
	 */
	public function getFunctions()
	{
		return [
			new TwigFunction('random_html_element_id', [$this, 'randomHtmlElementId']),
		];
	}

	/**
	 * @param string $prefix
	 * @return string
	 */
	public function randomHtmlElementId($prefix = "element")
	{
		return $prefix . "_" . rand();
	}
}
