<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TypeAssignedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        if ($options['data']->getStatus() == "A traiter") {

            $choices = [
                'En cours' => 'En cours',
            ];

       

        }else if($options['data']->getStatus() == "En cours"){
            $choices = [
                'En cours' => 'En cours',
                'En confirmation' => 'En confirmation'
            ];
        }
        $builder->add('status', ChoiceType::class, [
            'choices' => $choices,
            'placeholder' => 'Choisissez une option',
            'required' => true,
            'data' => $options['data']->getStatus() // Set the default value here
        ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
