<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Ip;
use App\Repository\IpRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class IpStorageDoctrineService implements IpStorageInterface
{

    /** @var  IpRepository */
    protected $ipRepository;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->ipRepository = $managerRegistry->getRepository(Ip::class);
    }

    /**
     * @param string $ip
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function add(string $ip): int
    {
        $this->ipRepository->add($ip);

        return $this->query($ip);
    }


    /**
     * @param string $ip
     * @return int
     */
    public function query(string $ip): int
    {
        $entity = $this->getEntityByIp($ip);

        if (!$entity) {
            return 0;
        }

        return $entity->getCounter();
    }

    /**
     * @param string $ip
     * @return Ip|null
     */
    protected function getEntityByIp(string $ip): ?Ip
    {
        return $this->ipRepository->findOneBy(['ip' => $ip]);
    }
}