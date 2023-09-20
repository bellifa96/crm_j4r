<?php

namespace App\Form\Contact;

use App\Entity\Contact\Contact;
use App\Repository\Contact\ContactRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\ParentEntityAutocompleteType;

#[AsEntityAutocompleteField]
class ContactAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Contact::class,
            'placeholder' => 'nom,prénom,email',
            'choice_label' => function (Contact $contact) {
                return $contact->getNom() . " " . $contact->getPrenom();
            },

            'searchable_fields' => ['nom', 'prenom', 'email']

            //'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }
}
