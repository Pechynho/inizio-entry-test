<?php

namespace App\Controller;

use App\Entity\Main\Company;
use App\Exception\AresException;
use App\Form\FilterType\CompanyFilterType;
use App\Form\Type\SearchRequestType;
use App\Model\SearchRequest;
use App\Service\Ares;
use App\Utils\Paginator;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdater;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
	/**
	 * @return RedirectResponse
	 *
	 * @Route("/", name="homepage")
	 */
	public function index()
	{
		return $this->redirectToRoute("app_ares_company_search");
	}

	/**
	 * @param RequestStack $requestStack
	 * @return Response
	 */
	public function navbar(RequestStack $requestStack)
	{
		return $this->render("base/_navbar.html.twig", [
			"request" => $requestStack->getMasterRequest()
		]);
	}
}
