<?php

namespace App\Form\Affaire;

use App\Entity\Affaire\Devis;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'En cours' => 'En cours',
                    'Validé' => 'Validé',
                    'Refusé' => 'Refusé',
                ]
            ])
            ->add('description')
            ->add('referent', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('u')
                        ->orderBy('u.firstname', 'ASC');
                },
                'choice_label' => function ($user) {
                    return $user->getFirstname() . " " . $user->getLastname();
                }
            ])
            ->add('lots', CollectionType::class, [
                'entry_type' => LotType::class,
                'entry_options' => [
                    'attr' => ['class' => ''],
                ],
            ])
            ->add('ouvrages', CollectionType::class, [
                'entry_type' => OuvrageType::class,
                'entry_options' => [
                    'attr' => ['class' => ''],
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Devis::class,
        ]);
    }
}
