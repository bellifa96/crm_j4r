<?php

namespace App\Form;

use App\Entity\Depot\Agence;
use App\Entity\Depot\Chantiers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\Depot\AgenceRepository;
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
            ->add('etat')
            ->add('ville')
            ->add('cp')
            ->add('client')
            ->add('nomchantier')
            ->add('voie')
            ->add('adresse')
            ->add('idagence', EntityType::class, [
                'class' => Agence::class,
                'query_builder' => function (AgenceRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('u');
                },
                'choice_label' => 'nomagence',
                'label' => 'Agence',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chantiers::class,
        ]);
    }
}
