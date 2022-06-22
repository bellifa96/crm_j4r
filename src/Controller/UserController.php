<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

#[Route('/user')]
class UserController extends AbstractController
{
    private $verifyEmailHelper;
    private $mailer;

    public function __construct(VerifyEmailHelperInterface $helper, MailerInterface $mailer)
    {
        $this->verifyEmailHelper = $helper;
        $this->mailer = $mailer;
    }


    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'title' => 'Gestion des utilisateurs',
            'nav' => [['app_user_new', 'Ajouter un utilisateur']],
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));

            $brochureFile = $form->get('photo')->getData();

            if (!empty($brochureFile)) {
                $newFilename = $user->getId() . '.' . $brochureFile->guessExtension();

                try {
                    $brochureFile->move(
                        __DIR__ . '/../../public/uploads/photo/',
                        $newFilename
                    );
                } catch (FileException $e) {

                    $this->addFlash('danger', "La photo de profile n'a pas pu être charger ");
                }

                $user->setPhoto($newFilename);
            }

            $signature = $form->get('signature')->getData();

            if (!empty($signature)) {
                $newFilename = $user->getId() . '.' . $signature->guessExtension();

                try {
                    $signature->move(
                        __DIR__ . '/../../public/uploads/signature/',
                        $newFilename
                    );
                } catch (FileException $e) {

                    $this->addFlash('danger', "La signature n'a pas pu être charger ");
                }

                $user->setSignature($newFilename);
            }

            $userRepository->add($user);
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
            'title' => 'Créer un utilisateur',
            'nav' => [],
        ]);
    }


    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'title' => $user->getFirstname() . " " . $user->getLastname(),
            'nav' => [],

        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, SluggerInterface $slugger): Response
    {
        $photo = $user->getPhoto();
        $signatureOld = $user->getSignature();


        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $brochureFile = $form->get('photo')->getData();

            if (!empty($brochureFile)) {
                $newFilename = $user->getId() . '.' . $brochureFile->guessExtension();

                try {
                    $brochureFile->move(
                        __DIR__ . '/../../public/uploads/photo/',
                        $newFilename
                    );
                } catch (FileException $e) {

                    $this->addFlash('danger', "La photo de profile n'a pas pu être charger ");
                }

                $user->setPhoto($newFilename);
            } else {
                $user->setPhoto($photo);
            }

            $signature = $form->get('signature')->getData();

            if (!empty($signature)) {
                $newFilename = $user->getId() . '.' . $signature->guessExtension();

                try {
                    $signature->move(
                        __DIR__ . '/../../public/uploads/signature/',
                        $newFilename
                    );
                } catch (FileException $e) {

                    $this->addFlash('danger', "La signature n'a pas pu être charger ");
                }

                $user->setSignature($newFilename);
            } else {
                $user->setSignature($signatureOld);
            }

            $userRepository->add($user);
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'title' => "Modifier l'utilisateur " . $user->getFirstname() . " " . $user->getLastname(),
            'nav' => [],

        ]);
    }


    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route("/locked/{id}", name: "user_locked")]
    // #[Security("is_granted('ROLE_ADMIN')")]
    public function locked(Request $request, User $user, UserRepository $userRepository)
    {
        if ($user) {
            if ($user->getLocked()) {
                $user->setLocked(0);
            } else {
                $user->setLocked(1);
            }
            $userRepository->add($user);

            $this->addFlash('success', 'ALERT_ACCOUNT_LOCK');
        } else {
            $this->addFlash('danger', 'ALERT_ACCOUNT_LOCK_IMPOSSIBLE');
        }

        return $this->redirectToRoute('app_user_index');
    }
}
