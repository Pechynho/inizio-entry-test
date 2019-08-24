<?php

namespace App\Entity\Main;

use App\Annotation\Xml;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Main\AddressRepository")
 */
class Address
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

	/**
	 * @var string
	 * @ORM\Column(type="integer", nullable=true)
	 * @Xml(tag="Kod_statu")
	 */
    private $stateCode;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 * @Xml(tag="Nazev_statu")
	 */
    private $state;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 * @Xml(tag="Nazev_kraje")
	 */
    private $region;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 * @Xml(tag="Nazev_okresu")
	 */
    private $township;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 * @Xml(tag="Nazev_obce")
	 */
    private $municipality;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 * @Xml(tag="Nzave_pobvodu")
	 */
    private $district;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 * @Xml(tag="Nazev_casti_obce")
	 */
    private $municipalityPart;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 * @Xml(tag="Nazev_mestske_casti")
	 */
    private $districtPart;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 * @Xml(tag="Nazev_ulice")
	 */
    private $street;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 * @Xml(tag="Cislo_domovni")
	 */
    private $houseNumber;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 * @Xml(tag="Cislo_orientacni")
	 */
    private $orientationNumber;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=true)
	 * @Xml(tag="PSC")
	 */
    private $zipCode;

	/**
	 * @return int|null
	 */
    public function getId()
    {
        return $this->id;
    }

	/**
	 * @return string
	 */
	public function getStateCode()
	{
		return $this->stateCode;
	}

	/**
	 * @param string $stateCode
	 * @return Address
	 */
	public function setStateCode($stateCode)
	{
		$this->stateCode = $stateCode;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getState()
	{
		return $this->state;
	}

	/**
	 * @param string $state
	 * @return Address
	 */
	public function setState($state)
	{
		$this->state = $state;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getRegion()
	{
		return $this->region;
	}

	/**
	 * @param string $region
	 * @return Address
	 */
	public function setRegion($region)
	{
		$this->region = $region;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getTownship()
	{
		return $this->township;
	}

	/**
	 * @param string $township
	 * @return Address
	 */
	public function setTownship($township)
	{
		$this->township = $township;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getMunicipality()
	{
		return $this->municipality;
	}

	/**
	 * @param string $municipality
	 * @return Address
	 */
	public function setMunicipality($municipality)
	{
		$this->municipality = $municipality;

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
	public function getMunicipalityPart()
	{
		return $this->municipalityPart;
	}

	/**
	 * @param string $municipalityPart
	 * @return Address
	 */
	public function setMunicipalityPart($municipalityPart)
	{
		$this->municipalityPart = $municipalityPart;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getDistrictPart()
	{
		return $this->districtPart;
	}

	/**
	 * @param string $districtPart
	 * @return Address
	 */
	public function setDistrictPart($districtPart)
	{
		$this->districtPart = $districtPart;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getStreet()
	{
		return $this->street;
	}

	/**
	 * @param string $street
	 * @return Address
	 */
	public function setStreet($street)
	{
		$this->street = $street;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getHouseNumber()
	{
		return $this->houseNumber;
	}

	/**
	 * @param string $houseNumber
	 * @return Address
	 */
	public function setHouseNumber($houseNumber)
	{
		$this->houseNumber = $houseNumber;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getOrientationNumber()
	{
		return $this->orientationNumber;
	}

	/**
	 * @param string $orientationNumber
	 * @return Address
	 */
	public function setOrientationNumber($orientationNumber)
	{
		$this->orientationNumber = $orientationNumber;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getZipCode()
	{
		return $this->zipCode;
	}

	/**
	 * @param string $zipCode
	 * @return Address
	 */
	public function setZipCode($zipCode)
	{
		$this->zipCode = $zipCode;

		return $this;
	}
}
