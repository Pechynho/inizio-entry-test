<?php

namespace App\Controller;

use App\Entity\Sakila\Address;
use App\Form\Type\EmailType;
use App\Model\Email;
use App\Service\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sakila")
 */
class SakilaController extends AbstractController
{
	/**
	 * @return Response
	 *
	 * @Route("/rss.xml", name="app_sakila_rss", defaults={"_format": "xml"})
	 */
	public function rss()
	{
		return $this->render("sakila/rss.xml.twig", [
			"feeds" => $this->getDoctrine()->getManagerForClass(Address::class)->getRepository(Address::class)->findFeeds()
		]);
	}

	/**
	 * @param Address $address
	 * @param Request $request
	 * @param Mailer  $mailer
	 * @return Response
	 *
	 * @Route("/adresa/{id}", name="app_sakila_address_show")
	 */
	public function addressShow(Address $address, Request $request, Mailer $mailer)
	{
		$email = new Email();
		$form = $this->createForm(EmailType::class, $email);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid())
		{
			$content = $this->renderView("sakila/address_email.html.twig", ["address" => $address]);
			$result = $mailer->sendEmail($email->getEmail(), $this->getParameter("app.application_name") . " | " .  $address->getAddress(), $content);
			if ($result)
			{
				$this->addFlash("success", "Údaje byly úspěšně odeslány na zadaný e-mail.");
			}
			else
			{
				$this->addFlash("danger", "Údaje se nepodařilo odeslat na zadaný e-mail.");
			}

			return $this->redirectToRoute("app_sakila_address_show", ["id" => $address->getId()]);
		}

		return $this->render("sakila/address_show.html.twig", [
			"hide_footer" => true,
			"hide_navbar" => true,
			"address"     => $address,
			"form"        => $form->createView()
		]);
	}
}
