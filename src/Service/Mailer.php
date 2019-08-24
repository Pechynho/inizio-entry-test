<?php


namespace App\Service;


use Swift_Mailer;
use Swift_Message;

class Mailer
{
	/** @var Swift_Mailer */
	private $mailer;

	/** @var string */
	private $fromEmail;

	/** @var string */
	private $from;

	/**
	 * Mailer constructor.
	 * @param Swift_Mailer $mailer
	 * @param string       $fromEmail
	 * @param string       $from
	 */
	public function __construct(Swift_Mailer $mailer, string $fromEmail, string $from)
	{
		$this->mailer = $mailer;
		$this->fromEmail = $fromEmail;
		$this->from = $from;
	}

	/**
	 * @param string $addressee
	 * @param string $subject
	 * @param string $content
	 * @param string $contentType
	 * @param string $charset
	 * @return bool
	 */
	public function sendEmail(string $addressee, string $subject, string $content, string $contentType = "text/html", string $charset = "UTF-8")
	{
		$message = new Swift_Message();
		$message->setSubject($subject)
			->setFrom([$this->fromEmail => $this->from])
			->setTo($addressee)
			->setBody($content, $contentType, $charset);
		$returnValue = $this->mailer->send($message);

		return $returnValue > 0;
	}
}