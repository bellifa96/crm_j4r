<?php

namespace App\Controller;

use App\Entity\Affaire\Evenement;
use App\Entity\Pret;
use App\Form\Affaire\EvenementType;
use App\Form\PretType;
use App\Repository\Affaire\EvenementRepository;
use App\Repository\DemandeRepository;
use App\Repository\MaterielRepository;
use App\Repository\PretRepository;
use App\Repository\UserRepository;
use App\Service\EmailService;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Cache\Exception\CacheException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

#[Route('/pret')]
class PretController extends AbstractController
{
    #[Route('/', name: 'app_pret_index', methods: ['GET'])]
    public function index(PretRepository $pretRepository): Response
    {
        return $this->render('pret/index.html.twig', [
            'prets' => $pretRepository->findAll(),
            'title'=> 'Liste des prêts',
            'nav'=>[]
        ]);
    }

    #[Route('/new', name: 'app_pret_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PretRepository $pretRepository): Response
    {
        $pret = new Pret();
        $form = $this->createForm(PretType::class, $pret);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pretRepository->add($pret, true);

            return $this->redirectToRoute('app_pret_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pret/new.html.twig', [
            'pret' => $pret,
            'form' => $form,
            'title'=> 'Liste des prêts',
            'nav'=>[]
        ]);
    }

    #[Route('/new/pret', name: 'app_pret_new_pret', methods: ['POST'])]
    public function newPret(Request $request, PretRepository $pretRepository, MaterielRepository $materielRepository, UserRepository $userRepository,EmailService $emailService): Response
    {

        $data = $request->request->all()['pret'];
        $response = new Response();

        if (!empty($data['materiel']) and !empty($data['utilisateur']) and !empty($data['dateDAffectation'])
            and !empty($data['etat']) ) {

            $pret = new Pret();

            $materiel = $materielRepository->find($data['materiel']);

            $user = $userRepository->find($data['utilisateur']);


            $pret->setMateriel($materiel);
            $pret->setUtilisateur($user);
            $pret->setDateDAffectation(htmlspecialchars($data['dateDAffectation'], ENT_QUOTES, 'UTF-8'));
            $pret->setDateDeRetour(htmlspecialchars($data['dateDeRetour'], ENT_QUOTES, 'UTF-8'));
            $pret->setEtat(htmlspecialchars($data['etat'], ENT_QUOTES, 'UTF-8'));
            $pret->setNote(htmlspecialchars($data['commentaire'], ENT_QUOTES, 'UTF-8'));

            //dd($pret);
            try {
                $pretRepository->add($pret);
                $objet = $this->getUser()->getFirstname().' Vous a attribué le matériel ('.$pret->getMateriel()->getTitre().')';
                $emailService->send([$pret->getUtilisateur()->getEmail()],$pret,'emails/pret.html.twig',$objet);
                $response->setContent(json_encode(['code' => 200, 'message' => ['id' => $pret->getId()]])) ;

            } catch (CacheException|Exception $e) {
                $response->setContent(json_encode(['code' => 404, 'message' => "Une activité avec le même titre existe dans la base de données"]));
            }
        } else {
            $response->setContent(json_encode(['code' => 404, 'message' => 'Veuillez remplir tous les champs du formulaire']));
        }
        return $response;

    }

    #[Route('/new/modal', name: 'app_pret_new_modal', methods: ['GET', 'POST'])]
    public function getModal(Request $request, Environment $environment): Response
    {
        $pret = new Pret();
        $form = $this->createForm(PretType::class, $pret);
        $response = new Response();
        try {
            $html = $environment->render("pret/modal_form.html.twig", [
                'form' => $form->createView()
            ]);
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

    #[Route('/{id}', name: 'app_pret_show', methods: ['GET'])]
    public function show(Pret $pret): Response
    {
        return $this->render('pret/show.html.twig', [
            'pret' => $pret,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pret_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pret $pret, PretRepository $pretRepository): Response
    {
        $form = $this->createForm(PretType::class, $pret);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pretRepository->add($pret, true);

            return $this->redirectToRoute('app_pret_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pret/edit.html.twig', [
            'pret' => $pret,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pret_delete', methods: ['POST'])]
    public function delete(Request $request, Pret $pret, PretRepository $pretRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pret->getId(), $request->request->get('_token'))) {
            $pretRepository->remove($pret, true);
        }

        return $this->redirectToRoute('app_pret_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/validate/{id}', name: 'app_pret_validate', methods: ['GET'])]
    public function validate(Pret $pret, PretRepository $pretRepository, Request $request)
    {


        $pret->setStatut("Rendu");
        $pretRepository->add($pret);
        $route = $request->headers->get('referer');

        return $this->redirect($route);

    }
}
