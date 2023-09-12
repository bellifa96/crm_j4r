<?php

namespace App\Form\Transport;

use App\Entity\Transport\Articles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Depot')
            ->add('Article')
            ->add('Designation')
            ->add('PrixVente')
            ->add('PrixLoc')
            ->add('Poids')
            ->add('Vente')
            ->add('Location')
            ->add('Consommable')
            ->add('Conditionnement')
            ->add('QteTotale')
            ->add('QteDispo')
            ->add('QteSortie')
            ->add('QteReserve')
            ->add('QteTransit')
            ->add('QteTemp')
            ->add('DateAchat')
            ->add('DateAchatInv')
            ->add('Commentaires')
            ->add('DateSaisie')
            ->add('DateSaisieInv')
            ->add('Emplacement')
            ->add('Image')
            ->add('AControler')
            ->add('Fournisseur')
            ->add('RefFourn')
            ->add('OldPrixV')
            ->add('OldPrixL')
            ->add('OldPoids')
            ->add('DateChange')
            ->add('DateChangeInv')
            ->add('QteHs')
            ->add('QteAchat')
            ->add('Agence')
            ->add('QteLocTheorique')
            ->add('QteLocReelle')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
