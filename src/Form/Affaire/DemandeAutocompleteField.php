<?php

namespace App\Form\Affaire;

use App\Entity\Demande;
use App\Repository\DemandeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\ParentEntityAutocompleteType;

#[AsEntityAutocompleteField]
class DemandeAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Demande::class,
            'placeholder' => 'nom chantier,adresse,cp,ville,client',
            'choice_label' => function(Demande $demande){
                  return (!empty($demande->getClient()->getSociete()) ? $demande->getClient()->getSociete()->getRaisonSociale() : $demande->getClient()->getPersonne()->getNom()." - ".$demande->getClient()->getPersonne()->getPrenom())
                     ." - ".$demande->getNomChantier()." - ".$demande->getAdresse1()." - ".$demande->getCodePostal()." - ".$demande->getVille();
            },

            'searchable_fields' => ['nomChantier','adresse1','codePostal','ville','client',]
            //'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }
}
