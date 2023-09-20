<?php

namespace App\Form\Affaire;

use App\Entity\Affaire\Statut;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('code')
            ->add('couleur',ColorType::class,[
                'empty_data' => 'white',
            ])
            ->add('couleurBG',ColorType::class,[
                'empty_data' => 'black',
            ])
            ->add('destination',ChoiceType::class,[
                'choices'=>[
                    'Statut Commercial Demande'=>'SCD',
                    'Statut Demande'=> 'SC',
                    'Statut Devis'=> 'SD',
                    'Statut Affaire'=> 'SA',
                ],
                'multiple' => true,
                'expanded'=>true,
                'choice_attr' => function($choice, $key, $value) {
                    return ['class' => 'checkbox-input'];
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Statut::class,
        ]);
    }
}
