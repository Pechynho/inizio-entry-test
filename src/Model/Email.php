<?php


namespace App\Model;


use Symfony\Component\Validator\Constraints as Assert;

class Email
{
	/**
	 * @var string
	 * @Assert\NotBlank()
	 * @Assert\Email()
	 */
	private $email;

	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 * @return Email
	 */
	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
	}
}