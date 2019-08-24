<?php


namespace App\Service;


use App\Annotation\Xml;
use App\Entity\Main\Address;
use App\Entity\Main\Company;
use App\Exception\AresException;
use App\Utils\Requester;
use App\Utils\Strings;
use DateTime;
use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use Exception;
use ReflectionClass;
use ReflectionException;
use SimpleXMLElement;
use Symfony\Component\PropertyAccess\PropertyAccess;

class Ares
{
	/** @var string */
	private $url;

	/**
	 * @param $url
	 */
	public function __construct($url)
	{
		$this->url = $url;
	}


	/**
	 * @param string $ico
	 * @return Company|null
	 * @throws AresException
	 */
	public function createCompany(string $ico)
	{
		$url = Strings::simpleReplace($this->url, "{ico}", $ico);
		try
		{
			$xml = Requester::makeRequest($url);
		}
		catch (Exception $exception)
		{
			throw new AresException($exception->getMessage());
		}
		$xml = new SimpleXMLElement($xml);
		$namespaces = $xml->getDocNamespaces();
		$data = $xml->children($namespaces["are"])->Odpoved;
		if ($data->Pocet_zaznamu != 1)
		{
			return null;
		}
		$companyData = $data->Zaznam;
		$addressData = $companyData->Identifikace->Adresa_ARES->children($namespaces["dtt"]);
		try
		{
			/** @var Company $company */
			$company = $this->createInstance(Company::class, $companyData);
			/** @var Address $address */
			$address = $this->createInstance(Address::class, $addressData);
		}
		catch (AnnotationException | ReflectionException $exception)
		{
			throw new AresException($exception->getMessage());
		}

		return $company->setAddress($address);
	}

	/**
	 * @param string           $class
	 * @param SimpleXMLElement $element
	 * @return object
	 * @throws AnnotationException
	 * @throws ReflectionException
	 */
	private function createInstance(string $class, SimpleXMLElement $element)
	{
		$propertyAccessor = PropertyAccess::createPropertyAccessor();
		$annotationReader = new AnnotationReader();
		$instance = new $class();
		$reflectionClass = new ReflectionClass($class);
		foreach ($reflectionClass->getProperties() as $reflectionProperty)
		{
			/** @var Xml $annotation */
			$annotation = $annotationReader->getPropertyAnnotation($reflectionProperty, Xml::class);
			if ($annotation == null)
			{
				continue;
			}
			$tag = $annotation->tag;
			if (!isset($element->$tag))
			{
				continue;
			}
			$value = (string)$element->$tag;
			if (in_array($annotation->dataType, ["date", "datetime"]))
			{
				$value = DateTime::createFromFormat($annotation->format, $value);
			}
			$propertyAccessor->setValue($instance, $reflectionProperty->getName(), $value);
		}

		return $instance;
	}
}