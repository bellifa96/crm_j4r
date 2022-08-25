<?php

namespace App\Form\Affaire;

use App\Entity\Affaire\Ouvrage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OuvrageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('denomination')
            ->add('typeDOuvrage')
            ->add('prixUnitaireDebourse')
            ->add('quantiteDOuvrage')
            ->add('debourseHTCalcule')
            ->add('marge')
            ->add('prixDeVenteHT')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ouvrage::class,
        ]);
    }
}
