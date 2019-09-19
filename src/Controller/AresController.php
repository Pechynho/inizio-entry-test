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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AresController extends AbstractController
{
	/**
	 * @param Request         $request
	 * @param Ares            $ares
	 * @param LoggerInterface $logger
	 * @param ObjectManager   $objectManager
	 * @return Response
	 * @throws
	 *
	 * @Route("/vyhledavani", name="app_ares_company_search")
	 */
	public function companySearch(Request $request, Ares $ares, LoggerInterface $logger, ObjectManager $objectManager)
	{
		$searchRequest = (new SearchRequest())->setSearched(new DateTime());
		$form = $this->createForm(SearchRequestType::class, $searchRequest);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid())
		{
			$company = $objectManager->getRepository(Company::class)->findOneBy(["ico" => $searchRequest->getIco()]);
			if ($company != null)
			{
				$this->addFlash("info", "Subjekt byl již v minulosti vyhledán. Můžete ho nalézt ve výpisu níže.");
				return $this->redirectToRoute("app_ares_companies_list");
			}
			try
			{
				$company = $ares->createCompany($searchRequest->getIco());
			}
			catch (AresException $exception)
			{
				$this->addFlash("danger", "Při zpracovávání dat vrácených pomocí ARES API došlo k chybě.");
				$logger->error($exception->getMessage());
				return $this->redirectToRoute("app_ares_company_search");
			}
			if ($company == null)
			{
				$this->addFlash("danger", "Subjekt se dle zadaného hodnoty nepodařilo nalézt.");
				return $this->redirectToRoute("app_ares_company_search");
			}
			$this->addFlash("success", "Subjekt byl úspěšně vyhledán. Můžete ho nalézt ve výpisu níže.");
			$company->setSearched($searchRequest->getSearched());
			$objectManager->persist($company);
			$objectManager->flush();

			return $this->redirectToRoute("app_ares_companies_list");
		}
		return $this->render("ares/search.html.twig", [
			"form" => $form->createView()
		]);
	}

	/**
	 * @param Paginator            $paginator
	 * @param Request              $request
	 * @param FilterBuilderUpdater $builderUpdater
	 * @return Response
	 * @throws
	 *
	 * @Route("/vypis", name="app_ares_companies_list")
	 */
	public function companiesList(Paginator $paginator, Request $request, FilterBuilderUpdater $builderUpdater)
	{
		$form = $this->createForm(CompanyFilterType::class);
		$form->handleRequest($request);
		$queryBuilder = $this->getDoctrine()->getRepository(Company::class)->createQueryBuilder("company");
		if ($form->isSubmitted() && $form->isValid())
		{
			$builderUpdater->addFilterConditions($form, $queryBuilder);
		}
		if (!$paginator->isSorted())
		{
			$queryBuilder->orderBy("company.searched", "DESC");
		}
		/** @var Company[]|PaginatorInterface $pagination */
		$pagination = $paginator->createPagination($queryBuilder);
		$response = $this->render("ares/list.html.twig", [
			"companies"             => $pagination,
			"form"                  => $form->createView(),
			"companies_total_count" => $this->getDoctrine()->getRepository(Company::class)->count([])
		]);
		$response->headers->setCookie($paginator->createLimitCookie());
		return $response;
	}

	/**
	 * @param Company $company
	 * @return Response
	 *
	 * @Route("/subjekt/{id}", name="app_ares_company_detail", options={"expose": "true"})
	 */
	public function companyDetail(Company $company)
	{
		return $this->render("ares/_detail.html.twig", [
			"company" => $company
		]);
	}
}
