<?php

namespace App\Form;

use App\Entity\Demande;
use App\Entity\Interlocuteur\Interlocuteur;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Sodium\add;

class DemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('commentaire')
            ->add('nomChantier')
            ->add('reference', TextType::class, [
                'required' => false,
            ])
            ->add('date')
            ->add('dateDuReleve')
            ->add('dateDeRemise')
            ->add('dateDebutPrevisionnel')

            ->add('adresse1')
            ->add('adresse2')
            ->add('ville')
            ->add('codePostal')
            ->add('faireUnReleve')
            ->add('userReleve', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.firstname', 'ASC');
                },
                'choice_label' => 'firstname',
            ])

            ->add('faireUnDevis')
            ->add('userDevis', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.firstname', 'ASC');
                },
                'choice_label' => 'firstname',
            ])


            ->add('typeEchafaudage', ChoiceType::class, [
                'choices' => [
                    'Façade' => 'Façade',
                    'Pavillon individuelle' => 'Façade',
                    'Lotissement maison' => 'Façade',
                    "Intermédiaire à l'avancement" => 'Façade',
                    'Bâtiment' => 'Façade',

                    'Parapluie' => 'Parapluie',

                    'Protection couvreur' => 'Protection couvreur',

                    'Echafaudage roulant' => 'Echafaudage roulant',

                    "Sapine d'accès" => "Sapine d'accès",
                    "Sapine d'accès escalier" => "Sapine d'accès",

                    'Plateforme' => 'Plateforme',

                    'Particulier' => 'Particulier',

                    'Recette à matériaux' => 'Recette à matériaux',

                    'Edifice spécifique' => 'Façade Spécifique',
                    'Mur écran' => 'Façade Spécifique',
                    'Autres' => 'Façade Spécifique'

                ],
                'required'=>false,
                'expanded' => true,
                'multiple' => false
            ])
            ->add('client', EntityType::class, [
                    'class' => Interlocuteur::class,

                    'choice_label' => function ($interlocuteur) {
                        return !empty($interlocuteur->getSociete()) ? $interlocuteur->getSociete()->getRaisonSociale() : $interlocuteur->getPersonne()->getNom();
                    },
                    'placeholder' => '--Veuillez choisir un client--'
                ]
            )
            ->add('intermediaire', EntityType::class, [
                    'class' => Interlocuteur::class,
                    'required' => false,
                    'choice_label' => function ($interlocuteur) {
                        return !empty($interlocuteur->getSociete()) ? $interlocuteur->getSociete()->getRaisonSociale() : $interlocuteur->getPersonne()->getNom();
                    }
                ]
            )
            ->add('maitreDOuvrage', EntityType::class, [
                'class' => Interlocuteur::class,
                'required' => false,
                'choice_label' => function ($interlocuteur) {
                    return !empty($interlocuteur->getSociete()) ? $interlocuteur->getSociete()->getRaisonSociale() : $interlocuteur->getPersonne()->getNom();
                }
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


        if (!empty($options['data']->getId()) ) {
            $builder->add('createur', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.firstname', 'ASC');
                },
                'choice_label' => 'firstname',
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
            'allow_extra_fields' => true
        ]);
    }
}
