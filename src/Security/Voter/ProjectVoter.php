<?php

namespace App\Security\Voter;

use App\Entity\Project;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ProjectVoter extends Voter
{
    public const EDIT = 'EDIT';
    public const DELETE = 'DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // Ce voter gère uniquement les attributs EDIT et DELETE sur les objets Project
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof Project;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // L'utilisateur doit être connecté
        if (!$user instanceof User) {
            return false;
        }

        /** @var Project $project */
        $project = $subject;

        // Vérifier si l'utilisateur est le propriétaire du portfolio qui contient le projet
        return match($attribute) {
            self::EDIT, self::DELETE => $this->canEdit($project, $user),
            default => false,
        };
    }

    private function canEdit(Project $project, User $user): bool
    {
        // Un utilisateur peut éditer/supprimer un projet seulement s'il est
        // le propriétaire du portfolio qui contient ce projet
        return $project->getPortfolio()->getOwner() === $user;
    }
}
