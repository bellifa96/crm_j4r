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
            'placeholder' => 'Choose a Interlocuteur',
            //'choice_label' => 'name',

            'query_builder' => function(InterlocuteurRepository $interlocuteurRepository) {
                return $interlocuteurRepository->createQueryBuilder('interlocuteur');
            },
            //'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }
}
