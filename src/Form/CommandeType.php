<?php

namespace App\Form;

use App\Entity\Transport\CdeMatDet;
use App\Entity\Transport\CdeMatEnt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DecimalType;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NumDevis', IntegerType::class, [
                'label' => 'Num Devis',
                'disabled' => true,
            ])
            ->add('IdClient', IntegerType::class, [
                'label' => 'Id CLient',
                'disabled' => true,
            ])
            ->add('NomClient', TextType::class, [
                'label' => 'Nom Client',
                'disabled' => true,
            ])
            ->add('CodeChantier', IntegerType::class, [
                'label' => 'Code Chantier',
                'disabled' => true,
                'required' => false,
            ])
            ->add('NumAffaire', TextType::class, [
                'label' => 'Numero Affaire',
                'disabled' => true,
                'required' => false,
            ])
            ->add('AdresseChantier', TextareaType::class, [
                'label' => 'Adresse Chantier',
                'disabled' => true,
                'required' => false,
            ])
            ->add('CpChantier', TextType::class, [
                'label' => 'Code Chantier',
                'disabled' => true,
                'required' => false,
            ])
            ->add('VilleChantier', TextType::class, [
                'label' => 'Ville Chantier',
                'disabled' => true,
                'required' => false,
            ])

            ->add('DateCde', DateType::class, [
                'label' => 'Date du Commande',
                'disabled' => true,
            ])

            ->add('PoidsTotMat', IntegerType::class, [
                'label' => 'Poids Total',
                'disabled' => true,
            ])
            ->add('Initiales', TextType::class, [
                'label' => 'Initiales',
                'disabled' => true,
                'required' => false,
            ])
            ->add('IdAgence', IntegerType::class, [
                'label' => 'Id Agences',
                'disabled' => true,
            ])
            ->add('NumErpVente', IntegerType::class, [
                'label' => 'Numero Erp Location',
            ])
            ->add('NumErpLocation', IntegerType::class, [
                'label' => 'Numéro Vente Vente',
            ]);
          
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CdeMatEnt::class,
        ]);
    }
}
