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
            'placeholder' => 'nom chantier,adresse,cp,ville',
            'choice_label' => 'nomChantier',

            'searchable_fields' => ['nomChantier','adresse1','codePostal','ville']
            //'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }
}
