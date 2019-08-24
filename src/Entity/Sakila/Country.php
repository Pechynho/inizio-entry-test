<?php

namespace App\Entity\Sakila;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="country")
 * @ORM\Entity(repositoryClass="App\Repository\Sakila\CountryRepository")
 */
class Country
{
    /**
	 * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="country_id", type="integer")
     */
    private $id;

    /**
	 * @var string
     * @ORM\Column(name="country", type="string", length=50)
     */
    private $country;

    /**
	 * @var DateTime
     * @ORM\Column(name="last_update", type="datetime")
	 * @ORM\Version
     */
    private $lastUpdate;

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * @param string $country
	 * @return Country
	 */
	public function setCountry($country)
	{
		$this->country = $country;

		return $this;
	}

	/**
	 * @return DateTime
	 */
	public function getLastUpdate()
	{
		return $this->lastUpdate;
	}

	/**
	 * @param DateTime $lastUpdate
	 * @return Country
	 */
	public function setLastUpdate($lastUpdate)
	{
		$this->lastUpdate = $lastUpdate;

		return $this;
	}
}
