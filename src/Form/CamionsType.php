<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
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
            'label'=>'Transporteur',
            'data' => $this->transporteur, // Set $defaultTransporteur to the default value

        ])
        ->add('immatriculation', TextType::class)
        ->add('tonnagemax', TextType::class)
        ->add('typegrue', TextType::class)
        ->add('dateverifgrue', DateType::class)
        ->add('actif', CheckboxType::class, [
            'required' => false, // Allow it to be unchecked
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Depot\Camions',
            'choices'=>[], // Set the target entity class
            'selected'=> 0 // Set the target entity class

        ]);
        $resolver->setRequired(['transporteurs']);
    }
}
