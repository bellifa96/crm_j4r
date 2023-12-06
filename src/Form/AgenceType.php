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
                'label' => 'Agence'
            ])
            ->add('nomagence', TextType::class, options: [
                'label' => 'Nom'
            ])
            ->add('adresseagence', TextType::class, options: [
                'label' => 'Adresse 1'
            ])
            ->add('adresseagence2', TextType::class, options: [
                'label' => 'Adresse 2'
            ])
            ->add('cpagence', TextType::class, options: [
                'label' => 'Code Postal'
            ])
            ->add('villeagence', TextType::class, options: [
                'label' => 'Ville'
            ])
            ->add('contactnom', TextType::class, options: [
                'label' => 'Contact Nom'
            ])
            ->add('contactprenom', TextType::class, options: [
                'label' => 'Contact Prénom'
            ])
            ->add('contacttel', TextType::class, options: [
                'label' => 'Contact Tel'
            ])
            ->add('contactportable', TextType::class, options: [
                'label' => 'Contact portable'
            ])
            ->add('infoouverture', TextType::class, options: [
                'label' => 'info ouverture'
            ])
            ->add('contactemail', EmailType::class, options: [
                'label' => 'Contact Email'
            ])
            ->add('commentaires', TextareaType::class, options: [
                'label' => 'Commentaires'
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
