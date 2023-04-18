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
        $topParent = false;
        if ($element['type'] == 'composant') {
            $composant = $this->em->getRepository(Composant::class)->find($element['id']);
            $composant->getOuvrage()->setPrixDeVenteHT($composant->getOuvrage()->getSommePrixDeVenteHTComposants());
            $composant->getOuvrage()->setMarge($composant->getOuvrage()->getSommePrixDeVenteHTComposants() / $composant->getOuvrage()->getSommeDebourseTotalComposants());
            $this->em->getRepository(Ouvrage::class)->add($composant->getOuvrage());
            $data[]=$composant->getOuvrage()->__toArray();
            $topParentTmp = [
                'id'=>$composant->getOuvrage()->getId(),
                'type'=>'ouvrage'
             ];

            $tp = $this->recursiveCalculBottom($topParentTmp,$data);
        } elseif ($element['type'] == 'ouvrage') {
            $ouvrage = $this->em->getRepository(Ouvrage::class)->find($element['id']);

            if(!empty($ouvrage->getLot())){
                $ouvrage->getLot()->setPrixDeVenteHT($ouvrage->getLot()->getSommePrixDeVenteHTOuvrages()  + $ouvrage->getLot()->getSommePrixDeVenteHTSousLots());
                $ouvrage->getLot()->setMarge(
                    $ouvrage->getLot()->getPrixDeVenteHT()  /
                    ($ouvrage->getLot()->getSommeDebourseTotalOuvrages() + $ouvrage->getLot()->getSommeDebourseTotalSousLots()) );
                $ouvrage->getLot()->setDebourseTotalLot($ouvrage->getLot()->getSommeDebourseTotalOuvrages() + $ouvrage->getLot()->getSommeDebourseTotalSousLots());
                $this->em->getRepository(Lot::class)->add($ouvrage->getLot());
                $data[]=$ouvrage->getLot()->__toArray();
                $topParentTmp = [
                    'id'=>$ouvrage->getLot()->getId(),
                    'type'=>'lot'
                 ];
                 $tp = $this->recursiveCalculBottom($topParentTmp,$data);

            }
        }elseif($element['type'] == 'lot'){
            $lot = $this->em->getRepository(Lot::class)->find($element['id']);
            if(!empty($lot->getLot())){
                $lot->getLot()->setPrixDeVenteHT($lot->getLot()->getSommePrixDeVenteHTOuvrages() + $lot->getLot()->getSommePrixDeVenteHTSousLots());
                $lot->getLot()->setMarge(
                    $lot->getLot()->getPrixDeVenteHT() /
                    ($lot->getLot()->getSommeDebourseTotalOuvrages() + $lot->getLot()->getSommeDebourseTotalSousLots()) );
                $lot->getLot()->setDebourseTotalLot($lot->getLot()->getSommeDebourseTotalOuvrages() + $lot->getLot()->getSommeDebourseTotalSousLots());

                $this->em->getRepository(Lot::class)->add($lot->getLot());
                $data[]=$lot->getLot()->__toArray();
                $topParentTmp = [
                    'id'=>$lot->getLot()->getId(),
                    'type'=>'lot'
                ];
                $tp = $this->recursiveCalculBottom($topParentTmp);
            }            
        }
    
        return $data;
    }




}
