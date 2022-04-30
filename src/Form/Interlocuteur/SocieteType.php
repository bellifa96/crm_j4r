<?php

namespace App\Form\Interlocuteur;

use App\Entity\Interlocuteur\Societe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocieteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('raisonSociale',TextType::class,[
                'attr'=>[
                    'placeholder'=> 'Raison sociale',
                    'class'=>'societe-form required'
                ]
            ])
            ->add('nom',TextType::class,[
                'attr'=>[
                    'placeholder'=> 'Nom commercial',
                    'class'=>'societe-form required'
                ]
            ])
            ->add('siret',TextType::class,[
                'attr'=>[
                    'placeholder'=> 'Siret required',
                    'class'=>'societe-form'
                ]
            ])
            ->add('activitePrincipale',TextType::class,[
                'attr'=>[
                    'placeholder'=> 'Activité principale',
                    'class'=>'societe-form required'
                ]
            ])
            ->add('formeJuridique',TextType::class,[
                'attr'=>[
                    'placeholder'=> 'Forme juridique',
                    'class'=>'societe-form required'
                ]
            ])
            ->add('dirigeant',TextType::class,[
                'attr'=>[
                    'placeholder'=> 'Dirigeant',
                    'class'=>'societe-form required'
                ]
            ])
            ->add('dateDeCreation',TextType::class,[
                'attr'=>[
                    'placeholder'=> 'date de création',
                    'class'=>'societe-form'
                ]
            ])
            ->add('email',EmailType::class,[
                'attr'=>[
                    'placeholder'=> 'email',
                    'class'=>'societe-form'
                ]
            ])
            ->add('adresse1',TextType::class,[
                'attr'=>[
                    'placeholder'=> 'Adresse required',
                    'class'=>'societe-form'
                ]
            ])
            ->add('adresse2',TextType::class,[
                'attr'=>[
                    'placeholder'=> 'Adresse 2',
                    'class'=>'societe-form'
                ],
                'required'=>false,
            ])
            ->add('ville',TextType::class,[
                'attr'=>[
                    'placeholder'=> 'Ville required',
                    'class'=>'societe-form'
                ]
            ])
            ->add('codePostal',NumberType::class,[
                'attr'=>[
                    'placeholder'=> 'Code postal required',
                    'class'=>'societe-form'
                ]
            ])
            ->add('pays',TextType::class,[
                'attr'=>[
                    'placeholder'=> 'Pays',
                    'class'=>'societe-form  required'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Societe::class,
        ]);
    }
}
