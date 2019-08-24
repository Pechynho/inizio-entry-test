<?php

namespace App\Model;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class SearchRequest
{
	/** @var DateTime */
	private $searched;

	/**
	 * @var string
	 * @Assert\NotBlank()
	 * @Assert\Length(min="8", max="8")
	 * @Assert\Regex(pattern="/[\d]{8}/")
	 */
	private $ico = "";

	/**
	 * @return DateTime
	 */
	public function getSearched()
	{
		return $this->searched;
	}

	/**
	 * @param DateTime $searched
	 * @return SearchRequest
	 */
	public function setSearched($searched)
	{
		$this->searched = $searched;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getIco()
	{
		return $this->ico;
	}

	/**
	 * @param string $ico
	 * @return SearchRequest
	 */
	public function setIco($ico)
	{
		$this->ico = $ico;

		return $this;
	}
}