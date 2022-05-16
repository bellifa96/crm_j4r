<?php

namespace App\Form\Contact;

use App\Entity\Contact\Contact;
use App\Entity\Contact\Fonction;
use App\Entity\Interlocuteur\Interlocuteur;
use App\Entity\Interlocuteur\Societe;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('telephoneMobile')
            ->add('telephone')
            ->add('dateAnniversaire')
            ->add('fonction',EntityType::class,[
                'class'=>Fonction::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('f')
                        ->orderBy('f.titre', 'ASC');
                },
                'choice_label' => 'titre',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
