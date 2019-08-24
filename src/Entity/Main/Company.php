<?php

namespace App\Entity\Main;

use App\Annotation\Xml;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Main\CompanyRepository")
 */
class Company
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 * @Xml(tag="Obchodni_firma")
	 */
    private $name;

	/**
	 * @var string
	 * @ORM\Column(type="string", unique=true)
	 * @Xml(tag="ICO")
	 */
    private $ico;

	/**
	 * @var DateTime
	 * @ORM\Column(type="date")
	 * @Xml(tag="Datum_vzniku", dataType="date", format="Y-m-d")
	 */
    private $creationDate;

	/**
	 * @var DateTime
	 * @ORM\Column(type="datetime")
	 */
    private $searched;

	/**
	 * @var Address
	 * @ORM\OneToOne(targetEntity="App\Entity\Main\Address", fetch="EAGER", cascade={"all"}, orphanRemoval=true)
	 * @ORM\JoinColumn(name="address_id", referencedColumnName="id", nullable=false)
	 */
    private $address;

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
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return Company
	 */
	public function setName(string $name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @return Address
	 */
	public function getAddress()
	{
		return $this->address;
	}

	/**
	 * @param Address $address
	 * @return Company
	 */
	public function setAddress($address)
	{
		$this->address = $address;

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
	 * @return Company
	 */
	public function setIco($ico)
	{
		$this->ico = $ico;

		return $this;
	}

	/**
	 * @return DateTime
	 */
	public function getCreationDate()
	{
		return $this->creationDate;
	}

	/**
	 * @param DateTime $creationDate
	 * @return Company
	 */
	public function setCreationDate($creationDate)
	{
		$this->creationDate = $creationDate;

		return $this;
	}

	/**
	 * @return DateTime
	 */
	public function getSearched()
	{
		return $this->searched;
	}

	/**
	 * @param DateTime $searched
	 * @return Company
	 */
	public function setSearched($searched)
	{
		$this->searched = $searched;

		return $this;
	}
}
