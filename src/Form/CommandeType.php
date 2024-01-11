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
                'required' => false, // Ensure this field is not required

            ])
            ->add('IdClient', IntegerType::class, [
                'label' => 'Id CLient',
                
            ])
            ->add('NomClient', TextType::class, [
                'label' => 'Nom Client',
                
            ])
            ->add('CodeChantier', IntegerType::class, [
                'label' => 'Code Chantier',
                
                'required' => false,
            ])
            ->add('NumAffaire', TextType::class, [
                'label' => 'Numero Affaire',
                
                'required' => false,
            ])
            ->add('AdresseChantier', TextareaType::class, [
                'label' => 'Adresse Chantier',
                
                'required' => false,
            ])
            ->add('CpChantier', TextType::class, [
                'label' => 'Code Chantier',
                
                'required' => false,
            ])
            ->add('VilleChantier', TextType::class, [
                'label' => 'Ville Chantier',
                
                'required' => false,
            ])

            ->add('DateCde',DateType::class, [
                'label' => 'Date de vérification de la grue',
                'widget' => 'single_text', // Use 'single_text' widget for a simple text input
                'html5' => true, // Enable HTML5 date and time input
                'required' => false, // Set to true if the field is required
            ])
            ->add('DateEnlevDem',DateType::class, [
                'label' => 'Date Enlevement Dem',
                'widget' => 'single_text', // Use 'single_text' widget for a simple text input
                'html5' => true, // Enable HTML5 date and time input
                'required' => false, // Set to true if the field is required
            ])

            ->add('PoidsTotMat', TextType::class, [
                'label' => 'Poids Total',
                
            ])
            ->add('Initiales', TextType::class, [
                'label' => 'Initiales',
                
                'required' => false,
            ])
         
            ->add('Commentaires1', TextType::class, [
                'label' => 'Commentaires1',
                
                'required' => false,
            ])
            ->add('Commentaires2', TextType::class, [
                'label' => 'Commentaires2',
                'required' => false,
            ])
            ->add('NumErpVente', IntegerType::class, [
                'label' => 'Numero Erp Location',
                'required' => false, // Ensure this field is not required

            ])
            ->add('Commentaires', TextType::class, [
                'label' => 'Nom Conducteur',
                'required' => false, // Ensure this field is not required

            ])
            ->add('NumErpLocation', IntegerType::class, [
                'label' => 'Numéro Vente Vente',
                'required' => false, // Ensure this field is not required

            ]);
          
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CdeMatEnt::class,
        ]);
    }
}
