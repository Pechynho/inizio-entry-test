<?php
/**
 * Created by PhpStorm.
 * User: Pechy
 * Date: 30.01.2018
 * Time: 8:12
 */

namespace App\Utils;


use DateTime;
use Doctrine\ORM\QueryBuilder;
use Exception;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class Paginator
{
	/** @var Request */
	private $request;

	/** @var string */
	private $defaultLimit;

	/** @var PaginatorInterface */
	private $paginator;

	/** @var int[] */
	private $possibleLimits;

	/** @var string */
	private $pageParamName;

	/** @var string */
	private $limitParamName;

	/** @var string */
	private $sortFieldParamName;

	/** @var string */
	private $sortDirectionParamName;

	/** @var string */
	private $filterFieldParamName;

	/** @var string */
	private $filterValueParamName;

	const DEFAULT_COOKIE_NAME = "paginationLimit";

	/**
	 * PaginatorWrapper constructor.
	 * @param PaginatorInterface $paginator
	 * @param RequestStack       $requestStack
	 * @param int                $defaultLimit
	 * @param int[]              $possibleLimits
	 * @param string             $pageParamName
	 * @param string             $limitParamName
	 * @param string             $sortFieldParamName
	 * @param string             $sortDirectionParamName
	 * @param string             $filterFieldParamName
	 * @param string             $filterValueParamName
	 */
	public function __construct(PaginatorInterface $paginator, RequestStack $requestStack, $defaultLimit, $possibleLimits, $pageParamName, $limitParamName, $sortFieldParamName, $sortDirectionParamName, $filterFieldParamName, $filterValueParamName)
	{
		$this->paginator = $paginator;
		$this->request = $requestStack->getCurrentRequest();
		$this->defaultLimit = $defaultLimit;
		$this->possibleLimits = $possibleLimits;
		$this->pageParamName = $pageParamName;
		$this->limitParamName = $limitParamName;
		$this->sortFieldParamName = $sortFieldParamName;
		$this->sortDirectionParamName = $sortDirectionParamName;
		$this->filterFieldParamName = $filterFieldParamName;
		$this->filterValueParamName = $filterValueParamName;
	}

	/**
	 * @param string $pageParamName
	 * @return int
	 */
	private function getPage($pageParamName)
	{
		return $this->request->query->getInt($pageParamName, 1);
	}

	/**
	 * @param int         $limitParamName
	 * @param null|string $limitCookieName
	 * @return int
	 */
	private function getLimit($limitParamName, $limitCookieName = null)
	{
		$limit = $this->request->query->get($limitParamName);
		if ($limitCookieName != null && $limit == null && $this->request->cookies->has($limitCookieName))
		{
			$limit = $this->request->cookies->get($limitCookieName);
		}
		if (!$this->hasLimit($limit))
		{
			$limit = $this->defaultLimit;
		}

		return $limit;
	}

	/**
	 * @param int $limit
	 * @return bool
	 */
	private function hasLimit($limit)
	{
		foreach ($this->possibleLimits as $possibleLimit)
		{
			if ($limit == $possibleLimit)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * @param string|null $paginatorName
	 * @return int
	 */
	public function page($paginatorName = null)
	{
		return $this->getPage($this->paginatorParamPrefix($paginatorName) . $this->pageParamName);
	}

	/**
	 * @param string|null $limitCookieName
	 * @param string|null $paginatorName
	 * @return int
	 */
	public function limit($limitCookieName = "paginationLimit", $paginatorName = null)
	{
		$limitCookieName = $paginatorName != null && $limitCookieName == self::DEFAULT_COOKIE_NAME ? $paginatorName . Strings::firstUpper(self::DEFAULT_COOKIE_NAME) : $limitCookieName;

		return $this->getLimit($this->paginatorParamPrefix($paginatorName) . $this->limitParamName, $limitCookieName);
	}

	/**
	 * @param string|null $paginatorName
	 * @return bool
	 */
	public function isSorted($paginatorName = null)
	{
		return $this->request->get($this->paginatorParamPrefix($paginatorName) . $this->sortFieldParamName) != null;
	}

	/**
	 * @param string|null $paginatorName
	 * @return string
	 */
	private function paginatorParamPrefix($paginatorName = null)
	{
		return $paginatorName == null ? "" : Strings::caseToDashes($paginatorName) . "-";
	}

	/**
	 * @param QueryBuilder $queryBuilder
	 * @param null|string  $limitCookieName
	 * @param string|null  $paginatorName
	 * @return PaginationInterface
	 */
	public function createPagination($queryBuilder, $limitCookieName = "paginationLimit", $paginatorName = null)
	{
		$page = $this->page($paginatorName);
		$limit = $this->limit($limitCookieName, $paginatorName);
		$options = [];
		if ($paginatorName != null)
		{
			$options = [
				"pageParameterName"          => $this->paginatorParamPrefix($paginatorName) . $this->pageParamName,
				"sortFieldParameterName"     => $this->paginatorParamPrefix($paginatorName) . $this->sortFieldParamName,
				"sortDirectionParameterName" => $this->paginatorParamPrefix($paginatorName) . $this->sortDirectionParamName,
				"filterFieldParameterName"   => $this->paginatorParamPrefix($paginatorName) . $this->filterFieldParamName,
				"filterValueParameterName"   => $this->paginatorParamPrefix($paginatorName) . $this->filterValueParamName,
			];
		}

		return $this->paginator->paginate($queryBuilder, $page, $limit, $options);
	}

	/**
	 * @param string      $limitCookieName
	 * @param string|null $paginatorName
	 * @return Cookie
	 * @throws Exception
	 */
	public function createLimitCookie($limitCookieName = "paginationLimit", $paginatorName = null)
	{
		$limitCookieName = $paginatorName != null && $limitCookieName == self::DEFAULT_COOKIE_NAME ? $paginatorName . Strings::firstUpper(self::DEFAULT_COOKIE_NAME) : $limitCookieName;

		return new Cookie($limitCookieName, $this->limit($limitCookieName, $paginatorName), (new DateTime())->modify("+ 365 days"), parse_url($this->request->getUri())["path"]);
	}
}