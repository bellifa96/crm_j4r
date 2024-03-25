<?php

namespace App\Form\Interlocuteur;

use App\Entity\Interlocuteur\Activite;
use App\Entity\Interlocuteur\Societe;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocieteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('raisonSociale', TextType::class, [
                'attr' => [
                    'placeholder' => 'Raison sociale',
                    'class' => 'societe-form required'
                ]
            ])
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom commercial',
                    'class' => 'societe-form required'
                ]
            ])
            ->add('siret', TextType::class, [
                'attr' => [
                    'placeholder' => 'Siret required',
                    'class' => 'societe-form required'
                ],
                'required' => false
            ])
            ->add('siren', TextType::class, [
                'attr' => [
                    'placeholder' => 'Siren',
                    'class' => 'societe-form '
                ],
                'required' => false,
            ])
            ->add('activitePrincipale', EntityType::class, [
                'class' => Activite::class,

                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.titre', 'ASC');
                },
                'choice_label' => 'titre',
                'required' => false,
            ])
            ->add('activitesSecondaires', EntityType::class, [
                'class' => Activite::class,
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.titre', 'ASC');
                },
                'choice_label' => 'titre',
                'required' => false,
            ])
            ->add('formeJuridique', TextType::class, [
                'attr' => [
                    'placeholder' => 'Forme juridique',
                    'class' => 'societe-form required'
                ]
            ])
            ->add('dirigeant', TextType::class, [
                'attr' => [
                    'placeholder' => 'Dirigeant',
                    'class' => 'societe-form required'
                ]
            ])
            ->add('dateDeCreation', TextType::class, [
                'attr' => [
                    'placeholder' => 'date de création',
                    'class' => 'societe-form'
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'email',
                    'class' => 'societe-form'
                ]
            ])
            ->add('adresse1', TextType::class, [
                'attr' => [
                    'placeholder' => 'Adresse',
                    'class' => 'societe-form required'
                ]
            ])
            ->add('adresse2', TextType::class, [
                'attr' => [
                    'placeholder' => 'Adresse 2',
                    'class' => 'societe-form'
                ],
                'required' => false,
            ])
            ->add('ville', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ville',
                    'class' => 'societe-form required'
                ]
            ])
            ->add('codePostal', NumberType::class, [
                'attr' => [
                    'placeholder' => 'Code postal',
                    'class' => 'societe-form required'
                ]
            ])
            ->add('pays', ChoiceType::class, [
                'choices' => [
                    "Afrique du Sud" => "Afrique du Sud",
                    "Afghanistan" => "Afghanistan",
                    "Albanie" => "Albanie",
                    "Algérie" => "Algérie",
                    "Allemagne" => "Allemagne",
                    "Andorre" => "Andorre",
                    "Angola" => "Angola",
                    "Antigua-et-Barbuda" => "Antigua-et-Barbuda",
                    "Arabie Saoudite" => "Arabie Saoudite",
                    "Argentine" => "Argentine",
                    "Arménie" => "Arménie",
                    "Australie" => "Australie",
                    "Autriche" => "Autriche",
                    "Azerbaïdjan" => "Azerbaïdjan",
                    "Bahamas" => "Bahamas",
                    "Bahreïn" => "Bahreïn",
                    "Bangladesh" => "Bangladesh",
                    "Barbade" => "Barbade",
                    "Belgique" => "Belgique",
                    "Belize" => "Belize",
                    "Bénin" => "Bénin",
                    "Bhoutan" => "Bhoutan",
                    "Biélorussie" => "Biélorussie",
                    "Birmanie" => "Birmanie",
                    "Bolivie" => "Bolivie",
                    "Bosnie-Herzégovine" => "Bosnie-Herzégovine",
                    "Botswana" => "Botswana",
                    "Brésil" => "Brésil",
                    "Brunei" => "Brunei",
                    "Bulgarie" => "Bulgarie",
                    "Burkina Faso" => "Burkina Faso",
                    "Burundi" => "Burundi",
                    "Cambodge" => "Cambodge",
                    "Cameroun" => "Cameroun",
                    "Canada" => "Canada",
                    "Cap-Vert" => "Cap-Vert",
                    "Chili" => "Chili",
                    "Chine" => "Chine",
                    "Chypre" => "Chypre",
                    "Colombie" => "Colombie",
                    "Comores" => "Comores",
                    "Corée du Nord" => "Corée du Nord",
                    "Corée du Sud" => "Corée du Sud",
                    "Costa Rica" => "Costa Rica",
                    "Côte d’Ivoire" => "Côte d’Ivoire",
                    "Croatie" => "Croatie",
                    "Cuba" => "Cuba",
                    "Danemark" => "Danemark",
                    "Djibouti" => "Djibouti",
                    "Dominique" => "Dominique",
                    "Égypte" => "Égypte",
                    "Émirats arabes unis" => "Émirats arabes unis",
                    "Équateur" => "Équateur",
                    "Érythrée" => "Érythrée",
                    "Espagne" => "Espagne",
                    "Eswatini" => "Eswatini",
                    "Estonie" => "Estonie",
                    "États-Unis" => "États-Unis",
                    "Éthiopie" => "Éthiopie",
                    "Fidji" => "Fidji",
                    "Finlande" => "Finlande",
                    "France" => "France",
                    "Gabon" => "Gabon",
                    "Gambie" => "Gambie",
                    "Géorgie" => "Géorgie",
                    "Ghana" => "Ghana",
                    "Grèce" => "Grèce",
                    "Grenade" => "Grenade",
                    "Guatemala" => "Guatemala",
                    "Guinée" => "Guinée",
                    "Guinée équatoriale" => "Guinée équatoriale",
                    "Guinée-Bissau" => "Guinée-Bissau",
                    "Guyana" => "Guyana",
                    "Haïti" => "Haïti",
                    "Honduras" => "Honduras",
                    "Hongrie" => "Hongrie",
                    "Îles Cook" => "Îles Cook",
                    "Îles Marshall" => "Îles Marshall",
                    "Inde" => "Inde",
                    "Indonésie" => "Indonésie",
                    "Irak" => "Irak",
                    "Iran" => "Iran",
                    "Irlande" => "Irlande",
                    "Islande" => "Islande",
                    "Israël" => "Israël",
                    "Italie" => "Italie",
                    "Jamaïque" => "Jamaïque",
                    "Japon" => "Japon",
                    "Jordanie" => "Jordanie",
                    "Kazakhstan" => "Kazakhstan",
                    "Kenya" => "Kenya",
                    "Kirghizistan" => "Kirghizistan",
                    "Kiribati" => "Kiribati",
                    "Koweït" => "Koweït",
                    "Laos" => "Laos",
                    "Lesotho" => "Lesotho",
                    "Lettonie" => "Lettonie",
                    "Liban" => "Liban",
                    "Liberia" => "Liberia",
                    "Libye" => "Libye",
                    "Liechtenstein" => "Liechtenstein",
                    "Lituanie" => "Lituanie",
                    "Luxembourg" => "Luxembourg",
                    "Macédoine" => "Macédoine",
                    "Madagascar" => "Madagascar",
                    "Malaisie" => "Malaisie",
                    "Malawi" => "Malawi",
                    "Maldives" => "Maldives",
                    "Mali" => "Mali",
                    "Malte" => "Malte",
                    "Maroc" => "Maroc",
                    "Maurice" => "Maurice",
                    "Mauritanie" => "Mauritanie",
                    "Mexique" => "Mexique",
                    "Micronésie" => "Micronésie",
                    "Moldavie" => "Moldavie",
                    "Monaco" => "Monaco",
                    "Mongolie" => "Mongolie",
                ],
                'preferred_choices' => ['France', 'Belgique'],
                'attr' => [
                    'placeholder' => 'Pays',
                    'class' => 'societe-form  required'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Societe::class,
        ]);
    }
}
