<?php

namespace App\Form;

use App\Entity\Entite\Entite;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Workflow\Event\EnteredEvent;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('email', EmailType::class)
            ->add('emailPerso', EmailType::class,[
                'required'=>false,
            ])
            ->add('telephone')
            ->add('linkedin')

            ->add('telephoneFixe')
            ->add('telephoneMobile')
            ->add('matricule')
            ->add('pseudo')
            ->add('firstname')
            ->add('lastname')
            ->add('signature', FileType::class, [
                "data_class" => null,
                "required" => false,
            ])
            ->add('signatureM', FileType::class, [
                "data_class" => null,
                "required" => false,
            ])
            ->add('photo', FileType::class, [
                "data_class" => null,
                "required" => false,
            ])

            ->add('entite', EntityType::class, [
                'class' => Entite::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.nom', 'ASC');
                },
                'choice_label' => function (Entite $enite) {
                    return $enite->getNom()." - ".$enite->getAdresse1().", ".$enite->getCodePostal()." ".$enite->getVille();
                },
                'required' => false,
                'placeholder' => 'Choisir une adresse pro',

            ])

            ->add('service', EntityType::class, [
                'class' => User\Service::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.titre', 'ASC');
                },
                'choice_label' => 'titre',
                'required' => false,
                'placeholder' => 'Choisir un service',

            ])
            ->add('poste', EntityType::class, [
                'class' => User\Poste::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.titre', 'ASC');
                },
                'placeholder' => 'Choisir un poste',
                'choice_label' => 'titre',
                'required' => false,
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
            ->add('codePostal', TextType::class, [
                'attr' => [
                    'placeholder' => 'Code postal',
                    'class' => 'societe-form required',
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
            ])
            ->add('roles', ChoiceType::class, array(
                    'choices' => [
                        'Super admin' => 'ROLE_SUPER_ADMIN',
                        'Admin' => 'ROLE_ADMIN',
                        'Manageur'=>'ROLE_MANAGER',
                        'Commercial'=>'ROLE_COMMERCIAL',
                        'J4R' => 'ROLE_USER',
<<<<<<< HEAD
                        'DEV' => 'ROLE_DEV',

=======
>>>>>>> 14fd9fbb87cce363ad8c2bc7e5bea3ab716a8b76
                    ],
                    'multiple' => true,
                    'expanded' => true,
                )
            );

        if (empty($options['data']->getId())) {
            $builder->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'required' => true,
                'first_options' => ['label' => ""],
                'second_options' => ['label' => ""],
            ]);

        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
