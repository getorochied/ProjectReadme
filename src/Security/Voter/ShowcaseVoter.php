<?php

namespace App\Security\Voter;

use App\Entity\Showcase;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ShowcaseVoter extends Voter
{
    public const EDIT = 'EDIT';
    public const DELETE = 'DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // Ce voter gère uniquement les attributs EDIT et DELETE sur les objets Showcase
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof Showcase;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // L'utilisateur doit être connecté
        if (!$user instanceof User) {
            return false;
        }

        /** @var Showcase $showcase */
        $showcase = $subject;

        // Vérifier si l'utilisateur est le propriétaire de la showcase
        return match($attribute) {
            self::EDIT, self::DELETE => $this->canEdit($showcase, $user),
            default => false,
        };
    }

    private function canEdit(Showcase $showcase, User $user): bool
    {
        // Un utilisateur peut éditer/supprimer une showcase seulement s'il en est le propriétaire
        return $showcase->getOwner() === $user;
    }
}
