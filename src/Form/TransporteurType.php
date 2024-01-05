<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
class TransporteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('societe', TextType::class, ['label' => 'Société', 'required' => true])
        ->add('nom', TextType::class, ['label' => 'Nom', 'required' => true])
        ->add('prenom', TextType::class, ['label' => 'Prénom', 'required' => true])
        ->add('adresse', TextType::class, ['label' => 'Adresse', 'required' => true])
        ->add('adresse2', TextType::class, ['label' => 'Adresse 2', 'required' => false])
        ->add('cp', TextType::class, ['label' => 'Code Postal', 'required' => false])
        ->add('ville', TextType::class, ['label' => 'Ville', 'required' => false])
        ->add('tel', TextType::class, ['label' => 'Téléphone', 'required' => false])
        ->add('portable', TextType::class, ['label' => 'Portable', 'required' => false])
        ->add('rcs', TextType::class, ['label' => 'RCS', 'required' => false])
        ->add('rcstxt', TextType::class, ['label' => 'RCS Text', 'required' => false])
        ->add('ape', TextType::class, ['label' => 'APE', 'required' => false])
        ->add('dombancaire', TextType::class, ['label' => 'Domiciliation bancaire', 'required' => false])
        ->add('codebanque', TextType::class, ['label' => 'Code banque', 'required' => false])
        ->add('codeguichet', TextType::class, ['label' => 'Code guichet', 'required' => false])
        ->add('numcompte', TextType::class, ['label' => 'Numéro de compte', 'required' => false])
        ->add('clefrib', TextType::class, ['label' => 'Clé RIB', 'required' => false])
        ->add('actif', CheckboxType::class, ['label' => 'Actif', 'required' => false])
        ->add('coderech', TextType::class, ['label' => 'Code recherche', 'required' => false])
        ->add('datemodif',DateType::class, [
            'label' => 'Date de vérification de la grue',
            'widget' => 'single_text', // Use 'single_text' widget for a simple text input
            'html5' => true, // Enable HTML5 date and time input
            'required' => false, // Set to true if the field is required
        ])
        ->add('occasionnel', CheckboxType::class, ['label' => 'Occasionnel', 'required' => false])
        ->add('email', EmailType::class, ['label' => 'Email', 'required' => false])
        ->add('tauxhoraire', NumberType::class, ['label' => 'Taux horaire', 'required' => false])
        ->add('tauxtour', NumberType::class, ['label' => 'Taux tour', 'required' => false])
        ->add('tauxjour', NumberType::class, ['label' => 'Taux jour', 'required' => false])
        ->add('tauxdemijour', NumberType::class, ['label' => 'Taux demi-jour', 'required' => false])
        ->add('tauxtonne', NumberType::class, ['label' => 'Taux tonne', 'required' => false])
        ->add('iban', TextType::class, ['label' => 'IBAN', 'required' => false])
        ->add('tauxprefere', NumberType::class, ['label' => 'IBAN', 'required' => false]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Depot\Transporteur', // Set the target entity class
        ]);
    }
}
