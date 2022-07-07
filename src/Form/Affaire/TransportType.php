<?php

namespace App\Form\Affaire;

use App\Entity\Affaire\Transport;
use App\Entity\Contact\Contact;
use App\Entity\Interlocuteur\Interlocuteur;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
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
            ->add('typeDeTransport',ChoiceType::class,[
                'choices'=>[
                    'LIV (livraison)'=>'LIV (livraison)',
                    'RAM Ramasse'=>'RAM Ramasse',
                    'RAM TS (ramasse tout sauf palettes)'=>'RAM TS (ramasse tout sauf palettes)',
                    'RAM TY (ramasse Tout y compris palettes)'=>'RAM TY (ramasse Tout y compris palettes)',
                    'ROT (Rotation)'=>'ROT (Rotation)',
                ]
            ])
            ->add('typeDeVehicule',ChoiceType::class,[
                'choices'=>[
                    'Benne'=>'Benne',
                    '19 T'=>'19 T',
                    'Semi sans grue'=>'Semi sans grue',
                    'Grue mobile'=>'Grue mobile',
                ]
            ])
            ->add('tonnageCommande')
            ->add('tonnagePrepare')
            ->add('tonnageLivre')
            ->add('montantDeLaCourse')
            ->add('adresseEnlevement')
            ->add('dateDEnlevementDemande')
            ->add('instructionEnlevementConducteur')
            ->add('adresseLivraison')
            ->add('dateLivraisonDemande')
            ->add('referenceEnlevement')
            ->add('referenceLivraison')
            ->add('heureEnlevement',TimeType::class,[])
            ->add('heureEnlevementFin',TimeType::class)

            ->add('heureLivraison',TimeType::class)
            ->add('heureLivraisonFin',TimeType::class)



            ->add('instructionLivraisonConducteur')
            ->add('ConducteurDeTravaux', EntityType::class, [
                'class' => User::class,
                'choice_label'=> function(User $user){
                    return !empty($user->getPseudo()) ? $user->getPseudo() : $user->getFirstname();
                }
            ])
            ->add('sousTraitantPrincipal', EntityType::class, [
                'class' => Interlocuteur::class,
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('i')
                        ->where('i.roles LIKE :role')
                        ->setParameter('role', '%ROLE_SOUS_TRAITANT%');
                },
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
                        ->setParameter('role', '%ROLE_TRANSPORTEUR%');
                },
                'choice_label'=> 'nom'

            ])
            ->add('transporteur', EntityType::class, [
                'class' => Interlocuteur::class,
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('i')
                        ->where('i.roles LIKE :role')
                        ->setParameter('role', '%ROLE_TRANSPORTEUR%');
                },
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
            'allow_extra_fields'=>true,
        ]);
    }
}
