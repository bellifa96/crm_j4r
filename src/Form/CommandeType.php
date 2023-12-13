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
                'label' => 'NumDevis',
                'disabled' => true,
            ])
            ->add('IdClient', IntegerType::class, [
                'label' => 'IdClient',
                'disabled' => true,
            ])
            ->add('NomClient', TextType::class, [
                'label' => 'NomClient',
                'disabled' => true,
            ])
            ->add('CodeChantier', IntegerType::class, [
                'label' => 'CodeChantier',
                'disabled' => true,
                'required' => false,
            ])
            ->add('NumAffaire', TextType::class, [
                'label' => 'NumAffaire',
                'disabled' => true,
                'required' => false,
            ])
            ->add('AdresseChantier', TextareaType::class, [
                'label' => 'AdresseChantier',
                'disabled' => true,
                'required' => false,
            ])
            ->add('CpChantier', TextType::class, [
                'label' => 'CpChantier',
                'disabled' => true,
                'required' => false,
            ])
            ->add('VilleChantier', TextType::class, [
                'label' => 'VilleChantier',
                'disabled' => true,
                'required' => false,
            ])
         
            ->add('DateCde', DateTimeType::class, [
                'label' => 'DateCde',
                'disabled' => true,
            ])
         
            ->add('PoidsTotMat', IntegerType::class, [
                'label' => 'PoidsTotMat',
                'disabled' => true,
            ])
            ->add('Initiales', TextType::class, [
                'label' => 'Initiales',
                'disabled' => true,
                'required' => false,
            ])
            ->add('IdAgence', IntegerType::class, [
                'label' => 'IdAgence',
                'disabled' => true,
            ])
            ->add('Iddepot', IntegerType::class, [
                'label' => 'Iddepot',
                'disabled' => true,
            ]);
           
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CdeMatEnt::class,
        ]);
    }
}
