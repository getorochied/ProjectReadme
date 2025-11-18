<?php

namespace App\Form;

use App\Entity\Portfolio;
use App\Entity\Project;
use App\Entity\Showcase;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre du projet',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ex: API REST MiNET']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control', 'rows' => 5, 'placeholder' => 'Décrivez votre projet...'],
                'required' => false
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'Non démarré' => 'not_started',
                    'En cours' => 'in_progress',
                    'Terminé' => 'completed',
                    'En pause' => 'on_hold',
                    'Annulé' => 'cancelled'
                ],
                'attr' => ['class' => 'form-select']
            ])
            ->add('startDate', DateType::class, [
                'label' => 'Date de début',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('endDate', DateType::class, [
                'label' => 'Date de fin',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('portfolio', EntityType::class, [
                'class' => Portfolio::class,
                'choice_label' => 'description',
                'label' => 'Portfolio',
                'attr' => ['class' => 'form-select']
            ])
            ->add('members', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
                'multiple' => true,
                'label' => 'Membres du projet',
                'attr' => ['class' => 'form-select'],
                'required' => false
            ])
            ->add('showcases', EntityType::class, [
                'class' => Showcase::class,
                'choice_label' => 'title',
                'multiple' => true,
                'label' => 'Showcases associées',
                'attr' => ['class' => 'form-select'],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
