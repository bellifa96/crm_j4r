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
            ->add('CodeDepot')
            ->add('NomDepot')
            ->add('AdresseDepot')
            ->add('AdresseDepot2')
            ->add('CpDepot')
            ->add('VilleDepot')
            ->add('ContactNom')
            ->add('ContactPrenom')
            ->add('ContactTel')
            ->add('ContactPortable')
            ->add('InfoOuverture')
            ->add('ContactEmail')
            ->add('commentaires')
            ->add('IdAgence')
            ->add('CodeChantier')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Depot::class,
        ]);
    }
}
