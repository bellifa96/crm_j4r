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
            ->add('article', TextType::class, ['label' => 'Article', 'disabled' => true])
            ->add('designation', TextType::class, ['label' => 'Designation', 'disabled' => true])
            ->add('prixvente', TextType::class, ['label' => 'Prix de Vente', 'disabled' => true])
            ->add('prixloc', TextType::class, ['label' => 'Prix de Location', 'disabled' => true])
            ->add('poids', IntegerType::class, ['label' => 'Poids', 'disabled' => true])
            ->add('vente', CheckboxType::class, ['label' => 'Vente'])
            ->add('location', CheckboxType::class, ['label' => 'Location'])
            ->add('consommable', CheckboxType::class, ['label' => 'Consommable'])
            ->add('conditionnement', CheckboxType::class, ['label' => 'Conditionnement'])
            ->add('qtetotale', IntegerType::class, ['label' => 'Quantité Totale', 'disabled' => true])
            ->add('qtedispo', IntegerType::class, ['label' => 'Quantité Disponible', 'disabled' => true])
            ->add('qtesortie', IntegerType::class, ['label' => 'Quantité Sortie', 'disabled' => true])
            ->add('qtereserve', IntegerType::class, ['label' => 'Quantité Réservée', 'disabled' => true])
            ->add('qtetransit', IntegerType::class, ['label' => 'Quantité en Transit', 'disabled' => true])
            ->add('commentaires', TextareaType::class, ['label' => 'Commentaires', 'disabled' => true])
            ->add('emplacement', TextType::class, ['label' => 'Emplacement', 'disabled' => true])
            ->add('fournisseur', TextType::class, ['label' => 'Fournisseur', 'disabled' => true])
            ->add('reffourn', TextType::class, ['label' => 'Référence Fournisseur', 'disabled' => true])
            ->add('depot', EntityType::class, [
                'class' => 'App\Entity\Depot\Depot',
                'choice_label' => 'nomdepot', // Adjust based on your Depot entity properties
                'label' => 'Dépôt',
                'disabled' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
