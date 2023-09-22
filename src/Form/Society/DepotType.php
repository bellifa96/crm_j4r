<?php

namespace App\Form\Society;

use App\Entity\Society\Depot;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codeDepot')
            ->add('nomDepot')
            ->add('adresseDepot')
            ->add('adresseDepot2')
            ->add('cpDepot')
            ->add('villeDepot')
            ->add('contactNom')
            ->add('contactPrenom')
            ->add('contactTel')
            ->add('contactPortable')
            ->add('infoOuverture')
            ->add('contactEmail')
            ->add('commentaires')
            ->add('idAgence')
            ->add('codeChantier')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Depot::class,
        ]);
    }
}
