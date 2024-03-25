<?php

namespace App\Form;

use App\Entity\Depot\Agence;
use App\Entity\Depot\Chantiers;
use App\Entity\Interlocuteur\Societe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\Depot\AgenceRepository;
use App\Repository\Interlocuteur\SocieteRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;  
class ChantierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numchantier')
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'A démarrer' => '0',
                    'En attente OS' => '1',
                    'En cours' => '2',
                    'Terminé' => '3',
                    'Annulé' => '4',
                    'A relancer' => '5',
                    'Ne pas facturer' => '6',
                    ' Non réalisé' => '7',

                    // Add more options as needed
                ],
                'placeholder' => 'Selectionnez état chantier', // Optional: Adds a placeholder
                // Add more options as needed
            ])
            ->add('ville')
            ->add('cp')
            ->add('nomchantier')
            ->add('voie')
            ->add('adresse')
            ->add('id_client', EntityType::class, [
                'class' => Societe::class,
                'query_builder' => function (SocieteRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('u');
                },
                'choice_label' => 'raisonSociale',
                'label' => 'Client',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chantiers::class,
        ]);
    }
}
