<?php

namespace App\Service;

use App\Entity\Affaire\Lot;
use App\Entity\Affaire\Ouvrage;
use App\Entity\Affaire\Composant;
use Doctrine\ORM\EntityManagerInterface;



class CalculService
{
    private $em;


    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->em = $entityManagerInterface;
    }

    public function recursiveCalculTop($element,&$data=[]){
        $topParent = false;
        if ($element['type'] == 'composant') {
            $composant = $this->em->getRepository(Composant::class)->find($element['id']);
            $composant->getOuvrage()->setPrixDeVenteHT($composant->getOuvrage()->getSommePrixDeVenteHTComposants());
            if($composant->getOuvrage()->getPrixDeVenteHT() > 0){
                $composant->getOuvrage()->setMarge($composant->getOuvrage()->getSommePrixDeVenteHTComposants() / $composant->getOuvrage()->getSommeDebourseTotalComposants());
            }else{
                $composant->getOuvrage()->setMarge(1);
            }
            $this->em->getRepository(Ouvrage::class)->add($composant->getOuvrage());
            $data[]=$composant->getOuvrage()->__toArray();
            $topParentTmp = [
                'id'=>$composant->getOuvrage()->getId(),
                'type'=>'ouvrage'
             ];

            $tp = $this->recursiveCalculTop($topParentTmp,$data);
        } elseif ($element['type'] == 'ouvrage') {
            $ouvrage = $this->em->getRepository(Ouvrage::class)->find($element['id']);

            if(!empty($ouvrage->getLot())){
                $ouvrage->getLot()->setPrixDeVenteHT($ouvrage->getLot()->getSommePrixDeVenteHTOuvrages()  + $ouvrage->getLot()->getSommePrixDeVenteHTSousLots());
                $ouvrage->getLot()->setDebourseTotalLot($ouvrage->getLot()->getSommeDebourseTotalOuvrages() + $ouvrage->getLot()->getSommeDebourseTotalSousLots());

                if($ouvrage->getLot()->getDebourseTotalLot() > 0){
                    $ouvrage->getLot()->setMarge(
                        $ouvrage->getLot()->getPrixDeVenteHT()  /
                        $ouvrage->getLot()->getDebourseTotalLot() );
                }else{
                    $ouvrage->getLot()->setMarge(1);

                }

                $this->em->getRepository(Lot::class)->add($ouvrage->getLot());
                
                $data[]=$ouvrage->getLot()->__toArray();
                $topParentTmp = [
                    'id'=>$ouvrage->getLot()->getId(),
                    'type'=>'lot'
                 ];
                 $tp = $this->recursiveCalculTop($topParentTmp,$data);

            }
        }elseif($element['type'] == 'lot'){
            $lot = $this->em->getRepository(Lot::class)->find($element['id']);
            if(!empty($lot->getLot())){
                $lot->getLot()->setPrixDeVenteHT($lot->getLot()->getSommePrixDeVenteHTOuvrages() + $lot->getLot()->getSommePrixDeVenteHTSousLots());
                $lot->getLot()->setDebourseTotalLot($lot->getLot()->getSommeDebourseTotalOuvrages() + $lot->getLot()->getSommeDebourseTotalSousLots());



                if($lot->getLot()->getDebourseTotalLot() > 0){
                    $lot->getLot()->setMarge(
                        $lot->getLot()->getPrixDeVenteHT() /
                        $lot->getLot()->getDebourseTotalLot() );
                }else{
                    $lot->getLot()->setMarge(1);
                }
                $this->em->getRepository(Lot::class)->add($lot->getLot());
                $data[]=$lot->getLot()->__toArray();
                $topParentTmp = [
                    'id'=>$lot->getLot()->getId(),
                    'type'=>'lot'
                ];
                $tp = $this->recursiveCalculTop($topParentTmp);
            }            
        }
        return $data;
    }


    public function recursiveCalculBottom($element,&$data=[]){
        if ($element['type'] == 'ouvrage') {
            $ouvrage = $this->em->getRepository(Ouvrage::class)->find($element['id']);
            $debourseTotalDeOuvrage = $ouvrage->getSommeDebourseTotalComposants();
            $prixDeVenteHTOuvrage = $ouvrage->getPrixDeVenteHT();

            foreach($ouvrage->getComposants() as $composant){
                $prixDeVenteHTComposant = $composant->getPrixDeVenteHT();
                $deboureTotalComposant = $composant->getQuantite() * $composant->getDebourseUnitaireHT();
                $margeOuvrage = $ouvrage->getMarge();
                
                try {
                    $nouvelleMargeComposant = $debourseTotalDeOuvrage * $margeOuvrage * $prixDeVenteHTComposant / $prixDeVenteHTOuvrage / $deboureTotalComposant;
                } catch (\DivisionByZeroError $e) {
                    $nouvelleMargeComposant = 1;
                }
                $composant->setMarge($nouvelleMargeComposant);
                $composant->setPrixDeVenteHT($composant->getQuantite() * $composant->getDebourseUnitaireHT() * $composant->getMarge());
                $this->em->getRepository(Composant::class)->add($composant);
                $data[]=$composant->__toArray();
            }
            $ouvrage->setPrixDeVenteHT($ouvrage->getSommePrixDeVenteHTComposants());
            $this->em->getRepository(Ouvrage::class)->add($ouvrage);


        }elseif($element['type'] == 'lot'){
            $lot = $this->em->getRepository(Lot::class)->find($element['id']);

            $debourseTotalDeLot = $lot->getSommeDebourseTotalSousLots()+ $lot->getSommeDebourseTotalOuvrages();
            $prixDeVenteHTLot = $lot->getPrixDeVenteHT();
            foreach($lot->getOuvrages() as $ouvrage){
                $prixDeVenteHTOuvrage = $ouvrage->getPrixDeVenteHT();
                $deboureTotalOuvrage = $ouvrage->getSommeDebourseTotalComposants();
                $margeLot = $lot->getMarge();
                try {
                    $nouvelleMargeOuvrage = $debourseTotalDeLot * $margeLot * $prixDeVenteHTOuvrage / $prixDeVenteHTLot / $deboureTotalOuvrage;
                } catch (\DivisionByZeroError $e) {
                    $nouvelleMargeOuvrage = 1;
                }
                $ouvrage->setMarge($nouvelleMargeOuvrage);
                $child = [
                    'id'=>$ouvrage->getId(),
                    'type'=>'ouvrage'
                ];
                $this->em->getRepository(Ouvrage::class)->add($ouvrage);
                $data[]=$ouvrage->__toArray();
                $tp = $this->recursiveCalculBottom($child,$data);
            }

            foreach($lot->getSousLots() as $sLot){
                    $prixDeVenteHTSousLot = $sLot->getPrixDeVenteHT();
                    $deboureTotalSousLot =  $sLot->getSommeDebourseTotalSousLots()+ $sLot->getSommeDebourseTotalOuvrages();
                    $margeLot = $lot->getMarge();
                    try {
                        $nouvelleMargeSousLot = $debourseTotalDeLot * $margeLot * $prixDeVenteHTSousLot / $prixDeVenteHTLot / $deboureTotalSousLot;
                    } catch (\DivisionByZeroError $e) {
                        $nouvelleMargeSousLot = 1;
                    }
                    $sLot->setMarge($nouvelleMargeOuvrage);
                    $child = [
                        'id'=>$sLot->getId(),
                        'type'=>'lot'
                    ];
                    $this->em->getRepository(Lot::class)->add($sLot);
                    $data[]=$sLot->__toArray();
                    $tp = $this->recursiveCalculBottom($child,$data);
                
            } 
            $lot->setPrixDeVenteHT($lot->getSommePrixDeVenteHTOuvrages() + $lot->getSommePrixDeVenteHTSousLots());
            $lot->setDebourseTotalLot($lot->getSommeDebourseTotalOuvrages() + $lot->getSommeDebourseTotalSousLots());
            $this->em->getRepository(Lot::class)->add($lot);
        }
    
        return $data;
    }




}
