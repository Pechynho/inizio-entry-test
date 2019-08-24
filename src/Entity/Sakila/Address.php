<?php

namespace App\Entity\Sakila;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="App\Repository\Sakila\AddressRepository")
 */
class Address
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="address_id", type="integer")
     */
    private $id;

    /**
	 * @var string
     * @ORM\Column(name="address", type="string", length=50)
     */
    private $address;

    /**
	 * @var string
     * @ORM\Column(name="address2", type="string", length=50, nullable=true)
     */
    private $address2;

    /**
	 * @var string
     * @ORM\Column(name="district", type="string", length=20)
     */
    private $district;

    /**
	 * @var string
     * @ORM\Column(name="postal_code", type="string", length=10, nullable=true)
     */
    private $postalCode;

    /**
	 * @var string
     * @ORM\Column(name="phone", type="string", length=20)
     */
    private $phone;

    /**
	 * @var DateTime
     * @ORM\Column(name="last_update", type="datetime")
     */
    private $lastUpdate;

	/**
	 * @var City
	 * @ORM\ManyToOne(targetEntity="App\Entity\Sakila\City", fetch="EAGER")
	 * @ORM\JoinColumn(name="city_id", referencedColumnName="city_id", nullable=false)
	 */
    private $city;

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
	public function getAddress()
	{
		return $this->address;
	}

	/**
	 * @param string $address
	 * @return Address
	 */
	public function setAddress($address)
	{
		$this->address = $address;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getAddress2()
	{
		return $this->address2;
	}

	/**
	 * @param string $address2
	 * @return Address
	 */
	public function setAddress2($address2)
	{
		$this->address2 = $address2;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getDistrict()
	{
		return $this->district;
	}

	/**
	 * @param string $district
	 * @return Address
	 */
	public function setDistrict($district)
	{
		$this->district = $district;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPostalCode()
	{
		return $this->postalCode;
	}

	/**
	 * @param string $postalCode
	 * @return Address
	 */
	public function setPostalCode($postalCode)
	{
		$this->postalCode = $postalCode;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPhone()
	{
		return $this->phone;
	}

	/**
	 * @param string $phone
	 * @return Address
	 */
	public function setPhone($phone)
	{
		$this->phone = $phone;

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
	 * @return Address
	 */
	public function setLastUpdate($lastUpdate)
	{
		$this->lastUpdate = $lastUpdate;

		return $this;
	}

	/**
	 * @return City
	 */
	public function getCity()
	{
		return $this->city;
	}

	/**
	 * @param City $city
	 * @return Address
	 */
	public function setCity($city)
	{
		$this->city = $city;

		return $this;
	}
}
