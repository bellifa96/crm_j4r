<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('email', EmailType::class)
            ->add('emailPerso', EmailType::class,[
                'required'=>false,
            ])
            ->add('matricule')
            ->add('firstname')
            ->add('lastname')
            ->add('photo', FileType::class, [
                "data_class" => null,
                "required" => false,
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
            ->add('roles', ChoiceType::class, array(
                    'choices' => [
                        'Super admin' => 'ROLE_SUPER_ADMIN',
                        'Admin' => 'ROLE_ADMIN',
                        'Manageur'=>'ROLE_MANAGER',
                        'Commercial'=>'ROLE_COMMERCIAL',
                        'J4R' => 'ROLE_USER',
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
