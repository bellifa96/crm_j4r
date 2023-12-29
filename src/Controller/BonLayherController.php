<?php

namespace App\Controller;

use App\Entity\Depot\Etatsencours;
use App\Entity\Depot\Etatstransport;
use App\Repository\Depot\BonsdetailstempRepository;
use App\Repository\Depot\EtatEnCoursRepository;
use App\Repository\Depot\EtatTransportRepository;
use App\Service\BonLayherService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BonLayherController extends AbstractController
{

    public function __construct(
        private EtatEnCoursRepository $etatEncoursRepository,
        private BonLayherService $bonLayherService,
        private EntityManagerInterface $entityManager,
        private BonsdetailstempRepository $bonsdetailstempRepository,
        private EtatTransportRepository $etatTransportRepository
    ) {
    }



    #[Route('/bon/layher', name: 'app_bon_layher')]
    public function index(): Response
    {
        $numaffaire = $this->etatEncoursRepository->getALLEtatEncoursbyactif();
        return $this->render('bon_layher/index.html.twig', [
            'controller_name' => 'BonLayherController',
            'title' => 'Bons Layher',
            'affaires' => $numaffaire,
            'nav' => []
        ]);
    }

    #[Route('/affaire-information', name: 'affaire_information')]
    public function affaire_information(Request $request): Response
    {
        try {
            $numaffaire = $request->query->get('numaffaire');
            $response = $this->etatEncoursRepository->findById($numaffaire);
            return $this->json($response);
        } catch (Exception $e) {
            dd($e->getMessage());
            return $this->json([]);
        }
    }

    #[Route('/get-bon-layher', name: 'app_bon_layher_get_entre_deux_date')]
    public function getBonLayherEntreDeuxDate(Request $request)
    {
        try {
            $date_du = $request->query->get('datedu');
            $date_au = $request->query->get('dateau');
            $numaffaire = $request->query->get('numaffaire');

            $response = $this->bonLayherService->getBonLayherEntreDeuxDate($date_du, $date_au,$numaffaire);

            $data = [
                'bonLayher' => $response,
            ];

            return $this->json($data);
        } catch (Exception $e) {
            dd($e->getMessage());
            return $this->json([]);
        }
    }


    #[Route('/get-article-bon', name: 'app_bon_layher_article_num')]
    public function getArticleBonLayher(Request $request)
    {
        try {
            $numBonlayher = $request->query->get('numBonlayher');
            $LayherTransport = $this->etatTransportRepository->getALLbybnsnumBon($numBonlayher);

            $res = $this->bonsdetailstempRepository->getArticlebyNumero($numBonlayher);
            $data = [
                'article' => $res,
                'layherTransport' => $LayherTransport
            ];

            return $this->json($data);
        } catch (Exception $e) {
            dd($e->getMessage());
            return $this->json([]);
        }
    }
}