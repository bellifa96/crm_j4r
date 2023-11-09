<?php

namespace App\Form\Affaire;

use App\Entity\Affaire\Devis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class DevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designationDesTravaux')
            ->add('observations', TextareaType::class, [
                'constraints' => [new Length(['max' => 10])],
                'attr' => ['maxlength' => 10], // Remplace 100 par le nombre de caractères souhaité
            ])
            ->add('commentaireInterne');
       
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Devis::class,
        ]);
    }
}
