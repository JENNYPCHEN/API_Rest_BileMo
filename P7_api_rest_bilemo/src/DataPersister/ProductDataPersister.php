<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Brand;
use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ProductDataPersister implements ContextAwareDataPersisterInterface
{
    private $entityManager;
    private $request;

    public function __construct(
        EntityManagerInterface $entityManager,
        RequestStack $request
    ) {
        $this->entityManager = $entityManager;
        $this->request = $request->getCurrentRequest();
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Product;
    }

    public function persist($data, array $context = [])
    {
        $BrandRepository = $this->entityManager->getRepository(Brand::class);
        $filledInBrand = $data->getBrand();
        $brand = $BrandRepository->findOneBy($filledInBrand->getName());

        if ($brand !== null) {
            $data->removeBrand($filledInBrand);
            $data->addBrand($brand);
        } else {
            $this->entityManager->persist($filledInBrand);
        }
        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
    }

    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}
