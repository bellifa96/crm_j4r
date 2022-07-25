<?php

namespace App\Form\Society;

use App\Entity\Society\Rib;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RibType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('iban')
            ->add('bic')
            ->add('typeDeCompte',ChoiceType::class,[
                'choices'=>[
                    'Principal'=>'Principal',
                    'Secondaire'=>'Secondaire'
                ]
            ])
            ->add('nomBanque')
            ->add('commentaire',TextType::class)
            ->add('etatDuCompte',ChoiceType::class,[
                'choices'=>[
                    'Actif'=>'Principal',
                    'Inactif'=>'Inactif'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rib::class,
        ]);
    }
}
