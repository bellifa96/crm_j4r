<?php

namespace App\Controller;

use App\Entity\Depot\Agence;
use App\Entity\Depot\Articles;
use App\Entity\Depot\Depot;
use App\Entity\Depot\Mouvements;
use App\Form\AgenceType;
use App\Repository\Depot\AgenceRepository;
use App\Repository\Depot\ArticleRepository;
use App\Repository\Depot\DepotRepository;
use App\Repository\Depot\MouvementsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * AgenceController Inject Agence Repository pour communiquer avec Base donnes directement parceque on a pas logiquer metier
 * 
 */
class AgenceController extends AbstractController
{

    private $agenceRepository;


    public function __construct(AgenceRepository $agenceRepository, private DepotRepository $depotRepository, private EntityManagerInterface $entityManager, private ArticleRepository $articleRepository)
    {
        $this->agenceRepository = $agenceRepository;
    }


    /**
     *  cette methode retourner la lister des agence et check user connecter si admin on donne la permission du supprission
     */
    #[Route('/agence', name: 'app_agence')]
    public function index(Security $security): Response
    {

        $agences = $this->agenceRepository->findAll();

        $user = $security->getUser();

        $admin = false;

        // Check if user is authenticated
        if ($user) {
            // Get user roles
            $roles = $user->getRoles();
            if (in_array("ROLE_ADMIN", $roles)) {
                $admin = true;
            } else {
                $admin = false;
            }
        }

        return $this->render('agence/index.html.twig', [
            'controller_name' => 'AgenceController',
            'title' => 'Agence',
            'agences' => $agences,
            'isAdmin' => $admin,
            'nav' => [['app_agence_add_agence', 'Création une Agence']]
        ]);
    }
    /** méthod pour afficher le formulaire et stocker les donées   */
    #[Route('/add-agence', name: 'app_agence_add_agence')]
    public function add_agence(Request $request): Response
    {

        // on crééer un "nouveau Agence"
        $agence = new Agence();
        $agences = $this->agenceRepository->findAll();
        $agence->setAgence(count($agences) + 1);
        $form = $this->createForm(AgenceType::class, $agence);

        // on traite la requete du formulaire
        $form->handleRequest($request);

        // on verifier la formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $ouverture = $request->request->get('ouverture');
            $fermeture = $request->request->get('fermeture');
            $agence->setInfoouverture($ouverture . '-' . $fermeture . '');
            $resulat = $this->agenceRepository->addAgence($agence);
            $this->entityManager->flush(); // Flush in batches

            if ($resulat) {
                $depot = $this->creer_depot_layher($agence);
                $this->entityManager->flush(); // Flush in batches

                if ($depot != null) {
                    $resInsertArticle =  $this->duplicate_article_by_depot_layher_nouveau_agence_created($agence, $depot);
                } else {
                }
                return $this->redirectToRoute("app_agence");
            } else {
            }
        }




        // on renvoie les donnes les formulaire et peut aussi utiliser Compact
        return $this->render('agence/new.html.twig', [
            'ticket' => null,
            'form' => $form->createView(),
            'title' => 'Création une Agence',
            'ouverture' => '08:00',
            'fermeture' => '18:00',
            'nav' => [['app_agence', 'Agences']]
        ]);
    }
    #[Route('/edit-agence/{id}', name: 'app_agence_edit_agence')]
    public function edit_agence(Agence $agence, Request $request): Response
    {

        // on crééer un "nouveau Agence"

        // Split the string into opening and closing times
        list($ouverture, $fermeture) = explode('-', $agence->getInfoouverture());

        // Output the results

        $form = $this->createForm(AgenceType::class, $agence);

        // on traite la requete du formulaire
        $form->handleRequest($request);

        // on verifier la formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $ouverture = $request->request->get('ouverture');
            $fermeture = $request->request->get('fermeture');
            $agence->setInfoouverture($ouverture . '-' . $fermeture . '');
            $resulat = $this->agenceRepository->addAgence($agence);
            if ($resulat) {
                $this->addFlash("success", "L'agence a été correctement modifiée");
                return $this->redirectToRoute("app_agence");
            } else {
            }
        }




        // on renvoie les donnes les formulaire et peut aussi utiliser Compact
        return $this->render('agence/edit.html.twig', [
            'ticket' => null,
            'form' => $form->createView(),
            'title' => 'Modification une Agence',
            'ouverture' => $ouverture,
            'fermeture' => $fermeture,
            'nav' => [['app_agence', 'Agences']]
        ]);
    }

    /**
     * cette method supprimer la agence si y pas des mouvement dans la table retourner JSON AVEC CODE 200 sinon un code et msg
     */
    #[Route('/delete_agence', name: 'delete_agence')]
    public function delete_agence(Request $request, MouvementsRepository $mouvementsRepository)
    {

        $idagence = $request->query->get('id');

        $agence = $this->agenceRepository->getAgenceById($idagence);
        if ($agence != null) {
            $mouvements = $this->agenceRepository->getMouvementsByAgence($agence);
            $code = 205;
            if (sizeof($mouvements) == 0) {
                $code =  $this->agenceRepository->deleteAgenceById($agence);
                if ($code  == 500) {
                    $response = [
                        'code' => $code,
                        'msg' => "error",
                    ];
                    return new JsonResponse($response);
                }
            } else {
            }

            $response = [
                'code' => $code,
                'msg' => "suppression impossible  car il existe des mouvements",
            ];
            return new JsonResponse($response);
        } else {
            $response = [
                'code' => 500,
                'msg' => "agence n'exist pas",
            ];

            return new JsonResponse($response);
        }
    }
    // creation une agence il faut créer une depot layher 
    public function creer_depot_layher($agence)
    {

        $depot = $this->agenceRepository->getAgenceByAgence();
        $depot_layher = new Depot();
        $depot_layher->setCodedepot(1);
        $depot_layher->setAgence($agence);
        $depot_layher->setNomdepot("LAYHER");
        $depot_layher->setCodechantier(1);
        $depot_layher->setCommentaires($depot->getCommentaires());
        $depot_layher->setVilledepot($depot->getVilledepot());
        $depot_layher->setCpdepot($depot->getCpdepot());
        $depot_layher->setAdressedepot($depot->getAdressedepot());
        $depot_layher->setContactemail($depot->getContactemail());
        $depot_layher->setContacttel($depot->getContacttel());
        $depot_layher->setAdressedepot($depot->getAdressedepot());
        $depot_layher->setContactportable($depot->getContactportable());
        $depot_layher->setContactportable($depot->getContactportable());
        $depot_layher->setInfoouverture($depot->getInfoouverture());


        $res = $this->depotRepository->add_update_depot($depot_layher);
        if ($res) {
            return $depot_layher;
        } else {
            return null;
        }
    }
    public function duplicate_article_by_depot_layher_nouveau_agence_created($agence, $depot)
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);

        $depotlayher_agence_pricinpale = $this->agenceRepository->getAgenceByAgence();
        if ($depotlayher_agence_pricinpale == null) {
            return null;
        }
        $articles = $this->articleRepository->findAllbyIdDepot($depotlayher_agence_pricinpale);
        if ($articles == null) {
            return null;
        }

        $batchSize = 500; // Determine the best batch size for your environment
        
        try {
            foreach ($articles as $index => $arti) {
                $article = new Articles();
                $article->setArticle($arti["article"]);
                $article->setDesignation($arti["designation"]);
                $article->setPoids($arti["poids"]);
                $article->setQtedispo(0);
                $article->setQteachat(0);
                $article->setQtereserve(0);
                $article->setQtehs(0);
                $article->setQtetransit(0);
                $article->setDateachat($arti["dateachat"]);
                $article->setDateachatinv($arti["dateachatinv"]);
                $article->setFournisseur($arti["reffourn"]);
                
                $article->setOldprixl($arti["oldprixl"]);
                $article->setOldprixv($arti["oldprixv"]);
                $article->setOldpoids($arti["oldpoids"]);
                $article->setQteloctheorique($arti["qteloctheorique"]);
                $article->setQteloctheorique($arti["qtelocreelle"]);


                $article->setVente($arti["vente"]);
                $article->setLocation($arti["location"]);
                $article->setConsommable($arti["consommable"]);
                $article->setConditionnement($arti["conditionnement"]);
                // a optimisser
                $article->setIdagence($agence);
                $article->setDepot($depot);
                $this->articleRepository->add($article, false); // Pass false to prevent flushing
                if (($index + 1) % $batchSize === 0) {
                    $this->entityManager->flush(); // Flush in batches
                    $this->entityManager->clear(Articles::class);
                }
            }
            $this->entityManager->flush(); // Flush in batches
            $this->entityManager->clear(); // Detach all entities from the EntityManager
            return true;
        } catch (Exception $e) {
            dd($e);
            return null;
        }
    }
}
