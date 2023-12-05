<?php

namespace App\Controller;


use App\Entity\Depot\Agence;
use App\Entity\Depot\Articles;
use App\Entity\Depot\Depot;
use App\Repository\Depot\ArticleRepository;
use App\Repository\Depot\DepotRepository;
use App\Service\DepotService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller Depot Inject Service (DepotService) et Repository ($ArticleRepositoy)
 * tu créer rien ici par rapport des requéte tous sur repository (pattern DAO)
 * 
 * 
 */

class DepotController extends AbstractController
{
    private $depotRepository;

    
    public function __construct(DepotRepository $depotRepository)
    {
        $this->depotRepository = $depotRepository;
       
    }


    #[Route('/depot', name: 'app_depot')]
    public function index(): Response
    {
      
        $depots = $this->depotRepository->getAllDepot();


        return $this->render('depot/index.html.twig', [
            'controller_name' => 'AgenceController',
            'title' => '',
            'depots' => $depots,
            'nav' => []
        ]);
    }
}
