<?php

namespace App\Entity\Sakila;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="city")
 * @ORM\Entity(repositoryClass="App\Repository\Sakila\CityRepository")
 */
class City
{
    /**
	 * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="city_id", type="integer")
     */
    private $id;

    /**
	 * @var string
     * @ORM\Column(name="city", type="string", length=50)
     */
    private $city;

    /**
	 * @var DateTime
     * @ORM\Column(type="datetime")
	 * @ORM\Version
     */
    private $lastUpdate;

	/**
	 * @var Country
	 * @ORM\ManyToOne(targetEntity="App\Entity\Sakila\Country", fetch="EAGER")
	 * @ORM\JoinColumn(name="country_id", referencedColumnName="country_id", nullable=false)
	 */
    private $country;

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
	public function getCity()
	{
		return $this->city;
	}

	/**
	 * @param string $city
	 * @return City
	 */
	public function setCity($city)
	{
		$this->city = $city;

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
	 * @return City
	 */
	public function setLastUpdate($lastUpdate)
	{
		$this->lastUpdate = $lastUpdate;

		return $this;
	}

	/**
	 * @return Country
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * @param Country $country
	 * @return City
	 */
	public function setCountry($country)
	{
		$this->country = $country;

		return $this;
	}
}
