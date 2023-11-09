<?php

namespace App\Controller\Affaire;

use App\Entity\Affaire\Metre;
use App\Repository\Affaire\MetreRepository;
use App\Repository\UniteRepository;
use Exception;
use App\Entity\Unite;
use Twig\Environment;
use App\Entity\Demande;
use App\Entity\Affaire\Lot;
use App\Service\PdfService;
use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Twig\Error\RuntimeError;
use App\Entity\Affaire\Devis;
use App\Service\CalculService;
use App\Entity\Affaire\Ouvrage;
use App\Form\Affaire\DevisType;
use App\Entity\Affaire\Composant;
use App\Repository\UserRepository;
use App\Entity\Affaire\TypeComposant;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\Affaire\LotRepository;
use Doctrine\ORM\OptimisticLockException;
use App\Repository\Affaire\DevisRepository;
use App\Repository\Affaire\OuvrageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\Affaire\ComposantRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Affaire\TypeComposantRepository;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/affaire/devis')]
class DevisController extends AbstractController
{

    private $environment;
    private $em;
    private $unites;

    private $pdfService;
    private $calculService;

    public function __construct(Environment $environment, EntityManagerInterface $entityManagerInterface, PdfService $pdfService, CalculService $calculService)
    {
        $this->environment = $environment;
        $this->em = $entityManagerInterface;
        $this->pdfService = $pdfService;
        $this->unites = $entityManagerInterface->getRepository(Unite::class)->findAll();
        $this->calculService = $calculService;

    }

    #[Route('/', name: 'app_affaire_devis_index', methods: ['GET'])]
    public function index(DevisRepository $devisRepository): Response
    {
        return $this->render('affaire/devis/index.html.twig', [
            'devis' => $devisRepository->findAll(),
            'title' => 'Liste des devis',
            'nav' => []
        ]);
    }

    #[Route('/new/{id}', name: 'app_affaire_devis_new', methods: ['GET', 'POST'])]
    public function new(Demande $demande, Request $request, DevisRepository $devisRepository, TypeComposantRepository $typeComposantRepository, LotRepository $lotRepository, OuvrageRepository $ouvrageRepository, UniteRepository $uniteRepository, MetreRepository $metreRepository): Response
    {


        $nom = $request->request->all()['devis']['nom'];
        $observations = '
    <u>Madame / Monsieur,&nbsp;</u><br>
    Veuillez trouver ci-joint notre offre de prix pour les travaux en &eacute;chafaudages concernant les lots : GO (&agrave; l&apos;avancement), RAVALEMENT, BARDAGE, CHARPENTE, COUVERTURE, ITE, &Eacute;TANCH&Eacute;IT&Eacute; &amp; SERRURERIE.&nbsp;<br>
    <u>Cette offre de prix tient compte des sp&eacute;cificit&eacute;s techniques que vous nous avez pr&eacute;cis&eacute;, &agrave; savoir :&nbsp;</u><br>
    - Sous r&eacute;serve : acc&egrave;s &agrave; pied d&apos;&oelig;uvre pour la manutention de nos palettes munis de roues.&nbsp;<br>
    - Mise en place de garde-corps de s&eacute;curit&eacute; d&eacute;finitive type MDS en face ext&eacute;rieur de l&apos;&eacute;chafaudage.&nbsp;<br>
    - La protection sous nos pieds d&apos;&eacute;chafaudages sera r&eacute;alis&eacute; par cales madriers de 22 x 50 cm&nbsp;<br>
    - Mise en place d&apos;un &eacute;chafaudage de 0,73m de large de type multidirectionnels.&nbsp;&nbsp;<br>
    - La fourniture des plans en 3D, PV de r&eacute;ception et bulletins d&apos;ad&eacute;quation&nbsp;<br>
    - Approvisionnement et replis du mat&eacute;riel &agrave; l&apos;aide de la grue G.O&nbsp;<br>
    - Suivant hauteur du terrain naturelle indiqu&eacute; sur les plans architecte&nbsp;<br>
    - Dur&eacute;e de location calendaire suivant tableau page 2&nbsp;<br>
    - Contournement des balcons&nbsp;<br>
    - Echafaudages au droit des lucarnes.&nbsp;<br>
    - Sous r&eacute;serve : visite sur chantier&nbsp;<br>
    <u>Non compris &agrave; la pr&eacute;sente :&nbsp;</u><br>
    - Insertion sociale&nbsp;<br>
    - Frais de grue&nbsp;<br>
    - Compte prorata&nbsp;<br>
    - Consoles int&eacute;rieures.&nbsp;<br>
    - Garde-corps en face int&eacute;rieur de l&apos;&eacute;chafaudage.&nbsp;<br>
    - Echafaudages des joues des lucarnes.&nbsp;<br>
    - La d&eacute;pose de l&apos;&eacute;chafaudage pour permettre les travaux d&apos;&eacute;tanch&eacute;it&eacute;&nbsp;<br>
    - La mise en place d&apos;&eacute;chafaudages int&eacute;rieurs sur terrasses techniques&nbsp;<br>
    - Echafaudage au pourtour des chemin&eacute;es.&nbsp;<br>
    - La protection des fils &eacute;lectrique avant notre intervention.&nbsp;<br>
    - Mise &agrave; la terre de l&apos;&eacute;chafaudage.&nbsp;<br>
    - Palissade de cl&ocirc;ture de chantier.&nbsp;<br>
    - Murs de refends, &eacute;chafaudages int&eacute;rieurs, vides sur s&eacute;jours, etc...&nbsp;<br>
    - La protection &eacute;tanche des planchers de travail.&nbsp;<br>
    - Pignons interm&eacute;diaires entre b&acirc;timents et maisons ou cages.&nbsp;<br>
    - Filets pare gravats et filets de protections couvreur (option)&nbsp;<br>
    - Pare-gravois et b&acirc;ches anti-UV&nbsp;<br>
    - Protection des ouvrages existants.&nbsp;<br>
    - Recette &agrave; mat&eacute;riaux &amp; Escalier d&apos;acc&egrave;s (option)&nbsp;<br>
    - Manutention des &eacute;chafaudages apr&egrave;s d&eacute;montage de la grue (Option)&nbsp;<br>
    - Rebouchage des trous des ancrages lors de notre d&eacute;pose de l&apos;&eacute;chafaudage.&nbsp;<br>
    - Gardiennage, entretien du mat&eacute;riel et droit de voirie, durant toute la dur&eacute;e du chantier.&nbsp;<br>
    - Demande empi&eacute;tement chez voisins &agrave; la charge du client ainsi que la r&eacute;alisation des protocoles d&apos;accord&nbsp;<br>
    - La protection compl&egrave;te des terrasses &eacute;tanch&eacute;s avant la mise en place de nos &eacute;chafaudages&nbsp;<br>
    - Autorisations, frais de voierie et administratives ou priv&eacute;es, avec stockage 3,00m x 15,00m accessible &agrave; nos camions sur la voie publique.&nbsp;<br>
    - Surfaces d&apos;appuis : Contr&ocirc;les des natures des sols et des toitures pour l&apos;implantation de l&apos;&eacute;chafaudage suivant les descentes de charge par pied.&nbsp;<br>
    - D&eacute;pollution d&apos;&eacute;chafaudages en fin de chantier (&agrave; la charge du client)&nbsp;<br>
    <u>Nota :&nbsp;</u><br>
    - Dans le cas o&ugrave; l&apos;&eacute;chafaudage devrait &ecirc;tre d&eacute;mont&eacute; &agrave; une date pr&eacute;cise indiqu&eacute; par le Maitre d&apos;&OElig;uvre/d&apos;Ouvrage et que cette t&acirc;che n&apos;est pas possible car des travaux ne seraient pas termin&eacute;s ou que le ravaleur n&apos;est pas pr&eacute;sent sur site pour reboucher les trous d&apos;amarrage, le Maitre d&apos;&OElig;uvre/Maitre d&apos;Ouvrage/Pilote peut demander par &eacute;crit &agrave; J4R de ne pas d&eacute;monter l&apos;&eacute;chafaudage. J4R sera en droit de facturer au tarif de 900 &euro;HT des frais de d&eacute;placement par intervention annul&eacute;.&nbsp;<br>
    - Sur les chantiers de courte dur&eacute;e et sans pr&eacute;sence de base vie, il est imp&eacute;ratif la mise &agrave; disposition d&apos;un local ou d&apos;un v&eacute;hicule de chantier disposant &agrave; minima d&apos;un coin vestiaire chauff&eacute;, un WC et d&apos;un micro-ondes (article 4228 du code du travail)&nbsp;<br>
    - Les plans d&apos;&eacute;chafaudages seront remis un mois avant notre intervention sur le lot ou la phase concern&eacute;e pour validation du Ma&icirc;tre d&apos;ouvrage/Ma&icirc;tre d&apos;&OElig;uvre/Pilote et entreprises utilisatrices.&nbsp;<br>
    - Le Client assure tous les risques de d&eacute;t&eacute;rioration et de perte partielle ou totale du mat&eacute;riel, quelle qu&rsquo;en soit la cause. Le client entend express&eacute;ment renoncer &agrave; invoquer la force majeure et plus g&eacute;n&eacute;ralement aux dispositions de l&rsquo;article 1218 du Code Civil. Le mat&eacute;riel d&eacute;t&eacute;rior&eacute; ou perdu sera factur&eacute; au Client au prix en vigueur le jour o&ugrave; le mat&eacute;riel aurait d&ucirc; &ecirc;tre rendu. Il appartiendra au client de s&rsquo;assurer pour tous les risques pouvant survenir aux personnes et au mat&eacute;riel, y compris pour le transport du mat&eacute;riel, aupr&egrave;s d&rsquo;une compagnie notoirement connue. Il reste &eacute;galement responsable du remboursement du mat&eacute;riel vol&eacute; sur son chantier ou sur les emprises au sol pour le stockage. La liste du mat&eacute;riel entrant et sortant du chantier est &agrave; la disposition du client sur demande.&nbsp;<br>
    - En cas de suspicion de contamination au Plomb ou &agrave; l&apos;Amiante de l&apos;&eacute;chafaudage pendant la dur&eacute;e du chantier, un test &agrave; la linguette &agrave; la charge du client peut &ecirc;tre exig&eacute; par J4R avant la d&eacute;pose.&nbsp;<br>
    - A noter que la dur&eacute;e d&apos;immobilisation de l&apos;&eacute;chafaudage entre la d&eacute;pollution et la d&eacute;pose est &agrave; la charge du client&nbsp;&nbsp;<br>
    - Tous frais de d&eacute;pollution et/ou de mise au rebu des &eacute;l&eacute;ments non&nbsp;d&eacute;polluables&nbsp;seront factur&eacute;s&nbsp;<br>
    - Le remblais compact&eacute; au pourtour de l&apos;&eacute;difice &agrave; &eacute;chafauder est obligatoire avant notre intervention&nbsp;&nbsp;<br>
    - Aucun remontage sans devis sign&eacute; sera fait apr&egrave;s validation des plans&nbsp;<br>
    - Aucune d&eacute;pose de l&apos;&eacute;chafaudage ne sera faite pour l&apos;&eacute;tanch&eacute;it&eacute;&nbsp;&nbsp;<br>
    - Un seul montage est pr&eacute;vu &agrave; cette offre&nbsp;<br>
    - Les sur locations &eacute;ventuelles sont &agrave; r&eacute;gler sur la situation du mois en cours.&nbsp;<br>
    - Les dur&eacute;es de location n&apos;incluent pas les journ&eacute;es d&apos;intemp&eacute;ries, arr&ecirc;t de chantier, retard, etc...&nbsp;<br>
    - Les dur&eacute;es de location inf&eacute;rieures &agrave; la dur&eacute;e contractuelle sont indivisibles.&nbsp;<br>
    - Toute modification de l&apos;&eacute;chafaudage apr&egrave;s validation des plans et du montage fera l&apos;objet d&apos;un devis compl&eacute;mentaire&nbsp;<br>
    - Les locations d&eacute;marrent &agrave; compter de la mise en s&eacute;curit&eacute; de l&apos;&eacute;difice ou de la phase suivant d&eacute;composition en page 2 de notre devis&nbsp;<br>
    - 100,00 &euro; H.T par heure en &eacute;quipe de deux pour intervention en reprise, remontage, modification d&apos;&eacute;chafaudage&nbsp;&nbsp;<br>
    - Co&ucirc;t de remplacement des pi&egrave;ces suivant tarif du catalogue de notre fournisseur&nbsp;Layher.&nbsp;<br>
    - Travaux suppl&eacute;mentaires pouvant faire l&apos;objet d&apos;un TS.&nbsp;<br>
    - Les d&eacute;montages partiels non pr&eacute;vus dans le devis seront en suppl&eacute;ment ainsi que les transports&nbsp;<br>
    - En cas de non-accessibilit&eacute; ou de retard dans le planning chantier, des frais d&apos;approvisionnement ou de repli &agrave; la grue mobile seront factur&eacute;s&nbsp;<br>
    - J4R se r&eacute;serve le droit de sous-traiter tout ou partie des travaux de montage et d&eacute;montage de l&apos;&eacute;chafaudage.&nbsp;<br>
    - La r&eacute;ception des &eacute;chafaudages et l&apos;&eacute;tablissement d&apos;un PV de r&eacute;ception sera r&eacute;alis&eacute; par J4R.&nbsp;<br>
    - Un planning sign&eacute; par l&apos;ensemble des corps d&apos;&eacute;tats devra &ecirc;tre fourni avant le d&eacute;marrage de notre intervention.&nbsp;<br>
    - En l&rsquo;absence d&rsquo;ouvrages restants, aucune retenue de garantie ne doit &ecirc;tre envisag&eacute;e&nbsp;<br>
    - Le pr&eacute;sent march&eacute; porte sur les travaux tels que d&eacute;finis &agrave; la date du pr&eacute;sent devis&nbsp;<br>
    <strong>Offre valable 2 mois&nbsp;</strong><br>
';

        $devis = new Devis();
        $devis->setTitre($nom);
        $devis->setDemande($demande);
        $devis->setCreateur($this->getUser());
        $devis->setFraisGeneraux(1);
        $devis->setMargeBeneficiaire(1);
        $devis->setObservations($observations);

        //Crée un lot directement dans un nouveau devis
        $lot = $this->initialiseLot($devis, $uniteRepository, $lotRepository);

        //Crée un ouvrage et ses composants dans le lot précédemment initialisé
        $this->initialiseOuvrage($devis, $lot, $ouvrageRepository, $typeComposantRepository, $lotRepository, $uniteRepository, $metreRepository);

        $devisRepository->add($devis);
        return $this->redirectToRoute('app_affaire_devis_edit', ['id' => $devis->getId()], Response::HTTP_SEE_OTHER);

    }

    public function initialiseLot(Devis $devis, UniteRepository $uniteRepository, LotRepository $lotRepository)
    {
        // Crée un lot et l'ajoute au devis
        $lot = new Lot();
        $lot->setMarge($devis->getMarge());
        $uniteM2 = $uniteRepository->findOneByLabel('m2');
        $lot->setUnite($uniteM2);
        $elements = empty($devis->getElements()) ? [] : $devis->getElements();
        $lotRepository->save($lot);
        $el = ['id' => $lot->getId(), 'type' => 'lot', 'data' => []];
        $elements[] = $el;
        $devis->addLot($lot);
        $devis->setElements($elements);

        return $lot;
    }

    public function initialiseOuvrage(Devis $devis, Lot $lot, OuvrageRepository $ouvrageRepository, TypeComposantRepository $typeComposantRepository, LotRepository $lotRepository, UniteRepository $uniteRepository, MetreRepository $metreRepository)
    {
        $ouvrage = new Ouvrage();
        $ouvrage->setMarge($devis->getMarge());
        $ouvrage->setCreateur($this->getUser());
        $ouvrage->setUnite($lot->getUnite());
        $ouvrage->setUnite($uniteRepository->findOneByLabel('m2'));
        $ouvrage->setStatut('Copie');
        $parentId = $lot->getId();
        $elements = $devis->getElements();
        $this->em->persist($ouvrage);

        // Création des linéaires et hauteurs
        $lineaires = [];
        $hauteurs = [];
        for ($i = 0; $i < 15; $i++) {
            $lineaire = new Metre();
            $lineaire->setOuvrage($ouvrage);
            $lineaire->setTypeMetre('lineaire');
            $ouvrage->addMetre($lineaire);
            $lineaires[] = $lineaire;

            $hauteur = new Metre();
            $hauteur->setOuvrage($ouvrage);
            $hauteur->setTypeMetre('hauteur');
            $ouvrage->addMetre($hauteur);
            if ($i === 0) {
                $hauteur->setHauteur(1);
            } elseif ($i === 1) {
                $hauteur->setHauteur(4.5);
            } elseif ($i === 2) {
                $hauteur->setHauteur(2.8);
            } elseif ($i === 3) {
                $hauteur->setHauteur(3.8);
            }
            $hauteurs[] = $hauteur;
        }

        foreach ($hauteurs as $hauteur) {
            foreach ($lineaires as $lineaire) {
                // Création de la longueur commune
                $longueur = new Metre();

                $longueur->setTypeMetre('longueur');
                $longueur->setLongueurLineaire($lineaire);
                $longueur->setLongueurHauteur($hauteur);

                $metreRepository->save($lineaire);
                $metreRepository->save($hauteur);
                $metreRepository->save($longueur);
            }
        }

        $typeComposants = $typeComposantRepository->findAll();
        $data = [];
        foreach ($typeComposants as $typeComposant) {
            $composant = new Composant();
            $composant->setUnite($uniteRepository->findOneByLabel('m2'));
            $composant->setTypeComposant($typeComposant);
            $composant->setDenomination($typeComposant->getTitre());
            if ($typeComposant->getCode() === "L") {
                $composant->setQuantite2(1);
                $composant->setUnite2($uniteRepository->findOneByLabel('J'));
            }
            if ($typeComposant->getCode() === "MA" || $typeComposant->getCode() === "MR") {
                $composant->setSelection(false);
            } else {
                $composant->setSelection(true);
            }
            $composant->setMarge($devis->getMarge());
            $composant->setStatut('copie');
            $this->em->persist($composant);
            $ouvrage->addComposant($composant);
            $this->em->flush();
            $data[] = [
                'id' => $composant->getId(),
                'type' => 'composant',
                'data' => [],
                'origine' => null,
            ];
        }

        $element = [
            'id' => $ouvrage->getId(),
            'type' => 'ouvrage',
            'data' => $data,
        ];
        $ouvrageRepository->add($ouvrage);

        if (!empty($parentId)) {
            $parent = [];
            $parent['id'] = $parentId;
            $parent['type'] = 'lot';
            $elements = $this->setParent($elements, $element, $parent);
            $this->em->persist($devis);
            $lot->addOuvrage($ouvrage);
            $lotRepository->add($lot);
        } else {
            $elements[] = $element;
            $devis->addOuvrage($ouvrage);
        }
        $devis->setElements($elements);
    }

    #[Route('/{id}', name: 'app_affaire_devis_show', methods: ['GET'])]
    public function show(Devis $devis, Request $request, UserRepository $userRepository): Response
    {
        $data = $request->query->all();
        $referer = $request->headers->get('referer');

        /*$form = $this->createForm(DevisType::class, $devis);
        $form->handleRequest($request);*/

        $users = $userRepository->findAll();

        return $this->render('affaire/devis/show.html.twig', [
            'devis' => $devis,
            'title' => 'Devis N° ' . $devis->getId(),
            'users' => $users,
            //'form' => $form->createView(),
            'referer' => $referer,
            'nav' => []
        ]);
    }


    public function recursiveElements($elements, $parent = null): string
    {
        $html = "";
        $options = [];
        //dd($elements);

        foreach ($elements as $key => $element) {
            $path = "affaire/devis/" . $element['type'] . ".html.twig";
            if ($element['type'] == 'ouvrage') {
                $entity = $this->em->getRepository(Ouvrage::class)->find($element['id']);
                $options = $this->em->getRepository(Ouvrage::class)->findByStatut(null);
            } elseif ($element['type'] == 'lot') {
                $entity = $this->em->getRepository(Lot::class)->find($element['id']);
            } elseif ($element['type'] == 'composant') {
                $entity = $this->em->getRepository(Composant::class)->find($element['id']);
                if (!empty($element['origine'])) {
                    $options = $this->em->getRepository(Composant::class)->findComposantsByOuvrageId($element['origine']);

                } else {
                    $options = [];
                }
                // dd($options,$origine,$parent);
            }
            try {
                $htmlTMP = $this->environment->render($path, [$element['type'] => $entity, 'hasChild' => !empty($element['data']), 'key' => $key, 'hasParent' => $parent, 'options' => $options, 'unites' => $this->unites]);

                if (!empty($element['data'])) {
                    if ($element['type'] == 'lot') {
                        $htmlTMP = "<li>" . $htmlTMP . "<ul class='children' id='" . $element['type'] . "-ul-" . $element['id'] . "'>";
                        $htmlTMP .= $this->recursiveElements($element['data'], $element['id']);
                        $htmlTMP .= "</ul>";
                    } elseif ($element['type'] == 'ouvrage') {
                        $htmlTMP = "<li>" . $htmlTMP . "<ul class='children ouvrage-children' id='" . $element['type'] . "-ul-" . $element['id'] . "'>";
                        $htmlTMP .= $this->recursiveElements($element['data'], $element['id']);
                        $htmlTMP .= "</ul>";
                    }
                    $htmlTMP .= "</li>";
                    $html .= $htmlTMP;
                } elseif ($element['type'] != 'composant') {
                    $htmlTMP = "<li>" . $htmlTMP . "<ul class='children' id='" . $element['type'] . "-ul-" . $element['id'] . "'></ul></li>";
                    $html .= $htmlTMP;
                } else {
                    $html .= $htmlTMP;
                }
            } catch (LoaderError $e) {
                dd($e);
            } catch (RuntimeError $e) {
                dd($e);
            } catch (SyntaxError $e) {
                dd($e);
            }
        }
        return $html;


    }

    #[Route('/{id}/edit', name: 'app_affaire_devis_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Devis $devis, DevisRepository $devisRepository, UserRepository $userRepository): Response
    {

    //  dump($devis->getElements());
        $form = $this->createForm(DevisType::class, $devis);
        $form->handleRequest($request);

        $users = $userRepository->findAll();

        $referer = $request->headers->get('referer');
        if ($form->isSubmitted() && $form->isValid()) {
            $devisRepository->add($devis);
            return $this->redirectToRoute('app_affaire_devis_show', ['id' => $devis->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/devis/new.html.twig', [
            'devis' => $devis,
            'form' => $form,
            'users' => $users,
            'referer' => $referer,
            'demande' => $devis->getDemande(),
            'html' => $this->recursiveElements(!empty($devis->getElements()) ? $devis->getElements() : []),
            'title' => "Création d'un devis - " . $devis->getTitre() . " " . $devis->getId(),
            'nav' => []
        ]);
    }

    #[Route('/calcul/edit/{id}', name: 'app_affaire_devis_calcul_edit', methods: ['GET', 'POST'])]
    public function editCalcul(Request $request, Devis $devis, DevisRepository $devisRepository): Response
    {

        $data = $request->request->all();
        $data = $data['devis'];
        $devis->setMarge($data['marge']);
        try {

            $devisRepository->add($devis);
            $data = $this->calculService->recursiveCalculBottom(['id' => $devis->getId(), 'type' => 'devis']);
            $data[] = $devis->__toArray();

            return new Response(json_encode(['code' => 200, 'data' => $data]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (Exception $e) {
            dd($e);
        }


        return new Response(json_encode(['code' => 404]));

    }

    #[Route('/user/import/{id}', name: 'app_affaire_referent_import', methods: ['GET', 'POST'])]
    public function importReferent(Request $request, Devis $devis, DevisRepository $devisRepository, UserRepository $userRepository): Response
    {

        $data = $request->request->all();
        //dd($data);
        $referents = [];


        foreach ($data as $val) {

            $user = $userRepository->find($val['id']);
            $us = ['id' => $user->getId(), 'nom' => $user->getLastname(), 'prenom' => $user->getFirstname()];
            $referents[] = $us;
            $devis->addReferent($user);
        }

        try {
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200, "referents" => $referents]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (Exception $e) {
            dd($e);
        }

        return new Response(json_encode(['code' => 404]));
    }

    #[Route('/user/delete/{id}', name: 'app_affaire_referent_delete', methods: ['GET', 'POST'])]
    public function deleteReferent(Request $request, Devis $devis, DevisRepository $devisRepository, UserRepository $userRepository): Response
    {

        $data = $request->request->all();
        //dd($data);

        $user = $userRepository->find($data['id']);

        try {
            $devis->removeReferent($user);
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200, 'idReferent' => $user->getId()]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (Exception $e) {
            dd($e);
        }

        return new Response(json_encode(['code' => 404]));
    }


    public function setParent($elements, $el, $parent)
    {
        foreach ($elements as &$element) {
            //dd($parent,$element['data']);
            if ($element['id'] == $parent['id'] && $element['type'] == $parent['type']) {
                $element['data'][] = $el;
            } elseif (!empty($element['data'])) {
                $element['data'] = $this->setParent($element['data'], $el, $parent);
            }
        }
        return $elements;
    }

    #[Route('/ouvrage/import/{id}', name: 'app_affaire_ouvrage_import', methods: ['POST'])]
    public function importOuvrage(Request $request, Environment $environment, EntityManagerInterface $entityManager, OuvrageRepository $ouvrageRepository, LotRepository $lotRepository, Devis $devis, DevisRepository $devisRepository): Response
    {

        $path = "affaire/devis/ouvrage.html.twig";

        $data = $request->request->all();
        //dd($data);


        $sum = 0;

        $ouvrages = [];
        $html = "";

        $elements = empty($devis->getElements()) ? [] : $devis->getElements();


        foreach ($data as $val) {

            $ouvrage = $ouvrageRepository->find($val['id']);
            $clone = $ouvrage;

            $clone->setStatut('Copie');
            $clone->setCreateur($this->getUser());
            foreach ($ouvrage->getComposants() as $composant) {
                $entityManager->detach($clone);
                $clone->addComposant($composant);
                $composant->setOuvrage($clone);
            }
            $entityManager->detach($clone);
            $ouvrageRepository->add($clone);

            $el = ['id' => $clone->getId(), 'type' => 'ouvrage', 'data' => []];

            $parent = [];
            if (!empty($val['parentId']) and !empty($val['parentType'])) {
                $parent['id'] = $val['parentId'];
                $parent['type'] = $val['parentType'];
                $elements = $this->setParent($elements, $el, $parent);
            } else {
                $elements[] = $el;
            }

            try {
                $this->getPrix($elements, $ouvrageRepository, $lotRepository);
                $devis->setElements($elements);
                $html .= $environment->render($path, ["ouvrage" => $clone, 'hasParent' => $val['parentId'], 'unites' => $this->unites]);
            } catch (LoaderError $e) {
                dd($e);
            } catch (RuntimeError $e) {
                dd($e);
            } catch (SyntaxError $e) {
                dd($e);
            }
        }


        try {
            $devis->setElements($elements);
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200, "html" => $html]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (Exception $e) {
            dd($e);
        }

        return new Response(json_encode(['code' => 404]));
    }


    #[Route('/modal/title/{id}', name: 'app_affaire_devis_modal_titre', methods: ['GET', 'POST'])]
    public function getModal(Request $request, Demande $demande, Environment $environment): Response
    {

        $response = new Response();

        $path = "affaire/devis/modal_titre.html.twig";

        if (!empty($path)) {

            try {
                $html = $environment->render($path, ['demande' => $demande, 'unites' => $this->unites]);
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

    #[Route('/lot/{id}', name: 'app_affaire_lot_new', methods: ['GET', 'POST'])]
    public function newLot(Request $request, Environment $environment, LotRepository $lotRepository, Devis $devis, DevisRepository $devisRepository, UniteRepository $uniteRepository): Response
    {
        $path = "affaire/devis/lot.html.twig";

        $data = $request->request->all();
        //dd($data);

        $lot = new Lot();
        $lot->setMarge(1.4);

        $uniteM2 = $uniteRepository->findOneByLabel('m2');
        $lot->setUnite($uniteM2);
        $html = "";

        $elements = empty($devis->getElements()) ? [] : $devis->getElements();

        try {
            $lotRepository->save($lot);
            $el = ['id' => $lot->getId(), 'type' => 'lot', 'data' => []];
            if (!empty($data['parentId']) and !empty($data['parentType'])) {
                $parent['id'] = $data['parentId'];
                $parent['type'] = $data['parentType'];
                $elements = $this->setParent($elements, $el, $parent);
                $lotParent = $lotRepository->find($data['parentId']);
                $lotParent->addSousLot($lot);
                $lotRepository->add($lotParent);

            } else {
                $elements[] = $el;
                $devis->addLot($lot);
            }
            $devis->setElements($elements);
            $html .= $environment->render($path, ["lot" => $lot, 'hasParent' => $data['parentId'], 'unites' => $this->unites]);
            $html = "<li>" . $html . "<ul class='children' id='lot-ul-" . $lot->getId() . "'></ul></li>";
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200, "html" => $html]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (\Exception $e) {
            dd($e);
        }

        return new Response(json_encode(['code' => 404]));

    }

    public function cloneElement($id, $type, LotRepository $lotRepository, OuvrageRepository $ouvrageRepository, ComposantRepository $composantRepository, $parent = null): array
    {

        if ($type == 'lot') {
            $lot = $lotRepository->find($id);
            $dupliquer = new Lot();
            $dupliquer->setDenomination($lot->getDenomination());
            $dupliquer->setCode($lot->getCode());
            $dupliquer->setDevis($lot->getDevis());
            $dupliquer->setUnite($lot->getUnite());
            $dupliquer->setDebourseTotalLot($lot->getDebourseTotalLot());
            $dupliquer->setPrixDeVenteHT($lot->getPrixDeVenteHT());
            $dupliquer->setQuantite($lot->getQuantite());
            $dupliquer->setMarge($lot->getMarge());
            $lotRepository->save($dupliquer);

            return ['id' => $dupliquer->getId(), 'type' => $type, "data" => []];
        } elseif ($type == "ouvrage") {
            $ouvrage = $ouvrageRepository->find($id);
            $dupliquer = new Ouvrage();
            $dupliquer->setDenomination($ouvrage->getDenomination());
            if ($parent != null) {
                $lot = $lotRepository->find($parent['id']);
                $dupliquer->setLot($lot);
            } else {
                $dupliquer->setLot($ouvrage->getLot());
            }
            $dupliquer->setStatut($ouvrage->getStatut());
            $dupliquer->setCode($ouvrage->getCode());
            $dupliquer->setUnite($ouvrage->getUnite());
            $dupliquer->setCreateur($this->getUser());
            $dupliquer->setOrigine($ouvrage->getOrigine());
            $dupliquer->setAttributs($ouvrage->getAttributs());
            $dupliquer->setTypeOuvrage($ouvrage->getTypeOuvrage());
            $dupliquer->setPoidsDeReference($ouvrage->getPoidsDeReference());
            $dupliquer->setTpsDeReference($ouvrage->getTpsDeReference());
            $dupliquer->setPourcentageTpsDeReference($ouvrage->getPourcentageTpsDeReference());
            $dupliquer->setPrixUnitaireDebourse(($ouvrage->getPrixUnitaireDebourse()) ? $ouvrage->getPrixUnitaireDebourse() : 0);
            $dupliquer->setMarge($ouvrage->getMarge());
            $dupliquer->setQuantite($ouvrage->getQuantite());
            $dupliquer->setDebourseHTCalcule(($ouvrage->getDebourseHTCalcule()) ? $ouvrage->getDebourseHTCalcule() : 0);
            $dupliquer->setPrixDeVenteHT($ouvrage->getPrixDeVenteHT());
            $dupliquer->setLargeur($ouvrage->getQuantite());
            $ouvrageRepository->save($dupliquer);

            $element = ['id' => $dupliquer->getId(), 'type' => $type, "data" => []];

            foreach ($ouvrage->getMetres() as $metre) {
                $metreDupliquer = new Metre();
                $metreDupliquer->setOuvrage($metre->getOuvrage());
                $metreDupliquer->setTypeMetre($metre->getTypeMetre());
                switch ($metre->getTypeMetre()) {
                    case 'hauteur' :
                        $metreDupliquer->setHauteur($metre->getHauteur());
                        break;

                    case 'lineaire' :
                        $metreDupliquer->setLineaire($metre->getLineaire());
                        foreach ($metre->getLongueursLineaire() as $longueur) {
                            $longueurDupliquer = new Metre();

                            $longueur->setTypeMetre($longueur->getTypeMetre());
                            $longueurDupliquer->setLongueur($longueur->getLongueur());
                            $longueurDupliquer->setLongueurHauteur($longueur->getLongueurHauteur());
                            $longueurDupliquer->setLongueurLineaire($longueur->getLongueurLineaire());
                        }
                        break;

                    default :
                        break;
                }
            }

            foreach ($ouvrage->getComposants() as $composant) {
                $composantDupliquer = new Composant();
                $composantDupliquer->setDenomination($composant->getDenomination());
                $composantDupliquer->setTypeComposant($composant->getTypeComposant());
                if (!empty($composantDupliquer->getTypeComposant()) && $composantDupliquer->getTypeComposant()->getCode() === "L") {
                    $composantDupliquer->setQuantite2($composant->getQuantite2());
                    $composantDupliquer->setUnite2($composant->getUnite2());
                }
                $composantDupliquer->setUnite($composant->getUnite());
                $composantDupliquer->setStatut($composant->getStatut());
                $composantDupliquer->setDebourseUnitaireHT($composant->getDebourseUnitaireHT());
                $composantDupliquer->setMarge($composant->getMarge());
                $composantDupliquer->setQuantite($composant->getQuantite());
                $composantDupliquer->setDebourseTotalHT($composant->getDebourseTotalHT());
                $composantDupliquer->setPrixDeVenteHT($composant->getPrixDeVenteHT());
                $composantDupliquer->setOuvrage($dupliquer);
                $composantDupliquer->setSelection($composant->isSelection());
                $composantRepository->add($composantDupliquer);

                $element['data'][] = ['id' => $composantDupliquer->getId(), 'type' => 'composant', "data" => [], 'origine' => null];
            }

            return $element;
        }

        return false;
    }

    public function findElement($elements, $data, $lotRepository, $ouvrageRepository, $composantRepository)
    {
        foreach ($elements as $element) {
            if ($element['id'] == $data['id'] && $element['type'] == $data['type']) {
                $dupliquer = $this->cloneElement($data['id'], $data['type'], $lotRepository, $ouvrageRepository, $composantRepository);
                if ($data['type'] == 'lot') {
                    $path = "affaire/devis/lot.html.twig";
                    if (!empty($element['data'])) {
                        foreach ($element['data'] as $el) {
                            $dupliquer['data'][] = $this->cloneElement($el['id'], $el['type'], $lotRepository, $ouvrageRepository, $composantRepository, $dupliquer);
                        }
                    }
                }
                return $dupliquer;
            } else if (!empty($element['data'])) {
                $dupliquer = $this->findElement($element['data'], $data, $lotRepository, $ouvrageRepository, $composantRepository);
                if ($dupliquer) {
                    return $dupliquer;
                }
            }
        }
    }


    #[Route('/ouvrage/origine/add/{devis}/{id}/{origine}', name: 'app_affaire_devis_ouvrage_add_origine', methods: ['GET', 'POST'])]
    public function addOrigineToOuvrage(Devis $devis, Ouvrage $ouvrage, Ouvrage $origine, OuvrageRepository $ouvrageRepository, EntityManagerInterface $entityManager): Response
    {
        $ouvrage->setOrigine($origine->getId());
        $ouvrage->setDenomination($origine->getDenomination());
        $ouvrage->setCode($origine->getCode());
        $ouvrage->setUnite($origine->getUnite());
        $ouvrage->setCreateur($this->getUser());
        $ouvrage->setNote($origine->getNote());
        $ouvrage->setTypeDOuvrage($origine->getTypeDOuvrage());
        $ouvrage->setQuantite($origine->getQuantite());

        $elements = $devis->getElements();
        $parent = [
            'id' => $ouvrage->getId(),
            'type' => 'ouvrage',
            'data' => [],
        ];
        $html = "";
        foreach ($origine->getComposants() as $composant) {
            $clone = $composant;
            $clone->setCreateur($this->getUser());
            $clone->setStatut('Copie');
            $entityManager->detach($clone);
            $entityManager->getRepository(Composant::class)->add($clone);
            $clone->setOuvrage($ouvrage);
            $ouvrage->addComposant($clone);
            $entityManager->getRepository(Composant::class)->add($clone);

            $element = [
                'id' => $clone->getId(),
                'type' => 'composant',
                'data' => [],
                'origine' => $ouvrage->getId(),
            ];
            $elements = $this->setParent($elements, $element, $parent);
            $html .= $this->recursiveElements([$element], $ouvrage->getId());

        }
        $entityManager->getRepository(Ouvrage::class)->add($ouvrage);

        $ouvrage->setPrixDeVenteHT($ouvrage->getSommePrixDeVenteHTComposants());
        $ouvrage->setMarge($ouvrage->getSommePrixDeVenteHTComposants() / $ouvrage->getSommeDebourseTotalComposants());

        $devis->setElements($elements);

        try {
            //  $entityManager->getRepository(Devis::class)->add($devis);
            $data = $this->calculService->recursiveCalculTop(['id' => $ouvrage->getId(), 'type' => 'ouvrage']);
            $ouvrageRepository->save($ouvrage);

            $data[] = $ouvrage->__toArray();
            return new Response(json_encode(['code' => 200, 'data' => $data, 'html' => $html]));

        } catch (\Exception $e) {
            dd($e);
        }

    }


    #[Route('/ouvrage/new/{id}/{parentId}', name: 'app_affaire_devis_ouvrage_new', methods: ['GET', 'POST'])]
    public function newOuvrage(Devis $devis, $parentId = null, Request $request, Environment $environment, LotRepository $lotRepository, DevisRepository $devisRepository, OuvrageRepository $ouvrageRepository, TypeComposantRepository $typeComposantRepository, UniteRepository $uniteRepository, MetreRepository $metreRepository): Response
    {


        $ouvrage = new Ouvrage();
        if (!empty($parentId)) {
            $lot = $lotRepository->find($parentId);
            $ouvrage->setMarge($lot->getMarge());
        } else {
            $ouvrage->setMarge($devis->getMarge());
        }
        $ouvrage->setCreateur($this->getUser());
        $ouvrage->setUnite($uniteRepository->findOneByLabel('m2'));
        $ouvrage->setStatut('Copie');
        $elements = $devis->getElements();
        $this->em->persist($ouvrage);

        // Création des linéaires et hauteurs
        $lineaires = [];
        $hauteurs = [];
        for ($i = 0; $i < 15; $i++) {
            $lineaire = new Metre();
            $lineaire->setTypeMetre('lineaire');
            $ouvrage->addMetre($lineaire);
            $lineaires[] = $lineaire;

            $hauteur = new Metre();
            $hauteur->setTypeMetre('hauteur');
            $ouvrage->addMetre($hauteur);
            if ($i === 0) {
                $hauteur->setHauteur(1);
            } elseif ($i === 1) {
                $hauteur->setHauteur(4.5);
            } elseif ($i === 2) {
                $hauteur->setHauteur(2.8);
            } elseif ($i === 3) {
                $hauteur->setHauteur(3.8);
            }
            $hauteurs[] = $hauteur;
        }

        foreach ($hauteurs as $hauteur) {
            foreach ($lineaires as $lineaire) {
                // Création de la longueur commune
                $longueur = new Metre();

                $longueur->setTypeMetre('longueur');
                $longueur->setLongueurLineaire($lineaire);
                $longueur->setLongueurHauteur($hauteur);

                $metreRepository->save($lineaire);
                $metreRepository->save($hauteur);
                $metreRepository->save($longueur);
            }
        }


        $typeComposants = $typeComposantRepository->findAll();
        $data = [];
        foreach ($typeComposants as $typeComposant) {
            $composant = new Composant();
            $composant->setUnite($uniteRepository->findOneByLabel('m2'));
            if ($typeComposant->getCode() === "L") {
                $composant->setQuantite2(1);
                $composant->setUnite2($uniteRepository->findOneByLabel('J'));
            }
            if ($typeComposant->getCode() === "MA" || $typeComposant->getCode() === "MR") {
                $composant->setSelection(false);
            } else {
                $composant->setSelection(true);
            }
            $composant->setTypeComposant($typeComposant);
            $composant->setDenomination($typeComposant->getTitre());
            if ($composant->getDenomination() == "Location") {
                $composant->setQuantite2(1);
            }
            $composant->setMarge($ouvrage->getMarge());
            $composant->setStatut('copie');
            $this->em->persist($composant);
            $ouvrage->addComposant($composant);
            $this->em->flush();
            $data[] = [
                'id' => $composant->getId(),
                'type' => 'composant',
                'data' => [],
                'origine' => null,
            ];
        }

        try {
            $element = [
                'id' => $ouvrage->getId(),
                'type' => 'ouvrage',
                'data' => $data,
            ];
            $html = $this->recursiveElements([$element], $parentId);
            $ouvrageRepository->add($ouvrage);

            if (!empty($parentId)) {
                $parent = [];
                $parent['id'] = $parentId;
                $parent['type'] = 'lot';
                $elements = $this->setParent($elements, $element, $parent);
                $lot->addOuvrage($ouvrage);
                $lotRepository->add($lot);
                $ouvrage->setUnite($ouvrage->getLot()->getUnite());
            } else {
                $elements[] = $element;
                $devis->addOuvrage($ouvrage);
            }
            $devis->setElements($elements);
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200, "html" => $html, 'idParent' => $parentId, 'id' => $ouvrage->getId()]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (Exception $e) {
            dd($e);
        }


        return new Response(json_encode(['code' => 404]));
    }

    #[Route('/composant/new/{id}/{parentId}', name: 'app_affaire_devis_composant_new', methods: ['GET', 'POST'])]
    public function newComposant(Devis $devis, $parentId, Request $request, Environment $environment, OuvrageRepository $ouvrageRepository, DevisRepository $devisRepository, ComposantRepository $composantRepository): Response
    {


        // on crée un nouveau composant avec le statut copie
        $composant = new Composant();
        $composant->setCreateur($this->getUser());
        $composant->setStatut('Copie');
        $composant->setSelection(false);
        $composant->setQuantite(0);

        // on recupere tout les elements du devis pour pouvoir les modifier et y ajouter des nouveaux elements
        $elements = $devis->getElements();

        try {
            // on sauvergade notre noveau element pour pouvoir recuperer l'id
            $composantRepository->add($composant);

            // on crée le tableau de notre nouveau element pour pouvoir l'ajouter au tablement elements de devis et créer son html
            $element = [
                'id' => $composant->getId(),
                'type' => 'composant',
                'data' => []
            ];
            $html = $this->recursiveElements([$element], $parentId);

            if (!empty($parentId)) {
                $parent = [];
                $parent['id'] = $parentId;
                $parent['type'] = 'ouvrage';
                $elements = $this->setParent($elements, $element, $parent);
                $ouvrage = $ouvrageRepository->find($parentId);
                $ouvrage->addComposant($composant);
                $composant->setOuvrage($ouvrage);
                $composant->setUnite($ouvrage->getUnite());
                $composant->setMarge($ouvrage->getMarge());
                $ouvrageRepository->add($ouvrage);
                $composantRepository->add($composant);

            } else {
                $elements[] = $element;
            }
            $devis->setElements($elements);
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200, "html" => $html, 'idParent' => $parentId]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (Exception $e) {
            dd($e);
        }


        return new Response(json_encode(['code' => 404]));
    }

    #[Route('/dupliquer/element/{id}', name: 'app_affaire_element_dupliquer', methods: ['GET', 'POST'])]
    public function dupliquerElement(Request $request, Environment $environment, LotRepository $lotRepository, Devis $devis, DevisRepository $devisRepository, OuvrageRepository $ouvrageRepository, ComposantRepository $composantRepository): Response
    {
        $data = $request->request->all();
        // dd($data);

        $elements = $devis->getElements();
        $dupliquer = $this->findElement($elements, $data, $lotRepository, $ouvrageRepository, $composantRepository);
        //dd([$dupliquer]);


        $html = $this->recursiveElements([$dupliquer], $data['idParent']);

        if (!empty($data['idParent'])) {
            $idParent = $data['idParent'];
            $parent = [];
            $parent['id'] = $data['idParent'];
            $parent['type'] = 'lot';
            $elements = $this->setParent($elements, $dupliquer, $parent);

            $dataTop = $this->calculService->recursiveCalculTop(['id' => $data['idParent'], 'type' => 'lot']);
        } else {
            $idParent = null;
            $elements[] = $dupliquer;
            $dataTop = $this->calculService->recursiveCalculTop(['id' => $data['id'], 'type' => 'lot']);
        }
        //dd($html);

        //dump($data,$devis);
        //dump($data);
        //die;
        try {

            $devis->setElements($elements);
            $devisRepository->add($devis);
            return new Response(json_encode(['code' => 200, 'data' => $dataTop, "html" => $html, 'idParent' => $idParent]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (\Exception $e) {
            dd($e);
        }

        return new Response(json_encode(['code' => 404]));
    }

    #[Route('/edit/lot/{id}', name: 'app_affaire_lot_edit', methods: ['POST'])]
    public function editLot(Request $request, Lot $lot, LotRepository $lotRepository): Response
    {

        $data = $request->request->all();
        $data = $data['lot'];


        $lot->setCode($data['code']);
        $lot->setDenomination($data['denomination']);
        key_exists('quantite', $data) ? $lot->setQuantite($data['quantite']) : "";
        key_exists('prix', $data) && is_numeric($data['prix']) ? $lot->setPrixDeVenteHT($data['prix']) : "";
        key_exists('marge', $data) ? $lot->setMarge($data['marge']) : "";
        key_exists('unite', $data) ? $lot->setUnite($this->em->getRepository(Unite::class)->find($data['unite'])) : "";

        try {

            $lotRepository->add($lot);

            $dataBottom = $this->calculService->recursiveCalculBottom(['id' => $lot->getId(), 'type' => 'lot']);
            $dataTop = $this->calculService->recursiveCalculTop(['id' => $lot->getId(), 'type' => 'lot']);
            $data = array_merge($dataBottom, $dataTop);
            $data[] = $lot->__toArray();

            return new Response(json_encode(['code' => 200, 'data' => $data]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (Exception $e) {
            dd($e);
        }


        return new Response(json_encode(['code' => 404]));
    }

    public function getPrix($elements, $ouvrageRepository, $lotRepository): float
    {
        $prixHT = 0;


        //dd($elements);
        foreach ($elements as $element) {
            if ($element['type'] == 'lot') {
                $lotPrixHT = $this->getPrix($element['data'], $ouvrageRepository, $lotRepository);

                $lot = $lotRepository->find($element['id']);
                $lot->setPrixHT($lotPrixHT);
                $prixHT += $lotPrixHT;
            } elseif ($element['type'] == 'ouvrage') {
                $ouvrage = $ouvrageRepository->find($element['id']);
                $prixHT += $ouvrage->getDebourseHTCalcule();
            }
        }
        return $prixHT;
    }


    #[Route('/delete/element/{id}', name: 'app_affaire_devis_element_delete', methods: ['POST', 'GET'])]
    public function deleteElement(Devis $devis, Request $request, Environment $environment, DevisRepository $devisRepository, LotRepository $lotRepository, OuvrageRepository $ouvrageRepository, ComposantRepository $composantRepository): Response
    {
        $element = $request->request->all();
        //dd($element);
        try {
            $data = [];
            if (!empty($element['id']) and !empty($element['type'])) {

                if ($element['type'] == 'composant') {
                    $composant = $composantRepository->find($element['id']);
                    $composant->setMarge(0);
                    $composant->setPrixDeVenteHT(0);
                    $composant->setQuantite(0);
                    $composant->setDebourseUnitaireHT(0);
                    $composantRepository->add($composant);
                } elseif ($element['type'] == 'ouvrage') {
                    $ouvrage = $ouvrageRepository->find($element['id']);
                    $ouvrage->setMarge(0);
                    $ouvrage->setPrixDeVenteHT(0);
                    $ouvrage->setQuantite(0);
                    $ouvrage->getComposants()->clear();

                } elseif ($element['type'] == 'lot') {
                    $lot = $lotRepository->find($element['id']);
                    $lot->setMarge(0);
                    $lot->setPrixDeVenteHT(0);
                    $lot->setQuantite(0);
                    $lot->getOuvrages()->clear();
                    $lot->getSousLots()->clear();
                }

                $data = $this->calculService->recursiveCalculTop(['id' => $element['id'], 'type' => $element['type']]);
                $elements = $devis->deleteInElements($element, $lotRepository, $ouvrageRepository, $composantRepository);
                $devis->setElements($elements);
                $devisRepository->add($devis);
            }

            return new Response(json_encode(['code' => 200, 'data' => $data]));
        } catch (OptimisticLockException $e) {
            dd($e);
        } catch (\Exception $e) {
            dd($e);
        }

        return new Response(json_encode(['code' => 404]));
    }

    #[Route('/{id}', name: 'app_affaire_devis_delete', methods: ['POST'])]
    public function delete(Request $request, Devis $devis, DevisRepository $devisRepository, OuvrageRepository $ouvrageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $devis->getId(), $request->request->get('_token'))) {
            /*  foreach ($devis->getOuvrage() as $ouvrage) {
                  $ouvrage->setDevis($devis);
                  $ouvrageRepository->add($ouvrage);
              }*/
            $devisRepository->remove($devis);
        }

        return $this->redirectToRoute('app_affaire_devis_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/pdf/{id}', name: 'app_affaire_devis_pdf', methods: ['POST', 'GET'])]
    public function createPdf(Request $request, Devis $devis, LotRepository $lotRepository, OuvrageRepository $ouvrageRepository, ComposantRepository $composantRepository): Response
    {
        $prixDevis = 0;

        $elementsDevis = $devis->getElements();

        $elements = [];

        foreach ($elementsDevis as $lotDevis) {
            $lot = $lotRepository->find($lotDevis['id']);
            $tableauLot = ['lot' => $lot, 'type' => 'lot', 'data' => []];

            $prixDevis += $lot->getPrixDeVenteHT();

            foreach ($lotDevis['data'] as $sousElementDevis) {
                if ($sousElementDevis['type'] == 'ouvrage') {

                    $ouvrage = $ouvrageRepository->find($sousElementDevis['id']);
                    $tableauLot['data'][] = ['ouvrage' => $ouvrage, 'type' => 'ouvrage', 'composants' => $composantRepository->findComposantsByOuvrageId($ouvrage->getId())];
                } elseif ($sousElementDevis['type'] == 'lot') {
                    $sousLot = $lotRepository->find($sousElementDevis['id']);
                    $tableauLot['data'][] = ['lot' => $sousLot, 'type' => 'lot', 'data' => []];

                    foreach ($sousElementDevis['data'] as $ouvrageDevis) {
                        $ouvrage = $ouvrageRepository->find($ouvrageDevis['id']);
                        $tableauLot['data'][count($tableauLot['data']) - 1]['data'][] = ['ouvrage' => $ouvrage, 'type' => 'ouvrage', 'composants' => $composantRepository->findComposantsByOuvrageId($ouvrage->getId())];

                    }
                }
            }

            $elements[] = $tableauLot;
        }

        $bodyTemplate1 = $this->environment->render('pdf/devis1.html.twig', ['devis' => $devis, 'prixDevis' => $prixDevis, 'page' => 1]);
        $bodyTemplate2 = $this->environment->render('pdf/devis2.html.twig', ['devis' => $devis, 'elements' => $elements, 'prixDevis' => $prixDevis, 'page' => 2]);
        $bodyTemplate3 = $this->environment->render('pdf/devis3.html.twig', ['devis' => $devis, 'page' => 3]);

        $name = $devis->getTitre();

        $this->pdfService->generateTemplate($bodyTemplate1);
        $this->pdfService->generateTemplatePaysage($bodyTemplate2);
        $this->pdfService->generateTemplate($bodyTemplate3);

        $pdf = $this->pdfService->generatePdf($name);

        $response = new Response($pdf);
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $name . '.pdf'
        );
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }

}
