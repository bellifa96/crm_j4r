<?php

namespace App\Form\Interlocuteur;

use App\Entity\Interlocuteur\Interlocuteur;
use App\Repository\Interlocuteur\InterlocuteurRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\ParentEntityAutocompleteType;

#[AsEntityAutocompleteField]
class InterlocuteurAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Interlocuteur::class,
            'placeholder' => 'Veuillez choisir un fournisseur',
            //'choice_label' => 'name',

            'query_builder' => function (InterlocuteurRepository $interlocuteurRepository) {
                return $interlocuteurRepository->createQueryBuilder('i')
                    ->join('i.societe', 's')
                    ->where('i.roles LIKE :role')
                    ->setParameter('role', '%ROLE_FOURNISSEUR%');
            },
            'choice_label' => function (Interlocuteur $interlocuteur) {
                return $interlocuteur->getSociete()->getRaisonSociale() . " - " . $interlocuteur->getSociete()->getAdresse1() . ", " . $interlocuteur->getSociete()->getCodePostal() . " " . $interlocuteur->getSociete()->getVille();
            },

            'searchable_fields' => ['societe.adresse1', 'societe.codePostal', 'societe.ville', 'societe.raisonSociale']


            //'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }
}
