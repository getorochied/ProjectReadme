<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Showcase;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShowcaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de la showcase',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ex: Projets Infrastructure 2025']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control', 'rows' => 4, 'placeholder' => 'Décrivez cette galerie de projets...']
            ])
            ->add('isPublic', CheckboxType::class, [
                'label' => 'Showcase publique ?',
                'required' => false,
                'attr' => ['class' => 'form-check-input']
            ])
            ->add('owner', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
                'label' => 'Propriétaire',
                'attr' => ['class' => 'form-select']
            ])
            ->add('projects', EntityType::class, [
                'class' => Project::class,
                'choice_label' => 'title',
                'multiple' => true,
                'label' => 'Projets à inclure',
                'attr' => ['class' => 'form-select'],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Showcase::class,
        ]);
    }
}
