<?php

namespace App\Form\Society;

use App\Entity\Society\Agence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Agence')
            ->add('NomAgence')
            ->add('AdresseAgence')
            ->add('AdresseAgence2')
            ->add('CpAgence')
            ->add('VilleAgence')
            ->add('ContactNom')
            ->add('ContactPrenom')
            ->add('ContactTel')
            ->add('ContactPortable')
            ->add('InfoOuverture')
            ->add('ContactEmail')
            ->add('Commentaires')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agence::class,
        ]);
    }
}
