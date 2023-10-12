<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TypeAssignedType extends AbstractType
{

    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $user = $this->tokenStorage->getToken()->getUser();

        // Now, you can access the user or its properties, such as username
        $userRoles = $user->getRoles();
        $search = "ROLE_DEV";
        $demandeInformation = $options['demande_information'];

        if (in_array($search, $userRoles)) {


            if ($options['data']->getStatus() == "A traiter") {

                $choices = [
                    'En cours' => 'En cours',
                ];
            } else if ($options['data']->getStatus() == "En cours") {
                $choices = [
                    'En cours' => 'En cours',
                    'En confirmation' => 'En confirmation'
                ];
            } else {
                $choices = [
                    'En confirmation' => 'En confirmation'
                ];
            }
            if ($demandeInformation == 0) {
                $builder->add('status', ChoiceType::class, [
                    'choices' => $choices,
                    'placeholder' => 'Choisissez une option',
                    'required' => true,
                    'data' => $options['data']->getStatus()
                ]);
            } else if ($demandeInformation == 1) {
                $builder->add('message', TextareaType::class, [
                    'label' => 'Message',
                    'required' => false,
                    'attr' => ['class' => 'custom-textarea-class'],
                    'mapped' => false, 

                ]);
            }
        } else {
            if ($demandeInformation == 1) {
                $builder->add('message', TextareaType::class, [
                    'label' => 'Message',
                    'required' => false,
                    'attr' => ['class' => 'custom-textarea-class'],
                    'mapped' => false, 
                ]);
            }
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
            'demande_information' => 1, // Set a default value here if needed
            'affichage' => 0, // Set a default value here if needed

        ]);
    }
}
