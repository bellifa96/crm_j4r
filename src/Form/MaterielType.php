<?php

namespace App\Form;

use App\Entity\Materiel;
use App\Form\Ged\FichierType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('photo',FileType::class,[
                'data_class'=>null,
            ])
            ->add('titre')
            ->add('description')
            ->add('categorie')
            ->add('adresse')
            ->add('etat')
            ->add('prix')
            ->add('dateDAcquisition')
            ->add('note')

   /*         ->add('fichiers',CollectionType::class,[
                'entry_type' => FichierType::class,

            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Materiel::class,
        ]);
    }
}
