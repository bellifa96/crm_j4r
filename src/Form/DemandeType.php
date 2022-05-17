<?php

namespace App\Form;

use App\Entity\Demande;
use App\Entity\Interlocuteur\Interlocuteur;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('commentaire')
            ->add('nomChantier')
            ->add('date')
            ->add('adresse1')
            ->add('adresse2')
            ->add('ville')
            ->add('codePostal')
            ->add('pays')
            ->add('client', EntityType::class, [
                    'class' => Interlocuteur::class,

                    'choice_label' => function ($interlocuteur) {
                        return !empty($interlocuteur->getSociete()) ? $interlocuteur->getSociete()->getRaisonSociale() : $interlocuteur->getPersonne()->getNom();
                    }
                ]
            )
            ->add('intermediaire', EntityType::class, [
                    'class' => Interlocuteur::class,
                    'choice_label' => function ($interlocuteur) {
                        return !empty($interlocuteur->getSociete()) ? $interlocuteur->getSociete()->getRaisonSociale() : $interlocuteur->getPersonne()->getNom();
                    }
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}
