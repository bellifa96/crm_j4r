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

        $this->show = $options['show'];


        $builder
            ->add('article', TextType::class, ['label' => 'Article', 'disabled' => true])
            ->add('designation', TextType::class, ['label' => 'Designation', 'disabled' => true])
            ->add('prixvente', TextType::class, ['label' => 'Prix de Vente', 'disabled' => true])
            ->add('prixloc', TextType::class, ['label' => 'Prix de Location', 'disabled' => true])
            ->add('poids', IntegerType::class, ['label' => 'Poids', 'disabled' => true])
            ->add('vente', CheckboxType::class, ['required' => false])
            ->add('location', CheckboxType::class, ['required' => false])
            ->add('consommable', CheckboxType::class, ['required' => false])
            ->add('conditionnement', CheckboxType::class, ['required' => false])
            ->add('qtedispo', IntegerType::class, ['label' => 'Quantité Disponible', 'disabled' => true])
            ->add('qtesortie', IntegerType::class, ['label' => 'Quantité Sortie', 'disabled' => true])
            ->add('commentaires', TextareaType::class, ['label' => 'Commentaires'])
            ->add('emplacement', TextType::class, ['label' => 'Emplacement'])
            ->add('fournisseur', TextType::class, ['label' => 'Fournisseur', 'disabled' => true])
            ->add('reffourn', TextType::class, ['label' => 'Référence Fournisseur'])
            ->add('depot', EntityType::class, [
                'class' => 'App\Entity\Depot\Depot',
                'choice_label' => 'nomdepot', // Adjust based on your Depot entity properties
                'label' => 'Dépôt',
                'disabled' => true,
            ]);
            // affichage ca depand le depot choisi 
            if ($this->show) {
                $builder->add('qtetransit', IntegerType::class, ['label' => 'Quantité en Transit', 'disabled' => true])
                ->add('qtereserve', IntegerType::class, ['label' => 'Quantité Réservée', 'disabled' => true])
                ->add('qtetotale', IntegerType::class, ['label' => 'Quantité Totale', 'disabled' => false]);

            }else{
                $builder->add('qtetotale', IntegerType::class, ['label' => 'Quantité Totale', 'disabled' => true]);
            }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
            'show' => true, // Set the target entity class

        ]);
    }
}
