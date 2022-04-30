<?php

namespace App\Form\Interlocuteur;

use App\Entity\Interlocuteur\Interlocuteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InterlocuteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [

                'attr'=>[
                    'class'=> 'form-control'
                ],
                'choices' => [
                    'Societé' => 'societe',
                    'Personne' => 'personne',

                ],
                'expanded' =>true,
            ])
            ->add('societe', SocieteType::class,[
                'attr'=>[
                    'class'=> ''
                ]
            ])
            ->add('personne', PersonneType::class,[
                'attr'=>[
                    'class'=> ''
                ]
            ])
            ->add('commentaire');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Interlocuteur::class,
        ]);
    }
}
