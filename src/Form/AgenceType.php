<?php

// src/Form/AgenceType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgenceType extends AbstractType
{

    //créer le formulaire 
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('agence', IntegerType::class, options: [
                'label' => 'Agence',
                'disabled' => true
                ])
            ->add('nomagence', TextType::class, options: [
                'label' => 'Nom',
                'required' => true

            ])
            ->add('adresseagence', TextType::class, options: [
                'label' => 'Adresse 1',
                'required' => false

            ])
            ->add('adresseagence2', TextType::class, options: [
                'label' => 'Adresse 2',
                'required' => false

            ])
            ->add('cpagence', TextType::class, options: [
                'label' => 'Code Postal',
                'required' => false
            ])
            ->add('villeagence', TextType::class, options: [
                'label' => 'Ville',
                'required' => false
            ])
            ->add('contactnom', TextType::class, options: [
                'label' => 'Contact Nom',
                'required' => false
            ])
            ->add('contactprenom', TextType::class, options: [
                'label' => 'Contact Prénom',
                'required' => false
            ])
            ->add('contacttel', TextType::class, options: [
                'label' => 'Contact Tel',
                'required' => false
            ])
            ->add('contactportable', TextType::class, options: [
                'label' => 'Contact portable',
                'required' => false
            ])
            ->add('infoouverture', TextType::class, options: [
                'label' => 'info ouverture',
                'required' => false
            ])
            ->add('contactemail', EmailType::class, options: [
                'label' => 'Contact Email',
                'required' => false
            ])
            ->add('commentaires', TextareaType::class, options: [
                'label' => 'Commentaires',
                'required' => false
            ]);
    }

    // relier a ma classe Agence Entity
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Depot\Agence', // Set the target entity class
        ]);
    }
}
