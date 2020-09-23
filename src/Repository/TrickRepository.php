<?php

namespace App\Repository;

use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trick::class);
    }

    // /**
    //  * @return Trick[] Returns an array of Trick objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Trick
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findBySlug($slug): ?Trick
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findAllAndPaginate($page, $nbMaxByPage)
    {
        if (!is_numeric($page)) {
            throw new \InvalidArgumentException(
                'La valeur de l\'argument $page est incorrecte (valeur : ' . $page . ').'
            );
        }

        if ($page < 1) {
            throw new NotFoundHttpException('La page demandée n\'existe pas');
        }

        if (!is_numeric($nbMaxByPage)) {
            throw new \InvalidArgumentException(
                'La valeur de l\'argument $nbMaxParPage est incorrecte (valeur : ' . $nbMaxByPage . ').'
            );
        }

        $firstResult = ($page - 1) * $nbMaxByPage;
        $qb = $this->createQueryBuilder('a')
            ->orderBy('a.creationDate', 'DESC')
            ->setFirstResult($firstResult)
            ->setMaxResults($nbMaxByPage)
            ->getQuery();

        $paginator = new Paginator($qb);

        if ( ($paginator->count() <= $firstResult) && $page != 1) {
            throw new NotFoundHttpException('La page demandée n\'existe pas.'); // page 404, sauf pour la première page
        }

        return $paginator;
    }

    public function findAllCounted()
    {
        $queryBuilder = $this->createQueryBuilder();

        $queryBuilder->select('COUNT(u.id)')
            ->from(Trick::class, 'i');

        $query = $queryBuilder->getQuery();

        echo $query->getDQL(), "\n";
        echo $query->getSingleScalarResult();

    }
}
