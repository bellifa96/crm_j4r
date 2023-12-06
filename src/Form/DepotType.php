<?php

namespace App\Form;

use App\Entity\Depot\Agence;
use App\Repository\Depot\AgenceRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;  // Make sure to import EntityType

class DepotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codedepot', IntegerType::class, [
                'label' => 'Code Depot',
            ])
            ->add('nomdepot', TextType::class, [
                'label' => 'Nom Depot',
            ])
            ->add('adressedepot', TextType::class, [
                'label' => 'Adresse Depot',
            ])
            ->add('adressedepot2', TextType::class, [
                'label' => 'Adresse Depot (suite)',
            ])
            ->add('cpdepot', TextType::class, [
                'label' => 'Code Postal Depot',
            ])
            ->add('villedepot', TextType::class, [
                'label' => 'Ville Depot',
            ])
            ->add('contactnom', TextType::class, [
                'label' => 'Nom du Contact',
            ])
            ->add('contactprenom', TextType::class, [
                'label' => 'Prenom du Contact',
            ])
            ->add('contacttel', TextType::class, [
                'label' => 'Téléphone du Contact',
            ])
            ->add('contactportable', TextType::class, [
                'label' => 'Portable du Contact',
            ])
            ->add('infoouverture', TextType::class, [
                'label' => 'Informations sur l\'Ouverture',
            ])
            ->add('contactemail', EmailType::class, [
                'label' => 'Email du Contact',
            ])
            ->add('commentaires', TextareaType::class, [
                'label' => 'Commentaires',
            ])
            ->add('codechantier', IntegerType::class, [
                'label' => 'Code Chantier',
            ])
            ->add('agence', EntityType::class, [
                'class' => Agence::class,
                'query_builder' => function (AgenceRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('u');
                },
                'choice_label' => 'nomagence',
                'label' => 'Agence',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
