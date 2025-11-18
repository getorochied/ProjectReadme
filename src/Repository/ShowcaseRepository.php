<?php

namespace App\Repository;

use App\Entity\Showcase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Showcase>
 */
class ShowcaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Showcase::class);
    }

    /**
     * Trouve toutes les showcases publiques
     */
    public function findPublicShowcases(): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.isPublic = :isPublic')
            ->setParameter('isPublic', true)
            ->orderBy('s.title', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouve les showcases d'un utilisateur
     */
    public function findByOwner(int $ownerId): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.owner = :ownerId')
            ->setParameter('ownerId', $ownerId)
            ->orderBy('s.title', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
