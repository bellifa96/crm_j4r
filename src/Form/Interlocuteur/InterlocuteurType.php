<?php

namespace App\Form\Interlocuteur;

use App\Entity\Interlocuteur\Interlocuteur;
use App\Form\TelType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InterlocuteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        if(empty($options['data']->getId())){
            $builder
                ->add('type', ChoiceType::class, [
                    'attr'=>[
                        'class'=> 'form-control',
                        'style'=>'display:none;'
                    ],
                    'choices' => [
                        'Societé' => 'societe',
                        'Personne' => 'personne',

                    ],
                    'required' =>true,
                ]);
        }
        $builder
            ->add('roles', ChoiceType::class, array(
                    'choices' => [
                        'Client' => 'ROLE_CLIENT',
                        'Fournisseur' => 'ROLE_FOURNISSEUR',
                        'Sous Traitant' => 'ROLE_SOUS_TRAITANT',
                        'Transporteur' => 'ROLE_TRANSPORTEUR',
                        'Partenaire' => 'Partenaire'
                    ],
                    'multiple' => true,
                    'expanded' => true,
                )
            )

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
            ->add('phone',TelType::class,[
                'attr'=>[
                    'class'=>'phone'
                ],
            ])
            ->add('commentaire');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Interlocuteur::class,
            'allow_extra_fields'=>true,
        ]);
    }
}
