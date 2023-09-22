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
            ->add('agence')
            ->add('nomAgence')
            ->add('adresseAgence')
            ->add('adresseAgence2')
            ->add('cpAgence')
            ->add('villeAgence')
            ->add('contactNom')
            ->add('contactPrenom')
            ->add('contactTel')
            ->add('contactPortable')
            ->add('infoOuverture')
            ->add('contactEmail')
            ->add('commentaires');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agence::class,
        ]);
    }
}
