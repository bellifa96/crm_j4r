<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DecimalType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CamionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->choices = $options['transporteurs'];
        $this->transporteur = $options['selected'];

        $builder
            ->add('idtransporteur',  ChoiceType::class, [
                'choices' => $this->choices,
                'label' => 'Transporteur',
                'data' => $this->transporteur, // Set $defaultTransporteur to the default value

            ])
            ->add('immatriculation', TextType::class, ['label' => 'immatriculation', 'required' => true])
            ->add('tonnagemax', TextType::class, ['label' => 'immatriculation', 'required' => true])
            ->add('typegrue', TextType::class, ['label' => 'immatriculation', 'required' => true])
            ->add('dateverifgrue', DateType::class, [
                'label' => 'Date de vérification de la grue',
                'widget' => 'single_text', // Use 'single_text' widget for a simple text input
                'html5' => true, // Enable HTML5 date and time input
                'required' => false, // Set to true if the field is required
            ])->add('actif', CheckboxType::class, [
                'required' => false, // Allow it to be unchecked
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Depot\Camions',
            'choices' => [], // Set the target entity class
            'selected' => 0 // Set the target entity class

        ]);
        $resolver->setRequired(['transporteurs']);
    }
}
