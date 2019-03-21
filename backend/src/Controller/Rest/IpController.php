<?php

declare(strict_types=1);

namespace App\Controller\Rest;

use App\Service\IpStorageDoctrineService;
use App\Service\ValidationService;
use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IpController extends AbstractController
{
    /**
     * @Route("ip/{ipValue}", name="ip_add", methods={"PUT"})
     * @param string $ipValue
     * @param ValidationService $validationService
     * @param IpStorageDoctrineService $ipStorage
     * @return JsonResponse
     * @throws DBALException
     */
    public function add(
        string $ipValue,
        ValidationService $validationService,
        IpStorageDoctrineService $ipStorage
    ): JsonResponse
    {
        $errors = $validationService->validateIp($ipValue);
        if (count($errors) > 0) {
            return $this->json(['errorData' => (string)$errors], Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        return $this->json(['data' => ['ip' => $ipValue, 'counter' => $ipStorage->add($ipValue)]]);
    }

    /**
     * @Route("ip/{ipValue}", name="ip_query", methods={"GET"})
     * @param $ipValue
     * @param ValidationService $validationService
     * @param IpStorageDoctrineService $ipStorage
     * @return JsonResponse
     */
    public function query(
        string $ipValue,
        ValidationService $validationService,
        IpStorageDoctrineService $ipStorage
    ): JsonResponse
    {
        $errors = $validationService->validateIp($ipValue);
        if (count($errors) > 0) {
            return $this->json(['errorData' => (string)$errors], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->json(['data' => ['ip' => $ipValue, 'counter' => $ipStorage->query($ipValue)]]);
    }
}
