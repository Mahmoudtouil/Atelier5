<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }
    // src/Repository/BookRepository.php




    public function searchBookByRef($ref)
    {
        return $this->createQueryBuilder('b')
            ->where('b.ref = :ref')
            ->setParameter('ref', $ref)
            ->getQuery()
            ->getResult();
    }

    

    public function booksListByAuthors()
    {
        return $this->createQueryBuilder('b')
            ->leftJoin('b.author', 'a')
            ->orderBy('a.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    

    public function booksBefore2023WithMoreThan10Books()
    {
        return $this->createQueryBuilder('b')
            ->leftJoin('b.author', 'a')
            ->where('b.publishedAt < :date')
            ->andWhere('a.nbBooks > 10')
            ->setParameter('date', new \DateTime('2023-01-01'))
            ->getQuery()
            ->getResult();
    }

  
    public function updateBooksCategory()
    {
        return $this->createQueryBuilder('b')
            ->update('App:Book', 'b')
            ->set('b.category', ':newCategory')
            ->where('b.category = :oldCategory')
            ->setParameter('oldCategory', 'Science-Fiction')
            ->setParameter('newCategory', 'Romance')
            ->getQuery()
            ->execute();
    }

    

  public function countRomanceBooks()
    {
        return $this->createQueryBuilder('b')
            ->select('COUNT(b.id)')
            ->where('b.category = :category')
            ->setParameter('category', 'Romance')
            ->getQuery()
            ->getSingleScalarResult();
    }

    // src/Repository/BookRepository.php


    public function booksPublishedBetweenDates($startDate, $endDate)
    {
        return $this->createQueryBuilder('b')
            ->where('b.publishedAt >= :startDate')
            ->andWhere('b.publishedAt <= :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->getQuery()
            ->getResult();
    }

    













//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
