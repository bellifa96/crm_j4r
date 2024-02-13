<?php

namespace App\Controller;

use App\Entity\Depot\Agence;
use App\Entity\Depot\Mouvements;
use App\Form\AgenceType;
use App\Repository\Depot\AgenceRepository;
use App\Repository\Depot\MouvementsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * AgenceController Inject Agence Repository pour communiquer avec Base donnes directement parceque on a pas logiquer metier
 * 
 */
class AgenceController extends AbstractController
{

    private $agenceRepository;


    public function __construct(AgenceRepository $agenceRepository)
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
            'title' => '',
            'agences' => $agences,
            'isAdmin' => $admin,
            'nav' => []
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
            if ($resulat) {
                $this->addFlash("success", "L'agence a été correctement créer");
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
}
