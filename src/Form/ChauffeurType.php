<?php

namespace App\Form;

use App\Entity\Depot\Transporteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ChauffeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->choices = $options['transporteurs'];
        $this->transporteur = $options['selected'];

        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('portable', TextType::class)
            ->add('email', EmailType::class)
            ->add('idtransporteur',  ChoiceType::class, [
                'choices' => $this->choices,
                'label'=>'Transporteur',
                'data' => $this->transporteur, // Set $defaultTransporteur to the default value
            ])
            ->add('actif', CheckboxType::class, [
                'required' => false, // Allow it to be unchecked
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Depot\Chauffeurs',
            'choices'=>[], // Set the target entity class
            'selected'=> 0 // Set the target entity class

        ]);
        $resolver->setRequired(['transporteurs']);
    }
}
