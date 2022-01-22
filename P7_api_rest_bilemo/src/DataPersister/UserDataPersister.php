<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Brand;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface as TokenStorageTokenStorageInterface;

class UserDataPersister implements ContextAwareDataPersisterInterface
{
    private $entityManager;
    private $userPasswordHasher;
    private $request;
    private $security;
    

    public function __construct(
        EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, RequestStack $request,TokenStorageTokenStorageInterface $tokenStorage,Security $security
    ) {
        $this->entityManager = $entityManager;
        $this->userPasswordHasher=$userPasswordHasher;
        $this->request=$request;
        $this->security=$security;
        $this->tokenStorage=$tokenStorage;
      
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    public function persist($data, array $context = [])
    {

   
        if ($data->getPlainPassword()){
            $data->setPassword($this->userPasswordHasher->hashPassword($data,$data->getPlainPassword()));
            $data->eraseCredentials();
        }
        if($this->request->getCurrentRequest()->getMethod()=="POST"){ 

            $data->setClient($this->security->getUser());
        }
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}
