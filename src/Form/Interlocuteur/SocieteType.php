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
                ]
            ])
            ->add('siren', TextType::class, [
                'attr' => [
                    'placeholder' => 'Siren',
                    'class' => 'societe-form required'
                ]
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
                    'placeholder' => 'date de cr??ation',
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
                    "Alg??rie" => "Alg??rie",
                    "Allemagne" => "Allemagne",
                    "Andorre" => "Andorre",
                    "Angola" => "Angola",
                    "Antigua-et-Barbuda" => "Antigua-et-Barbuda",
                    "Arabie Saoudite" => "Arabie Saoudite",
                    "Argentine" => "Argentine",
                    "Arm??nie" => "Arm??nie",
                    "Australie" => "Australie",
                    "Autriche" => "Autriche",
                    "Azerba??djan" => "Azerba??djan",
                    "Bahamas" => "Bahamas",
                    "Bahre??n" => "Bahre??n",
                    "Bangladesh" => "Bangladesh",
                    "Barbade" => "Barbade",
                    "Belgique" => "Belgique",
                    "Belize" => "Belize",
                    "B??nin" => "B??nin",
                    "Bhoutan" => "Bhoutan",
                    "Bi??lorussie" => "Bi??lorussie",
                    "Birmanie" => "Birmanie",
                    "Bolivie" => "Bolivie",
                    "Bosnie-Herz??govine" => "Bosnie-Herz??govine",
                    "Botswana" => "Botswana",
                    "Br??sil" => "Br??sil",
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
                    "Cor??e du Nord" => "Cor??e du Nord",
                    "Cor??e du Sud" => "Cor??e du Sud",
                    "Costa Rica" => "Costa Rica",
                    "C??te d???Ivoire" => "C??te d???Ivoire",
                    "Croatie" => "Croatie",
                    "Cuba" => "Cuba",
                    "Danemark" => "Danemark",
                    "Djibouti" => "Djibouti",
                    "Dominique" => "Dominique",
                    "??gypte" => "??gypte",
                    "??mirats arabes unis" => "??mirats arabes unis",
                    "??quateur" => "??quateur",
                    "??rythr??e" => "??rythr??e",
                    "Espagne" => "Espagne",
                    "Eswatini" => "Eswatini",
                    "Estonie" => "Estonie",
                    "??tats-Unis" => "??tats-Unis",
                    "??thiopie" => "??thiopie",
                    "Fidji" => "Fidji",
                    "Finlande" => "Finlande",
                    "France" => "France",
                    "Gabon" => "Gabon",
                    "Gambie" => "Gambie",
                    "G??orgie" => "G??orgie",
                    "Ghana" => "Ghana",
                    "Gr??ce" => "Gr??ce",
                    "Grenade" => "Grenade",
                    "Guatemala" => "Guatemala",
                    "Guin??e" => "Guin??e",
                    "Guin??e ??quatoriale" => "Guin??e ??quatoriale",
                    "Guin??e-Bissau" => "Guin??e-Bissau",
                    "Guyana" => "Guyana",
                    "Ha??ti" => "Ha??ti",
                    "Honduras" => "Honduras",
                    "Hongrie" => "Hongrie",
                    "??les Cook" => "??les Cook",
                    "??les Marshall" => "??les Marshall",
                    "Inde" => "Inde",
                    "Indon??sie" => "Indon??sie",
                    "Irak" => "Irak",
                    "Iran" => "Iran",
                    "Irlande" => "Irlande",
                    "Islande" => "Islande",
                    "Isra??l" => "Isra??l",
                    "Italie" => "Italie",
                    "Jama??que" => "Jama??que",
                    "Japon" => "Japon",
                    "Jordanie" => "Jordanie",
                    "Kazakhstan" => "Kazakhstan",
                    "Kenya" => "Kenya",
                    "Kirghizistan" => "Kirghizistan",
                    "Kiribati" => "Kiribati",
                    "Kowe??t" => "Kowe??t",
                    "Laos" => "Laos",
                    "Lesotho" => "Lesotho",
                    "Lettonie" => "Lettonie",
                    "Liban" => "Liban",
                    "Liberia" => "Liberia",
                    "Libye" => "Libye",
                    "Liechtenstein" => "Liechtenstein",
                    "Lituanie" => "Lituanie",
                    "Luxembourg" => "Luxembourg",
                    "Mac??doine" => "Mac??doine",
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
                    "Micron??sie" => "Micron??sie",
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
