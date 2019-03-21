<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Ip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ip|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ip|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ip[]    findAll()
 * @method Ip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IpRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ip::class);
    }


    /**
     * @param $ip
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function add(string $ip): bool
    {
        $sql = 'INSERT INTO ip (ip, counter) VALUES (:ip, 1) ON DUPLICATE KEY UPDATE counter = counter + 1;';
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);

        return $stmt->execute(['ip' => $ip]);
    }
}
