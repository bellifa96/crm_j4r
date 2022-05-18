<?php

namespace App\Form;

use App\Entity\Demande;
use App\Entity\Interlocuteur\Interlocuteur;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('date')
            ->add('adresse1')
            ->add('adresse2')
            ->add('ville')
            ->add('codePostal')
            ->add('pays')
            ->add('typeDePrestation',ChoiceType::class, [
                'choices' => [
                    'Estimation' => 'Estimation',
                    'Pré-étude' => 'Pre-etude',
                    'Exécution' => 'Execution'
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('documentsSouhaites', ChoiceType::class, [
                'choices' => [
                    'PLAN' => 'Plan',
                    'NDC' => 'Ndc'
                ],
                'expanded' => true,
                'multiple' => false
            ])

            ->add('fondsDePlan', ChoiceType::class, [
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ],
                'expanded' => true,
                'multiple' => false
            ])

            ->add('travauxPrevus', ChoiceType::class, [
                'choices' => [
                    '<strong> Peinture / Ravalement' => 'Peinture/Ravalement',
                    'Bardage / Isolation' => 'Bardage/Isolation',
                    'Maçonnerie / Pierre' => 'Maçonnerie/Pierre'
                ],
                'expanded' => true,
                'multiple' => true
            ])

            ->add('classeDEchaffaudage', ChoiceType::class, [
                'choices' => [
                    'Classe 1 <em>(75daN/m<sup>2</sup> sur 1,5 niv.)</em>' => 'Classe 1',
                    'Classe 2 <em>(150daN/m<sup>2</sup> sur 1,5 niv.)</em>' => 'Classe 2',
                    'Classe 3 <em>(200daN/m<sup>2</sup> sur 1,5 niv.)</em>' => 'Classe 3',
                    'Classe 4 <em>(300daN/m<sup>2</sup> sur 1,5 niv.)</em>' => 'Classe 4',
                    'Classe 5 <em>(450daN/m<sup>2</sup> sur 1,5 niv.)</em>' => 'Classe 5',
                    'Classe 6 <em>(600daN/m<sup>2</sup> sur 1,5 niv.)</em>' => 'Classe 6'
                ],
                'expanded' => true,
                'multiple' => false
            ])

            ->add('typeDeMateriel', ChoiceType::class, [
                'choices' => [
                    'Universel' => 'Universel',
                    'Eurofacadacier' => "Eurofacadacier"
                ],
                'expanded' => true,
                'multiple' => false
            ])

            ->add('dimensionsGlobales', /*[
                'Longueur totale (en m)' =>
            ]*/)

            ->add('ammarages', ChoiceType::class, [
                'choices' => [
                    'Ancrages simples' => 'Ancrages simples',
                    'Cravatages' => 'Cravatages',
                    'Vérinage' => 'Verinage'
                ],
                'expanded' => true,
                'multiple' => false
            ])

            ->add('client', EntityType::class, [
                    'class' => Interlocuteur::class,

                    'choice_label' => function ($interlocuteur) {
                        return !empty($interlocuteur->getSociete()) ? $interlocuteur->getSociete()->getRaisonSociale() : $interlocuteur->getPersonne()->getNom();
                    }
                ]
            )
            ->add('intermediaire', EntityType::class, [
                    'class' => Interlocuteur::class,
                    'choice_label' => function ($interlocuteur) {
                        return !empty($interlocuteur->getSociete()) ? $interlocuteur->getSociete()->getRaisonSociale() : $interlocuteur->getPersonne()->getNom();
                    }
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}
