<?php

namespace App\Controller;

use App\Entity\Affaire\Devis;
use App\Entity\Affaire\Evenement;
use App\Entity\Affaire\Statut;
use App\Entity\Contact\Contact;
use App\Entity\Demande;
use App\Entity\Ged\Fichier;
use App\Entity\User;
use App\Form\Affaire\EvenementType;
use App\Form\DemandeType;
use App\Form\Ged\FichierType;
use App\Repository\Affaire\EvenementRepository;
use App\Repository\Affaire\StatutRepository;
use App\Repository\DemandeRepository;
use App\Repository\Ged\FichierRepository;
use App\Repository\UserRepository;
use App\Service\EmailService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

#[Route('/demande')]
class DemandeController extends AbstractController
{

    private $em;
    private $emailService;

    public function __construct(EntityManagerInterface $em, EmailService $emailService)
    {
        $this->em = $em;
        $this->emailService = $emailService;
    }

    #[Route('/', name: 'app_demande_index', methods: ['GET'])]
    public function index(DemandeRepository $demandeRepository, StatutRepository $statutRepository, UserRepository $userRepository): Response
    {

        foreach ($demandeRepository->findAll() as $demande) {
            if (empty($demande->getReference())) {
                $demande->setReference(date('y') . date('m') . '-' . $demande->getId());
                $demandeRepository->add($demande);
            }
        }
        return $this->render('demande/index.html.twig', [
            'demandes' => $demandeRepository->findAll(),
            'users' => $userRepository->findAll(),
            'title' => 'Liste des demandes',
            'nav' => [['app_demande_new', 'Ajouter une demande']]
        ]);
    }

    #[Route('/new', name: 'app_demande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DemandeRepository $demandeRepository): Response
    {
        $demande = new Demande();
        $demande->setCreateur($this->getUser());

        $form = $this->createForm(DemandeType::class, $demande);

        if ($this->isGranted('ROLE_ADMIN') or $this->isGranted('ROLE_SUPER_ADMIN')) {
            $form->add('statut', EntityType::class, [
                'class' => Statut::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->where('s.destination LIKE :val')
                        ->setParameter('val', '%"SD"%');
                },
                'choice_label' => 'titre',
            ]);
            $form->add('statutCommercial', EntityType::class, [
                'class' => Statut::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->where('s.destination LIKE :val')
                        ->setParameter('val', '%"SCD"%');
                },
                'required' => false,
                'choice_label' => 'titre',
            ]);
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            if ($demande->isFaireUnReleve() and !empty($demande->getUserReleve())) {
                $objet = "Faire un relevé de la demande N°" . $demande->getId() . " pour le client " . $demande->getClient();
                $template = "/emails/releve.html.twig";
                $email = $this->emailService->send([$demande->getUserReleve()->getEmail()], $demande, $template, $objet);

            } elseif (!$demande->isFaireUnReleve() and !empty($demande->getUserReleve())) {
                $demande->setUserReleve(null);
            }

            if ($demande->isFaireUnDevis() and !empty($demande->getUserDevis())) {
                $objet = "Faire un Devis de la demande N°" . $demande->getId() . " pour le client " . $demande->getClient();
                $template = "/emails/devis.html.twig";
                $email = $this->emailService->send([$demande->getUserDevis()->getEmail()], $demande, $template, $objet);

            } elseif (!$demande->isFaireUnDevis() and !empty($demande->getUserDevis())) {
                $demande->setUserDevis(null);
            }

            return $this->extracted($request, $demande, $demandeRepository,);

            $demande->setReference((date('y') % 10) . date("m") . sprintf("%04d", $demande->getId()));

            return $this->extracted($request, $demande, $demandeRepository,);
        }

        return $this->renderForm('demande/new.html.twig', [
            'demande' => $demande,
            'form' => $form,
            'title' => 'Créer une nouvelle Demande',
            'nav' => []
        ]);
    }

    #[Route('/modal/statut/evenement/{id}/{statut}', name: 'app_affaire_statut_evenement_html', methods: ['GET', 'POST'])]
    public function getStatutEvenementHTML(Demande $demande, $statut, Request $request, Environment $environment): Response
    {

        $response = new Response();
        $evenement = new Evenement();
        $evenement->setTitre($demande->getNomChantier());
        $form = $this->createForm(EvenementType::class, $evenement);
        try {
            $html = $environment->render("affaire/evenement/evenement_statut.html.twig", [
                'form' => $form->createView(),
                'statut' => $statut,
            ]);
            $html = str_replace('<form name="evenement" method="post">', '', $html);
            $html = str_replace('</form>', '', $html);
        } catch (LoaderError $e) {
            dd($e);
        } catch (RuntimeError $e) {
            dd($e);
        } catch (SyntaxError $e) {
            dd($e);
        }
        $response->setContent(json_encode(['code' => 200, 'message' => $html]));
        return $response;
    }

    #[Route('/{id}', name: 'app_demande_show', methods: ['GET', 'POST'])]
    public function show(Demande $demande, Request $request, SluggerInterface $slugger, FichierRepository $fichierRepository, DemandeRepository $demandeRepository, UserRepository $userRepository): Response
    {

        $data = $request->query->all();

        if (key_exists('menu', $data)) {
            $menu = $demande->getMenu();
            $menu[$this->getUser()->getId()] = $data['menu'];
        }


        $users = $userRepository->findAll();


        if (empty($demande->getReference())) {
            $demande->setReference(date('y') . date('m') . '-' . $demande->getId());
            $demandeRepository->add($demande);
        }

        $repo = $this->em->getRepository('Gedmo\Loggable\Entity\LogEntry'); // we use default log entry class
        $demande = $this->em->find(Demande::class, $demande->getId());
        $logs = $repo->getLogEntries($demande);

        //  dd($logs);
        $fichier = new Fichier();
        $fichier->setDemande($demande);
        $form = $this->createForm(FichierType::class, $fichier);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {

            $brochureFile = $form->get('fichier')->getData();

            if ($brochureFile) {
                $fichier->setCreateur($this->getUser());
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                try {

                    $brochureFile->move(
                        __DIR__ . "/../../uploads/" . $fichier->getTypeFichier()->getTitre() . "/",
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $fichier->setFichier($newFilename);
            }

            $fichierRepository->add($fichier);
        }

        $referer = $request->headers->get('referer');


        return $this->render('demande/show.html.twig', [
            'users' => $users,
            'demande' => $demande,
            'logs' => $logs,
            'form' => $form->createView(),
            'title' => "Demande N° " . $demande->getReference(),
            'referer' => $referer,
            'nav' => [['app_demande_edit', 'Modifier la demande', $demande->getId()]]
        ]);
    }

    #[Route('/statut/update', name: 'app_demande_statut_update', methods: ['GET', 'POST'])]
    public function updateStatut(Request $request, EvenementRepository $evenementRepository, DemandeRepository $demandeRepository, StatutRepository $statutRepository, UserRepository $userRepository): Response
    {
        $data = $request->request->all()['data'];
        $demande = $demandeRepository->find($data['id']);
        $statut = $statutRepository->find($data['statut']);
        $statut2 = $statutRepository->find($data['statut2']);

        $demande->setStatutCommercial($statut);
        $demande->setStatutCommercial2($statut2);


        if (key_exists('event1', $data)) {
            $evenement = new Evenement();
            $evenement->setDateDeDebut(new \datetime());
            $evenement->setDateDeFin(new \datetime($data['event1']['dateDeFin']));
            $evenement->setTypeDEvenement(!empty($statut->getCode()) ? $statut->getCode() : $statut->getTitre());
            $evenement->setCode($statut->getId());
            $evenement->setTitre($data['event1']['titre']);
            $evenement->setCreateur($this->getUser());
            foreach ($data['event1']['attribueA'] as $val) {
                $user = $userRepository->find($val);
                $evenement->addAttribueA($user);
            }
            $evenement->setDescription($data['event1']['description']);
            $evenement->setPriorite($data['event1']['priorite']);
            $evenement->setDemande($demande);
            $evenementRepository->add($evenement);
        }


        if (key_exists('event2', $data)) {
            $evenement = new Evenement();
            $evenement->setDateDeDebut(new \datetime());
            $evenement->setTypeDEvenement(!empty($statut2->getCode()) ? $statut2->getCode() : $statut2->getTitre());
            $evenement->setCreateur($this->getUser());
            $evenement->setCode($statut2->getId());
            $evenement->setDateDeFin(new \datetime($data['event2']['dateDeFin']));
            $evenement->setTitre($data['event2']['titre']);
            foreach ($data['event2']['attribueA'] as $val) {
                $user = $userRepository->find($val);
                $evenement->addAttribueA($user);
            }
            $evenement->setDescription($data['event2']['description']);
            $evenement->setPriorite($data['event2']['priorite']);
            $evenement->setDemande($demande);

            $evenementRepository->add($evenement);
        }


        try {
            $demandeRepository->add($demande);
            return new Response(json_encode([
                'code' => 200,
                'message' => 'ok',
                'statut' => $statut->getTitre(),
                'couleur' => $statut->getCouleur(),
                'couleurBG' => $statut->getCouleurBG()
            ]));

        } catch (OptimisticLockException|ORMException $e) {
            return new Response(json_encode(['code' => 403, 'message' => $e->getMessage()]));
        }

    }

    #[Route('/statut/modal/template/{id}', name: 'app_demande_statut_modal', methods: ['GET', 'POST'])]
    public function getStatutModal(Demande $demande, Request $request, Environment $environment, StatutRepository $statutRepository): Response
    {

        $path = "demande/modal_change_status.html.twig";
        $statuts = $statutRepository->findAllByCode('SCD');

        $response = new Response();

        if (!empty($path)) {

            try {
                $html = $environment->render($path, ['demande' => $demande, 'statuts' => $statuts]);
            } catch (LoaderError $e) {
                dd($e);
            } catch (RuntimeError $e) {
                dd($e);
            } catch (SyntaxError $e) {
                dd($e);
            }
            $response->setContent(json_encode(['code' => 200, 'message' => $html]));
        }
        return $response;
    }

    #[Route('/form/template', name: 'app_demande_form', methods: ['GET', 'POST'])]
    public function getForm(Request $request, Environment $environment): Response
    {


        $response = new Response();

        if ($request->request->get('id')) {
            $demande = $this->em->getRepository(Demande::class)->find($request->request->get('id'));
        } else {
            $demande = new Demande();
        }
        if ($request->request->get('data') == "Façade") {
            $path = "demande/echafaudage/facade.html.twig";
        } elseif ($request->request->get('data') == "Parapluie") {
            $path = "demande/echafaudage/parapluie.html.twig";

        } elseif ($request->request->get('data') == "Particulier") {
            $path = "demande/echafaudage/particulier.html.twig";

        } elseif ($request->request->get('data') == "Plateforme") {
            $path = "demande/echafaudage/plateforme.html.twig";
        }

        if (!empty($path)) {

            try {
                $html = $environment->render($path, ['demande' => $demande]);
            } catch (LoaderError $e) {
                dd($e);
            } catch (RuntimeError $e) {
                dd($e);
            } catch (SyntaxError $e) {
                dd($e);
            }
            $response->setContent(json_encode(['code' => 200, 'message' => $html]));
        }
        return $response;
    }


    #[Route('/{id}/edit', name: 'app_demande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Demande $demande, DemandeRepository $demandeRepository, UserRepository $userRepository): Response
    {

        $users = $userRepository->findAll();

        $createur = $demande->getCreateur();

        $tmpUserReleve = $demande->getUserReleve();
        $tmpUserDevis = $demande->getUserDevis();

        $form = $this->createForm(DemandeType::class, $demande);
        $form->add('statut', EntityType::class, [
            'class' => Statut::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('s')
                    ->where('s.destination LIKE :val')
                    ->setParameter('val', '%"SD"%');
            },
            'choice_label' => 'titre',
        ]);
        $form->add('statutCommercial', EntityType::class, [
            'class' => Statut::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('s')
                    ->where('s.destination LIKE :val')
                    ->setParameter('val', '%"SCD"%');
            },
            'required' => false,
            'choice_label' => 'titre',
        ]);
        $statut = $demande->getStatut();
        $statusCommercial = $demande->getStatutCommercial();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($demande->isFaireUnReleve() and !empty($demande->getUserReleve()) and $demande->getUserReleve() !== $tmpUserReleve) {
                $objet = "Faire un relevé de la demande N°" . $demande->getId() . " pour le client " . $demande->getClient();
                $template = "/emails/releve.html.twig";
                $email = $this->emailService->send([$demande->getUserReleve()->getEmail()], $demande, $template, $objet);

            } elseif (!$demande->isFaireUnReleve() and !empty($demande->getUserReleve())) {
                $demande->setUserReleve(null);
            }

            if ($demande->isFaireUnDevis() and !empty($demande->getUserDevis()) and $demande->getUserDevis() !== $tmpUserDevis) {
                $objet = "Faire un Devis de la demande N°" . $demande->getId() . " pour le client " . $demande->getClient();
                $template = "/emails/devis.html.twig";
                $email = $this->emailService->send([$demande->getUserDevis()->getEmail()], $demande, $template, $objet);

            } elseif (!$demande->isFaireUnDevis() and !empty($demande->getUserDevis())) {
                $demande->setUserDevis(null);
            }

            if ($demande->getStatutCommercial() !== $statusCommercial) {
                $objet = "Le statut commercial de la demande N°" . $demande->getId() . " a été mis à jour (" . $demande->getStatutCommercial()->getTitre() . ")";
                $template = "/emails/statut_demande.html.twig";
                $email = $this->emailService->send([$demande->getCreateur()->getEmail()], $demande, $template, $objet);
            }
            if ($demande->getStatut() !== $statut) {
                $objet = "Le statut de la demande N°" . $demande->getId() . " a été mis à jour (" . $demande->getStatut()->getTitre() . ")";
                $template = "/emails/statut_demande.html.twig";
                $email = $this->emailService->send([$demande->getCreateur()->getEmail()], $demande, $template, $objet);
            }

            if ($demande->getCreateur() !== $createur) {
                $objet = "La demande N°" . $demande->getId() . " vous a été transféré par " . $createur->getPseudo();
                $template = "/emails/transfere_demande.html.twig";
                $email = $this->emailService->send([$demande->getCreateur()->getEmail()], $demande, $template, $objet);
            }


            return $this->extracted($request, $demande, $demandeRepository,);
        }

        return $this->renderForm('demande/edit.html.twig', [
            'users' => $users,
            'demande' => $demande,
            'form' => $form,
            'title' => 'Liste des demandes',
            'nav' => [['app_demande_new', 'ajouter une demande']]
        ]);
    }

    #[Route('/{id}', name: 'app_demande_delete', methods: ['POST'])]
    public function delete(Request $request, Demande $demande, DemandeRepository $demandeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $demande->getId(), $request->request->get('_token'))) {
            $demandeRepository->remove($demande);
        }

        return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route ('/menu/demande/{value}/{id}', name: 'app_demande_menu', methods: ['GET'])]
    public function activeMenu(Demande $demande, $value, DemandeRepository $demandeRepository): Response
    {
        $menu = $demande->getMenu();
        $menu[$this->getUser()->getId()] = $value;
        $demande->setMenu($menu);
        try {
            $demandeRepository->add($demande);
            return new Response(json_encode([
                'code' => 200,
                'message' => 'Ok'
            ]));
        } catch (OptimisticLockException|ORMException $e) {
            dd($e);
        }

        return new Response(json_encode([
            'code' => 404,
            'message' => 'Erreur'
        ]));

    }

    /**
     * @param Request $request
     * @param Demande $demande
     * @param DemandeRepository $demandeRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function extracted(Request $request, Demande $demande, DemandeRepository $demandeRepository): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $data = $request->request->all()['demande'];

        key_exists('typeDePrestation', $data) ? $demande->setTypeDePrestation($data['typeDePrestation']) : $demande->setTypeDePrestation(null);
        key_exists('documentsSouhaites', $data) ? $demande->setDocumentsSouhaites($data['documentsSouhaites']) : $demande->setDocumentsSouhaites(null);
        key_exists('fondsDePlan', $data) ? $demande->setFondsDePlan($data['fondsDePlan']) : $demande->setFondsDePlan(null);

        key_exists('contactPrincipalClient', $data) ? $contatcC = $this->em->getRepository(Contact::class)->find($data['contactPrincipalClient']) : $contatcC = null;
        !empty($contatcC) ? $demande->setContactPrincipalClient($contatcC) : $demande->setContactPrincipalClient(null);


        key_exists('contactPrincipalMaitreDOuvrage', $data) ? $contatcPMO = $this->em->getRepository(Contact::class)->find($data['contactPrincipalMaitreDOuvrage']) : $contatcPMO = null;
        !empty($contatcPMO) ? $demande->setContactPrincipalMaitreDOuvrage($contatcPMO) : $demande->setContactPrincipalMaitreDOuvrage(null);

        key_exists('contactPrincipalIntermediaire', $data) ? $contatcI = $this->em->getRepository(Contact::class)->find($data['contactPrincipalIntermediaire']) : $contatcI = null;
        !empty($contatcI) ? $demande->setContactPrincipalIntermediaire($contatcI) : $demande->setContactPrincipalIntermediaire(null);

        if (key_exists('contactsSecondaires', $data)) {
            foreach ($data['contactsSecondaires'] as $val) {
                $contact = $this->em->getRepository(Contact::class)->find($val);
                !empty($contact) ? $demande->addContactsSecondaire($contact) : "";
            }
        } else {
            $demande->getContactsSecondaires()->clear();
        }


        //     dd($data);
        key_exists('travauxPrevus', $data) ? $demande->setTravauxPrevus($data['travauxPrevus']) : $demande->setTravauxPrevus([]);

        key_exists('classeDEchaffaudage', $data) ? $demande->setClasseDEchaffaudage($data['classeDEchaffaudage']) : $demande->setClasseDEchaffaudage(null);

        key_exists('typeDeMateriel', $data) ? $demande->setTypeDeMateriel($data['typeDeMateriel']) : $demande->setTypeDeMateriel(null);


        key_exists('ammarages', $data) ? $demande->setAmmarages($data['ammarages']) : $demande->setAmmarages(null);

        key_exists('largeurDeTravail', $data) ? $demande->setLargeurDeTravail($data['largeurDeTravail']) : $demande->setLargeurDeTravail(null);

        key_exists('consoles', $data) ? $demande->setConsoles($data['consoles']) : $demande->setConsoles(null);

        key_exists('distanceALaFacade', $data) ? $demande->setDistanceALaFacade($data['distanceALaFacade']) : $demande->setDistanceALaFacade(null);

        key_exists('rapportDistanceALaFacade', $data) ? $demande->setRapportDistanceALaFacade($data['rapportDistanceALaFacade']) : $demande->setRapportDistanceALaFacade(null);

        key_exists('hauteurDesPlanchers', $data) ? $demande->setHauteurDesPlanchers($data['hauteurDesPlanchers']) : $demande->setHauteurDesPlanchers(null);

        key_exists('equipements', $data) ? $demande->setEquipements($data['equipements']) : $demande->setEquipements(null);

        key_exists('protectionCouvreur', $data) ? $demande->setProtectionCouvreur($data['protectionCouvreur']) : $demande->setProtectionCouvreur(null);

        key_exists('largeurPassagePieton', $data) ? $demande->setLargeurPassagePieton($data['largeurPassagePieton']) : $demande->setLargeurPassagePieton(null);

        key_exists('acces', $data) ? $demande->setAcces($data['acces']) : $demande->setAcces(null);

        key_exists('bacheEtFilet', $data) ? $demande->setBacheEtFilet($data['bacheEtFilet']) : $demande->setBacheEtFilet(null);

        key_exists('bache', $data) ? $demande->setBache($data['bache']) : $demande->setBache(null);

        key_exists('dimensionsGlobales', $data) ? $demande->setDimensionsGlobales($data['dimensionsGlobales']) : $demande->setDimensionsGlobales(null);

        key_exists('porteeLibre', $data) ? $demande->setPorteeLibre(floatval($data['porteeLibre'])) : $demande->setPorteeLibre(null);

        key_exists('longueur', $data) ? $demande->setLongueur(floatval($data['porteeLibre'])) : $demande->setLongueur(null);

        key_exists('hauteur', $data) ? $demande->setHauteur($data['hauteur']) : $demande->setHauteur(null);

        key_exists('traitementDesPignons', $data) ? $demande->setTraitementDesPignons($data['traitementDesPignons']) : $demande->setTraitementDesPignons(null);

        key_exists('finitionPlancher', $data) ? $demande->setFinitionPlancher($data['finitionPlancher']) : $demande->setFinitionPlancher(null);

        key_exists('gcPeripherique', $data) ? $demande->setGcPeripherique($data['gcPeripherique']) : $demande->setGcPeripherique(null);

        key_exists('dimensions', $data) ? $demande->setDimensions($data['dimensions']) : $demande->setDimensions([]);


        //   dd($data['typeDePrestation']);


        // $demande->setDocumentsSouhaites($form->getData()['typeDePrestation']);

        $demandeRepository->add($demande);
        if (empty($demande->getReference())) {
            $demande->setReference(date('y') . date('m') . '-' . $demande->getId());
            $demandeRepository->add($demande);
        }

        return $this->redirectToRoute('app_demande_show', ['id' => $demande->getId()], Response::HTTP_SEE_OTHER);
    }
}
