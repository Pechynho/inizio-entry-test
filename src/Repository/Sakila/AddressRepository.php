<?php

namespace App\Repository\Sakila;

use App\Entity\Sakila\Address;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Address|null find($id, $lockMode = null, $lockVersion = null)
 * @method Address|null findOneBy(array $criteria, array $orderBy = null)
 * @method Address[]    findAll()
 * @method Address[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddressRepository extends ServiceEntityRepository
{
	const FEEDS_COUNT = 20;

	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Address::class);
	}

	/**
	 * @return Address[]
	 */
	public function findFeeds()
	{
		$queryBuilder = $this->createQueryBuilder("address")
			->select(["address"])
			->orderBy("address.lastUpdate", "DESC")
			->setMaxResults(self::FEEDS_COUNT);
		$result = $queryBuilder->getQuery()->getResult();

		return $result;
	}

	// /**
	//  * @return Address[] Returns an array of Address objects
	//  */
	/*
	public function findByExampleField($value)
	{
		return $this->createQueryBuilder('a')
			->andWhere('a.exampleField = :val')
			->setParameter('val', $value)
			->orderBy('a.id', 'ASC')
			->setMaxResults(10)
			->getQuery()
			->getResult()
		;
	}
	*/

	/*
	public function findOneBySomeField($value): ?Address
	{
		return $this->createQueryBuilder('a')
			->andWhere('a.exampleField = :val')
			->setParameter('val', $value)
			->getQuery()
			->getOneOrNullResult()
		;
	}
	*/
}
