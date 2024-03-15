<?php

namespace App\Form;

use App\Entity\Depot\Chantiers;
use App\Entity\Transport\CdeMatDet;
use App\Entity\Transport\CdeMatEnt;
use App\Repository\Depot\ChantiersRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;  // Make sure to import EntityType
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
         
           
          
         
        
            
            ->add('DateEnlevDem', DateType::class, [
                'label' => 'Date Enlevement Dem',
                'widget' => 'single_text', // Use 'single_text' widget for a simple text input
                'html5' => true, // Enable HTML5 date and time input
                'required' => false, // Set to true if the field is required
            ])

            ->add('PoidsTotMat', TextType::class, [
                'label' => 'Poids Total',

            ])
            ->add('adresse_chantier', TextType::class, [
                'label' => 'Adresse Chantier',

            ])
          
            ->add('NumAffaire', TextType::class, [
                'label' => 'Numéro Affaire',

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
           
            ->add('NumErpLocation', IntegerType::class, [
                'label' => 'Numéro Vente Vente',
                'required' => false, // Ensure this field is not required

            ])
            ->add('chantier', EntityType::class, [
                'class' => Chantiers::class,
                'query_builder' => function (ChantiersRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('u');
                },
                'choice_label' => 'nomchantier',
                'label' => 'nomchantier',
            ])
         
            ->add('HeureEnlevDem', TimeType::class, [
                'label' => 'Numéro Vente Vente',
                'required' => false, // Ensure this field is not required
                'widget' => 'single_text', // This ensures that it's rendered as a single input rather than separate dropdowns
                'attr' => [
                    'class' => 'form-control form-control-sm-2 societe-input',
                    // Add any other attributes you need for styling or functionality
                ],

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CdeMatEnt::class,
        ]);
    }
}
