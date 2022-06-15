<?php

namespace App\Form\Affaire;

use App\Entity\Affaire\Evenement;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('dateDeDebut', DateTimeType::class, ['data' => new \DateTime(),
                'attr' => ['min' => (new \DateTime())->format('Y-m-d H:i')]])
            ->add('dateDeFin', DateTimeType::class, ['data' => new \DateTime(),
                'attr' => ['min' => (new \DateTime())->format('Y-m-d H:i')]])
            ->add('priorite')
            ->add('typeDEvenement')
            ->add('attribueA', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.lastname', 'ASC');
                },
                'choice_label' => function ($user) {
                    return $user->getLastname() . ' ' . $user->getFirstname();
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
            'allow_extra_field' => true,
        ]);
    }
}
