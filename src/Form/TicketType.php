<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Length;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => "Titre du ticket"
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => "description",
                'constraints' => [
                    new  Length([
                        'min' => 0,
                        'minMessage' => "La réponse ne peut pas être vide.",
                        'max' => 500,
                        'maxMessage' => "La réponse doit faire moins de 500 caractères.",
                    ])]
            ])
      
            ->add('level', ChoiceType::class, [
                'label' => 'Importance',
                'choices' => [
                    'Urgent' => 'Urgent',
                    'Secondaire' => 'Secondaire',
                ],
                'placeholder' => 'Choisissez une option'
            ]);
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
