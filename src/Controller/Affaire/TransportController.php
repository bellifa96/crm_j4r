<?php

namespace App\Controller\Affaire;

use App\Entity\Affaire\Transport;
use App\Entity\Ged\Fichier;

use App\Entity\Interlocuteur\Interlocuteur;
use App\Form\Affaire\TransportType;
use App\Form\Ged\FichierType;
use App\Repository\Affaire\TransportRepository;
use App\Repository\Contact\ContactRepository;
use App\Repository\DemandeRepository;
use App\Repository\Ged\FichierRepository;
use App\Repository\Interlocuteur\InterlocuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/affaire/transport')]
class TransportController extends AbstractController
{
    #[Route('/', name: 'app_affaire_transport_index', methods: ['GET'])]
    public function index(TransportRepository $transportRepository): Response
    {
        return $this->render('affaire/transport/index.html.twig', [
            'transports' => $transportRepository->findAll(),
            'title' => '',
            'nav' => [],
        ]);
    }

    #[Route('/chantier/code/', name: 'app_affaire_transport_chantier_code', methods: ['GET', 'POST'])]
    public function chantierCode(DemandeRepository $demandeRepository, Request $request): Response
    {
        $q = $request->query->get('term') || null;
        $data = $demandeRepository->findAllByQ($q);

        $res = [];
        foreach ($data as $value) {
            foreach ($value as $val) {
                $res[] = $val;
            }
        }
        return new Response(json_encode($res));
    }


    #[Route('/new', name: 'app_affaire_transport_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TransportRepository $transportRepository, ContactRepository $contactRepository, FichierRepository $fichierRepository): Response
    {
        $transport = new Transport();
        $fichier = new Fichier();
        $transport->addFichier($fichier);
        $transport->setDonneurDOrdre($this->getUser());
        $form = $this->createForm(TransportType::class, $transport)
            ->add('fichiers', CollectionType::class, [
                'entry_type' => FichierType::class,
                'required' => false,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'data_class' => null,
                'attr' => [
                    'class' => 'form-control ',
                ],
                // these options are passed to each "email" type

            ]);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->files->all();
            $data = $data['transport']['fichiers'];

            foreach ($transport->getFichiers() as $key => $file) {

                if (empty($file->getFichier()) || empty($file->getTypeFichier())) {
                    unset($transport->getFichiers()[$key]);
                } else {
                    $file->setTransport($transport);
                    $file->setCreateur($this->getUser());
                    $bilanFile = $data[$key];

                    $folder = $file->getTypeFichier()->getTitre();

                    $newFilename = $folder . ' ' . uniqid() . '.' . $bilanFile->guessExtension();
                    $file->setFichier($newFilename);
                    $bilanFile->move(__DIR__ . '/../../../uploads/' . $folder . '/', $newFilename);
                }
            }


            $this->extracted($transport, $request, $contactRepository, $transportRepository, $fichierRepository);
            $transport->setNCommande((date('y') % 10) . date("m") . sprintf("%04d", $transport->getId()));
            $transportRepository->add($transport, true);

            return $this->redirectToRoute('app_affaire_transport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/transport/new.html.twig', [
            'transport' => $transport,
            'form' => $form,
            'title' => '',
            'nav' => [],
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_transport_show', methods: ['GET'])]
    public function show(Transport $transport): Response
    {
        return $this->render('affaire/transport/show.html.twig', [
            'transport' => $transport,
            'title' => '',
            'nav' => [],
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affaire_transport_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Transport $transport, TransportRepository $transportRepository, ContactRepository $contactRepository, FichierRepository $fichierRepository): Response
    {
        $fichier = new Fichier();
        $transport->addFichier($fichier);
        $form = $this->createForm(TransportType::class, $transport);
        $form->add('statut', ChoiceType::class, [
            'choices' => [
                'Demande CDT' => 'Demande CDT',
                'ERP validé' => 'ERP validé',
                'En attente Affrêtement' => 'En attente Affrêtement',
                'Affrété' => 'Affrété',
                'Commande prête' => 'Commande prête',
                'Livré' => 'Livré',
                'Reliquat' => 'Reliquat',
                'Facturé' => 'Facturé',
                'Vérifié' => 'Vérifier',
                'Litige' => 'Litige',
                'Payé' => 'Payé',
            ]
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->extracted($transport, $request, $contactRepository, $transportRepository, $fichierRepository);

            return $this->redirectToRoute('app_affaire_transport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affaire/transport/edit.html.twig', [
            'transport' => $transport,
            'form' => $form,
            'title' => '',
            'nav' => [],
        ]);
    }

    #[Route('/{id}', name: 'app_affaire_transport_delete', methods: ['POST'])]
    public function delete(Request $request, Transport $transport, TransportRepository $transportRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $transport->getId(), $request->request->get('_token'))) {
            $transportRepository->remove($transport, true);
        }

        return $this->redirectToRoute('app_affaire_transport_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/fournisseur/adresse/{id}', name: 'app_affaire_transport_fournisseur_adresse', methods: ['POST'])]
    public function fournisseurAdresse(Request $request, Interlocuteur $interlocuteur, ContactRepository $contactRepository,TransportRepository $transportRepository): Response
    {

        $dataRequest = $request->request->all();

        key_exists('transport', $dataRequest) ? $transport = $dataRequest['transport'] : $transport = null;

        $transport = $transportRepository->find($transport);


        $data=[];

        foreach ($interlocuteur->getContacts() as $val){
            $selected = false;
            if ( $val->getTransportContactEnlevement() === $val) {
                $selected = true;
            }
            $data[] = [
                'id' => $val->getId(),
                'text' => $val->getNom() . " " . $val->getPrenom(),
                'selected' => $selected,
            ];
        }

        return new Response(json_encode($data));
    }


    /**
     * @param Transport $transport
     * @param Request $request
     * @param ContactRepository $contactRepository
     * @param TransportRepository $transportRepository
     * @return void
     */
    public function extracted(Transport $transport, Request $request, ContactRepository $contactRepository, TransportRepository $transportRepository, FichierRepository $fichierRepository): void
    {

        $data = $request->request->all();
        $id = $data['transport']['chauffeur'];
        $chauffeur = $contactRepository->find($id);
        !empty($chauffeur) ? $transport->setChauffeur($chauffeur) : $transport->setChauffeur(null);
        $transportRepository->add($transport, true);
    }
}
