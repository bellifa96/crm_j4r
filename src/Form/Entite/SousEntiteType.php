<?php

namespace App\Form\Entite;

use App\Entity\Entite\SousEntite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SousEntiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('raisonSociale')
            ->add('siret')
            ->add('dirigeant')
            ->add('dateDeCreation')
            ->add('formeJuridique')
            ->add('activitePrincipale')
            ->add('type')
            ->add('adresse1')
            ->add('adresse2')
            ->add('ville')
            ->add('codePostal')
            ->add('pays')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SousEntite::class,
        ]);
    }
}
