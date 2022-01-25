<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;

class UserVoter extends Voter
{
    const EDIT = 'edit';
    const DELETE = 'delete';
    const GET = 'get';

    private $security;

    public function __contruct(Security $security){
        $this->security=$security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        if (!in_array($attribute,[self::EDIT,self::DELETE,self::GET])) {
            return false;
        }
        if (!$subject instanceof User) {
            return false;
        }
        return true;
    }
    
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'edit':
                if ($user->getRoles('ROLE_ADMIN') and ( $user === $subject->getClient())){
                    return true;
                }
                break;
            case 'delete':
                if ($user->getRoles('ROLE_ADMIN') and ( $user === $subject->getClient())){
                    return true;
                }
                break;
            case 'get':
                 if ($user->getRoles('ROLE_ADMIN') and ( $user === $subject->getClient())){
                     return true;
                 }  
                 break;

        }

        return false;
    }
}
