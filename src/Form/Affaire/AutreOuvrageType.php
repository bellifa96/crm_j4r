<?php

namespace App\Form\Affaire;

use App\Entity\Affaire\AutreOuvrage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AutreOuvrageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation')
            ->add('montage')
            ->add('demontage')
            ->add('transportAller')
            ->add('transportRetour')
            ->add('manutentionAppro')
            ->add('manutentionRepli')
            ->add('vente')
            ->add('location')
            ->add('marge')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AutreOuvrage::class,
        ]);
    }
}
