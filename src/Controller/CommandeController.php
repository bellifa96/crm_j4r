<?php

namespace App\Controller;

use App\Entity\Depot\Chantiers;
use App\Entity\Transport\CdeMatEnt;
use App\Entity\User;
use App\Form\CommandeType;
use App\Repository\Depot\AgenceRepository;
use App\Repository\Depot\ArticleRepository;
use App\Repository\Depot\DepotRepository;
use App\Repository\Depot\TransporteurRepository;
use App\Repository\Transport\CdeMatDetRepository;
use App\Repository\Transport\CdeMatEntRepository;
use App\Service\CommandeService;
use App\Service\CustomSerializer;
use App\Service\OutlookService;
use App\Service\PdfService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Twig\Environment;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class CommandeController extends AbstractController
{
    private $agenceRepository;

    public function __construct(
        AgenceRepository $agenceRepository,
        private CommandeService $commandeService,
        private CdeMatEntRepository $cdeMatEntRepository,
        private CdeMatDetRepository $cdeMatDetRepository,
        private DepotRepository $depotRepository,
        private ArticleRepository $articleRepository,
        private PdfService $pdfService,
        private Environment $environment,
        private OutlookService $outlookService,
        private TransporteurRepository $transporteurRepository,
        private CustomSerializer $customSerializer


    ) {
        $this->agenceRepository = $agenceRepository;
    }


    #[Route('/commande', name: 'app_commande')]
    public function index(): Response
    {
        $agences = $this->agenceRepository->findAll();
        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
            'title' => 'Commandes',
            'agences' => $agences,
            'nav' => []
        ]);
    }

    /** méthod pour afficher le formulaire et stocker les donées   */
    #[Route('/search-commande', name: 'app_commande_search')]
    public function search_commande_save_update(Request $request)
    {
        try {
            $numCloud = $request->query->get('numCloud');
            $reponse = $this->commandeService->importationCommandeWindecParIdCommande($numCloud);
            if ($reponse == 200) {
                $data = [
                    'message' => 'La commande a bien été chargée',
                    'code' => 200
                ];
                return new JsonResponse($data);
            } else if ($reponse == 500) {
                $data = [
                    'message' => "error sur serveur",
                    'code' => 500
                ];
                return new JsonResponse($data);
            } else {
                $data = [
                    'message' => "La commande est introuvable",
                    'code' => 500
                ];
                return new JsonResponse($data);
            }
        } catch (Exception $e) {
            return $this->json([]);
        }
    }

    /** méthod pour afficher le formulaire et stocker les donées   */
    #[Route('/get-commande', name: 'app_command_depot')]
    public function getCommandeByIdDepot(Request $request, SerializerInterface $serializer)
    {
        try {
            $id_depot = $request->query->get('selectedDepot');
            
            $data = $this->cdeMatEntRepository->listCommandebyIdepot($id_depot);

            $serializedData = $this->customSerializer->serializeCommandes($data);
            return new JsonResponse($serializedData);
        } catch (Exception $e) {
            dd($e);
            return $this->json([]);
        }
    }

    /** méthod pour afficher le detail commande */
    #[Route('/edit-commande/{id}', name: 'edit_commande')]
    public function affiche_commande(CdeMatEnt $cdeMatEnt, Request $request)
    {
        $depots = null;
        try {

            $transport = $this->transporteurRepository->findAll();

            $articles = $this->cdeMatDetRepository->articles_by_cde($cdeMatEnt->getId());

            $articlesbyDepot = $this->articleRepository->findAll_article_désignation_byIdDepot($cdeMatEnt->getIddepot(), 1);

            $depots = $this->depotRepository->findOneByIdDepot($cdeMatEnt->getIddepot());

            $form = $this->createForm(CommandeType::class, $cdeMatEnt);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {


                $resulat = $this->cdeMatEntRepository->save($cdeMatEnt);
                if (($cdeMatEnt->getNumErpLocation() != null  || $cdeMatEnt->getNumErpVente() != null) && $cdeMatEnt->getIdCalendar() != null) {
                    $res =  $this->outlookService->changeEvent_To_IBMValid($cdeMatEnt->getIdCalendar());
                }
                if ($resulat) {
                    $this->addFlash("success", "l'article a été correctement modifiée");
                    return new RedirectResponse($this->generateUrl('app_commande'));
                } else {
                }
            }
            $cdeEnteHeure = null;
            if ($cdeMatEnt->getTransports()[0] == null) {
                $cdeEnteHeure = $cdeMatEnt->getHeureEnlevDem()->format('H:i');
            } else {
                $cdeEnteHeure = $cdeMatEnt->getTransports()[0]->getHeuredep();
            }
            return $this->render('commande/edit.html.twig', [
                'form' => $form->createView(),
                'title' => 'Modification Commande',
                'nav' => [['app_commande', 'Commande']],
                'articles' => $articles,
                'depots' => $depots,
                'transporteurs' => $transport,
                'articlesbyDepot' => $articlesbyDepot,
                'idCdeEnte' => $cdeMatEnt->getId(),
                'cdeEnteHeure' => $cdeEnteHeure,
                'transport' => $cdeMatEnt->getTransports()[0]
            ]);
        } catch (Exception $e) {
            dd($e->getMessage());
            return $e->getMessage();
        }
    }

    /** méthod modifier les qtes articles   */
    #[Route('/update-qte-article', name: 'app_qte_article')]
    public function update_qte_article(Request $request)
    {
        try {
            $qtes = json_decode($request->getContent(), true);
            $reponse = $this->commandeService->update_qte_sortie($qtes);
            if ($reponse == 200) {
                $data = [
                    'message' => 'La quantité a bien été modifier',
                    'code' => 200
                ];
                return new JsonResponse($data);
            } else if ($reponse == 500) {
                $data = [
                    'message' => "error sur serveur",
                    'code' => 500
                ];
                return new JsonResponse($data);
            } else {
                $data = [
                    'message' => "La quantité est introuvable",
                    'code' => 500
                ];
                return new JsonResponse($data);
            }
        } catch (Exception $e) {

            return $this->json([]);
        }
    }

    /** méthod pour récuperer les articles vente ou location   */
    #[Route('/get-article-type', name: 'app_command_article_type')]
    public function getArticlebyType(Request $request)
    {
        try {
            $type = $request->query->get('type');
            $depot = $this->depotRepository->findOneByCodedepot(20143);
            $articles = $this->articleRepository->findAll_article_désignation_byIdDepot($depot, $type);

            return $this->json($articles);
        } catch (Exception $e) {

            return $this->json([]);
        }
    }

    #[Route('/commandes/transporteurs', name: 'api_transporteurs')]
    public function list_transorteur(): JsonResponse
    {
        $transporteurs = $this->transporteurRepository->findAll();


        return $this->json($transporteurs);
    }

    /** méthod pour ajouter    */
    #[Route('/add-commande', name: 'app_new_commande')]
    public function add_commande(Request $request)
    {
        try {
            $depot = $request->query->get('depot');
            $articlesbyDepot = $this->articleRepository->findAll_article_désignation_byIdDepot($depot, 1);
            $cdeMatEnt = new CdeMatEnt();
            $depots = $this->depotRepository->findOneByIdDepot($depot);

            $form = $this->createForm(CommandeType::class, $cdeMatEnt);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
            }
            return $this->render('commande/new.html.twig', [
                'ticket' => null,
                'form' => $form->createView(),
                'title' => 'Création Commande',
                'nav' => [['app_commande', 'Commande']],
                'articles' => null,
                'depots' => $depots,
                'articlesbyDepot' => $articlesbyDepot,
                'idCdeEnte' => 0
            ]);
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    /** méthod pour récuperer les articles vente ou location   */
    #[Route('/save-cde-ent', name: 'app_command_article_type_save')]
    public function save_cde_ent(Request $request)
    {
        try {
            $requestData = json_decode($request->getContent(), true);

            // Access articleQte if present
            $urlEncodedString = $requestData['formData'] ?? [];
            $depot = $requestData['depot'] ?? [];
            parse_str($urlEncodedString, $formData);



            $articleQteArray = $requestData["articleQte"];
            $resultat = $this->commandeService->save($formData, $articleQteArray, $depot);




            return $this->json($resultat);
        } catch (Exception $e) {
            dd($e->getMessage());
            return $this->json([]);
        }
    }

    /** méthod pour récuperer les articles vente ou location   */
    #[Route('/pdf-commande/{id}', name: 'app_pdf_generer')]
    public function generer_pdf(CdeMatEnt $cdeMatEnt, Request $request)
    {
        try {
            $articles = $this->cdeMatDetRepository->articles_by_cde($cdeMatEnt->getId());


            $header = $this->environment->render('commande/headerpdf.html.twig', ['cdeMat' => $cdeMatEnt, 'articles' => $articles]);

            $this->pdfService->generateTemplate($header);

            $pdf = $this->pdfService->generatePdf("ss");

            $response = new Response($pdf);
            $disposition = $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_INLINE,
                'ss.pdf'
            );
            $response->headers->set('Content-Disposition', $disposition);

            return $response;
        } catch (Exception $e) {
            dd($e->getMessage());
            return $this->json([]);
        }
    }

    /** méthod pour annuler la commande on persist motif  */
    #[Route('/annuler-commande', name: 'annuler_commande')]
    public function annuler_commande(Request $request)
    {
        try {
            $motif = $request->query->get('motif');
            $idCommande = $request->query->get('idCommande');
            $res = $this->cdeMatEntRepository->annuler_commande($motif, $idCommande);

            return new Response($res); // Assuming $res is a string or something that can be directly returned as a response
        } catch (Exception $e) {

            return $this->json([]);
        }
    }


    // affichage les commande Annuler 
    #[Route('/commande_annuler', name: 'commande_annuler_affichage')]
    public function affichage_commande_annuler(): Response
    {
        $agences = $this->agenceRepository->findAll();
        return $this->render('commande/annuler_affichage.html.twig', [
            'controller_name' => 'CommandeController',
            'title' => 'Commandes Annulées',
            'agences' => $agences,
            'nav' => [['app_commande', 'Commande']],
        ]);
    }

    // getCommande  Annuler
    #[Route('/get-commande-annuler', name: 'app_command_annuler_affichage')]
    public function getCommandeAnnuler(Request $request)
    {
        try {
            $id_depot = $request->query->get('selectedDepot');
            $commandes = $this->cdeMatEntRepository->listCommandebyIdDepotAnnuler($id_depot);

            $serializedData = $this->customSerializer->serializeCommandes($commandes);
            return new JsonResponse($serializedData);
        } catch (Exception $e) {

            return $this->json([]);
        }
    }
    // fin  traitement Commande 

    // get Commande par conducteur traveaux
    #[Route('/commande_conducteur/{id}', name: 'commande_conducteur_traveaux')]
    public function commande_conducteur_travaux(User $user = null): Response // Assuming parameter conversion
    {
        // Check if the User exists
        if (!$user) {
            throw $this->createNotFoundException('No user found for id ');
        }
        $commandes = $user->getCommandes();
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
        return $this->render('chantiers/show_conducteur.html.twig', [
            'title' => 'Commandes par Conducteur de Travaux',
            'nav' => [],
            'commandes' => $commandes, // Pass commandes to the view
            'user' => $user, // Optionally pass the user to the view if needed
        ]);
    }

      // get Commande par Chantiers
      #[Route('/commande_chantiers/{id}', name: 'commande_chantiers')]
      public function commande_chantiers(Chantiers $chantiers = null): Response // Assuming parameter conversion
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
