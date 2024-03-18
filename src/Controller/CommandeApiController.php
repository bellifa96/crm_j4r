<?php

namespace App\Controller;

use App\Entity\Depot\Chantiers;
use App\Entity\User;
use App\Repository\Depot\ArticleRepository;
use App\Repository\Depot\ChantiersRepository;
use App\Repository\Depot\TransporteurRepository;
use App\Repository\Transport\CdeMatEntRepository;
use App\Repository\UserRepository;
use App\Service\CustomSerializer;
use App\Service\OutlookService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/commande')]
class CommandeApiController extends AbstractController
{

    
    #[Route('/')]
    public function index(): JsonResponse
    {
        return new JsonResponse(['message' => 'This is an example API endpoint'], Response::HTTP_OK);

    }
    public function __construct(
        private CdeMatEntRepository $cdeMatEntRepository,
        private ArticleRepository $articleRepository,
        private OutlookService $outlookService,
        private TransporteurRepository $transporteurRepository,
        private CustomSerializer $customSerializer,
        private ChantiersRepository $chantiersRepository,
        private UserRepository $userRepository



    ) {
    }


 
    // fin  traitement Commande 

    // get Commande par conducteur traveaux
    #[Route('/conducteur/{id}', name: 'commande_conducteur_traveaux_api')]
    public function commande_conducteur_travaux_api(User $user = null): Response // Assuming parameter conversion
    {
        // Check if the User exists
        if (!$user) {
            throw $this->createNotFoundException('No user found for id ');
        }
        $commandes = $user->getCommandes();
        $commandesArray = $commandes->toArray();
        $commandesSerialize = $this->customSerializer->serializeCommandes($commandesArray);
        
        // Handle User with No Commandes
       
        // Valid case: User exists and has commandes
        return new JsonResponse(['resultat' => $commandesSerialize], Response::HTTP_OK);

    }

      // get Commande par Chantiers
      #[Route('/commande_chantiers/{id}', name: 'commande_chantiers_api')]
      public function commande_chantiers_api(Chantiers $chantiers = null): Response // Assuming parameter conversion
      {
          // Check if the User exists
          if (!$chantiers) {
              throw $this->createNotFoundException('No user found for id ');
          }
          $commandes = $chantiers->getCommandes();
          $commandesArray = $commandes->toArray();
  
          usort($commandesArray, function($a, $b) {
              $dateA = $a->getDateCde();
              $dateB = $b->getDateCde();
          
              if ($dateA == $dateB) {
                  return 0;
              }
              return ($dateA > $dateB) ? -1 : 1;
          });
      
          // Handle User with No Commandes
         
          // Valid case: User exists and has commandes
          return $this->render('chantiers/show_commandes_chantiers.html.twig', [
              'title' => 'Commandes par Chantiers',
              'nav' => [],
              'commandes' => $commandesArray, // Pass commandes to the view
              'chantiers' => $chantiers, // Optionally pass the user to the view if needed
          ]);
      }

      
}
