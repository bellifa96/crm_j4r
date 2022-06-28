<?php

namespace App\Form\Affaire;

use App\Entity\Affaire\Transport;
use App\Entity\Contact\Contact;
use App\Entity\Interlocuteur\Interlocuteur;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codeChantierJ4R')
            ->add('codeChantierLayher')
            ->add('referenceCommande')
            ->add('codeIBM')
            ->add('codeERP')
            ->add('nCommande')
            ->add('typeDeTransport')
            ->add('typeDeVehicule')
            ->add('tonnageCommande')
            ->add('tonnagePrepare')
            ->add('tonnageLivre')
            ->add('prix')
            ->add('montantDeLaCourse')
            ->add('adresseEnlevement')
            ->add('dateDEnlevementDemande')
            ->add('instructionEnlevementConducteur')
            ->add('adresseLivraison')
            ->add('dateLivraisonDemande')
            ->add('referenceLivraison')
            ->add('instructionLivraisonConducteur')
            ->add('donneurDOrdre', EntityType::class, [
                    'class' => User::class,
                    'choice_label'=> 'pseudo'
                ]
            )
            ->add('ConducteurDeTravaux', EntityType::class, [
                'class' => User::class,
                'choice_label'=> 'pseudo'
            ])
            ->add('sousTraitantPrincipal', EntityType::class, [
                'class' => Interlocuteur::class,
                'choice_label' => function( Interlocuteur $i){
                    return !empty($i->getSociete()) ? $i->getSociete()->getRaisonSociale() : $i->getPersonne()->getNom()." ".$i->getPersonne()->getPrenom();
                }
            ])
            ->add('chauffeur', EntityType::class, [
                'class' => Contact::class,
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('c')
                        ->join('c.societe', 'i')
                        ->where('i.roles LIKE :role')
                        ->setParameter('role', 'ROLE_TRANSPORTEUR');
                },
                'choice_label'=> 'nom'

            ])
            ->add('transporteur', EntityType::class, [
                'class' => Interlocuteur::class,
                'choice_label' => function( Interlocuteur $i){
                   return !empty($i->getSociete()) ? $i->getSociete()->getRaisonSociale() : $i->getPersonne()->getNom()." ".$i->getPersonne()->getPrenom();
                }

            ])
            ->add('contactEnlevement', EntityType::class, [
                'class' => Contact::class,
                'choice_label' => 'nom',

            ])
            ->add('contactLivraison', EntityType::class, [
                'class' => Contact::class,
                'choice_label' => 'nom',

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transport::class,
        ]);
    }
}
