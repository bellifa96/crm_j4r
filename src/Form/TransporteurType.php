<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
class TransporteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('societe', TextType::class, ['label' => 'Société'])
        ->add('nom', TextType::class, ['label' => 'Nom'])
        ->add('prenom', TextType::class, ['label' => 'Prénom'])
        ->add('adresse', TextType::class, ['label' => 'Adresse'])
        ->add('adresse2', TextType::class, ['label' => 'Adresse 2'])
        ->add('cp', TextType::class, ['label' => 'Code Postal'])
        ->add('ville', TextType::class, ['label' => 'Ville'])
        ->add('tel', TextType::class, ['label' => 'Téléphone'])
        ->add('portable', TextType::class, ['label' => 'Portable'])
        ->add('rcs', TextType::class, ['label' => 'RCS'])
        ->add('rcstxt', TextType::class, ['label' => 'RCS Text'])
        ->add('ape', TextType::class, ['label' => 'APE'])
        ->add('dombancaire', TextType::class, ['label' => 'Domiciliation bancaire'])
        ->add('codebanque', TextType::class, ['label' => 'Code banque'])
        ->add('codeguichet', TextType::class, ['label' => 'Code guichet'])
        ->add('numcompte', TextType::class, ['label' => 'Numéro de compte'])
        ->add('clefrib', TextType::class, ['label' => 'Clé RIB'])
        ->add('actif', CheckboxType::class, ['label' => 'Actif'])
        ->add('coderech', TextType::class, ['label' => 'Code recherche'])
        ->add('datemodifinv', TextType::class, ['label' => 'Date modification inventaire'])
        ->add('occasionnel', CheckboxType::class, ['label' => 'Occasionnel'])
        ->add('email', EmailType::class, ['label' => 'Email'])
        ->add('tauxhoraire', NumberType::class, ['label' => 'Taux horaire'])
        ->add('tauxtour', NumberType::class, ['label' => 'Taux tour'])
        ->add('tauxjour', NumberType::class, ['label' => 'Taux jour'])
        ->add('tauxdemijour', NumberType::class, ['label' => 'Taux demi-jour'])
        ->add('tauxtonne', NumberType::class, ['label' => 'Taux tonne'])
        ->add('iban', TextType::class, ['label' => 'IBAN']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Depot\Transporteur', // Set the target entity class
        ]);
    }
}
