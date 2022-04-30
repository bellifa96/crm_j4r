<?php

namespace App\Form\Interlocuteur;

use App\Entity\Interlocuteur\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'personne-form'
                ]
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Prénom',
                    'class' => 'personne-form'
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'personne-form'
                ]
            ])
            ->add('adresse1', TextType::class, [
                'attr' => [
                    'placeholder' => 'Adresse',
                    'class' => 'personne-form'
                ]
            ])
            ->add('adresse2', TextType::class, [
                'attr' => [
                    'placeholder' => 'Adresse 1',
                    'class' => 'personne-form'

                ],
                'required' => false,

            ])
            ->add('ville', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ville',
                    'class' => 'personne-form'
                ]
            ])
            ->add('codePostal', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Code Postal',
                    'class' => 'personne-form'
                ]
            ])
            ->add('pays', TextType::class, [
                'attr' => [
                    'placeholder' => 'Pays',
                    'class' => 'personne-form'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
