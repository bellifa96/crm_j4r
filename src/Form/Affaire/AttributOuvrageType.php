<?php

namespace App\Form\Affaire;

use App\Entity\Affaire\AttributOuvrage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttributOuvrageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('poidsKG')
            ->add('tps')
            ->add('type')
            ->add('attributOuvrage')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AttributOuvrage::class,
        ]);
    }
}
