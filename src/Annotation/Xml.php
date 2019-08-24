<?php


namespace App\Annotation;

/**
 * @Annotation
 */
class Xml
{
	/** @var string */
	public $tag;

	/** @var string */
	public $dataType = "string";

	/** @var string */
	public $format;
}