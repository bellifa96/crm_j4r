<?php

namespace App\Form;

use App\Entity\Depot\Articles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FloatType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('article', TextType::class)
        ->add('designation', TextType::class)
        ->add('prixvente', TextType::class)
        ->add('prixloc', TextType::class)
        ->add('poids', IntegerType::class)
        ->add('vente', CheckboxType::class)
        ->add('location', CheckboxType::class)
        ->add('consommable', CheckboxType::class)
        ->add('conditionnement', CheckboxType::class)
        ->add('qtetotale', IntegerType::class)
        ->add('qtedispo', IntegerType::class)
        ->add('qtesortie', IntegerType::class)
        ->add('qtereserve', IntegerType::class)
        ->add('qtetransit', IntegerType::class)
        ->add('qtetemp', IntegerType::class)
        ->add('commentaires', TextareaType::class)
        ->add('emplacement', TextType::class)
        ->add('acontroler', CheckboxType::class)
        ->add('fournisseur', TextType::class)
        ->add('reffourn', TextType::class)
        ->add('oldprixv', TextType::class)
        ->add('oldprixl', TextType::class)
        ->add('oldpoids', IntegerType::class)
        ->add('qtehs', IntegerType::class)
        ->add('qteachat', IntegerType::class)
        ->add('qteloctheorique', IntegerType::class)
        ->add('qtelocreelle', IntegerType::class)
        ->add('depot', EntityType::class, [
            'class' => 'App\Entity\Depot\Depot',
            'choice_label' => 'nomdepot', // Adjust based on your Depot entity properties
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
