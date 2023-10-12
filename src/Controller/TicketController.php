<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use App\Form\TypeAssignedType;
use App\Repository\TicketRepository;
use App\Repository\UserRepository;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/ticket')]
class TicketController extends AbstractController
{
    private $logger;
    private $emailServices;

    private $emailUser;
    private EntityManagerInterface $entityManager; // Declare the EntityManagerInterface

    private $security;

    private $userRepository;


    public function __construct(LoggerInterface $logger, EmailService $emailServices, EntityManagerInterface $entityManager, Security $security, UserRepository $userRepository)
    {
        $this->logger = $logger;
        $this->emailServices = $emailServices;
        $this->entityManager = $entityManager; // Inject the EntityManagerInterface via constructor
        $this->security = $security;
        $this->userRepository = $userRepository;
    }
    #[Route('/', name: 'app_ticket_index', methods: ['GET'])]
    public function index(TicketRepository $ticketRepository): Response
    {
        $repository = $this->entityManager->getRepository(Ticket::class); // Replace with your entity class

        $query = $repository->createQueryBuilder('e')
            ->orderBy('e.date', 'ASC') // Replace 'yourField' with the field you want to order by
            ->getQuery();

        $data = $query->getResult();
        return $this->render('ticket/index.html.twig', [
            'tickets' => $data,
            'title' => 'Ticket',
            'nav' => [['app_ticket_new', 'Ajouter un ticket']]
        ]);
    }

    #[Route('/new', name: 'app_ticket_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TicketRepository $ticketRepository, EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        $email_roles_dev = $this->userRepository->getEmailsForRoleDevUsers();

        if ($form->isSubmitted() && $form->isValid()) {

            $date = new \DateTime();
            $ticket->setDate($date->format('d-m-Y H:i:s'));
            $ticket->setCreator($this->getUser());
            $ticket->setStatus('A traiter');
            $entityManager->persist($ticket);
            $entityManager->flush();
            if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
                $user = $this->security->getUser();
                $this->emailUser = $user->getEmail();
            } else {
            }
            $this->emailServices->sendNew($email_roles_dev, $this->emailUser, $ticket, "emails/ticketMail.html.twig", $ticket->getTitle(), '');

            $this->logger->info('Ticket est bien Créer');

            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ticket/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
            'title' => 'Creation un ticket',
            'nav' => [['app_demande_new', 'Creation un ticket']]
        ]);
    }

    #[Route('/{id}', name: 'app_ticket_show', methods: ['GET'])]
    public function show(Ticket $ticket): Response
    {
        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ticket_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ticket $ticket, TicketRepository $ticketRepository): Response
    {
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ticketRepository->save($ticket, true);

            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ticket_delete', methods: ['POST'])]
    public function delete(Request $request, Ticket $ticket, TicketRepository $ticketRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ticket->getId(), $request->request->get('_token'))) {
            $ticketRepository->remove($ticket, true);
        }

        return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
    }


    // La prémier etape aprés la crétion du ticket

    /**
     * @Route("/{id}/assigned", name="ticket_assigned", methods={"GET", "POST"})
     */
    public function ticketAssigned($id, Request $request, TicketRepository $ticketRepository): Response
    {

        try {
            /*if (!$this->security->isGranted('ROLE_DEV')) {
                throw $this->createAccessDeniedException('Access denied');
            }*/
            $issue = "assigned";
            $ticket = $this->entityManager->getRepository(Ticket::class)->findOneBy(['id' => $id]);
            $userRoles = [];

            $search = "ROLE_DEV";
            if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
                $user = $this->security->getUser();
                $userRoles = $user->getRoles();
            } else {
            }
            $affichage = 0;
            if (in_array($search, $userRoles) == false) {
                $affichage = 1;
            }



            $previousStatus = $ticket->getStatus();
            $form = $this->createForm(TypeAssignedType::class, $ticket, [
                'demande_information' => 0, 'affichage' => $affichage
            ]);
            $form->handleRequest($request);
            $status = $ticket->getStatus();
            if ($form->isSubmitted() && $form->isValid()) {

                $date = new \DateTime();
                $status = $ticket->getStatus();

                if ($status != $previousStatus) {
                    if ($status == "En cours") {
                        $ticket->setDateTaken($date->format('d-m-Y H:i:s'));
                        $ticket->setAdmin($this->getUser());
                    }
                    if ($status == "En confirmation") {
                        $ticket->setResolved(false);
                    }
                }
                if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
                    $user = $this->security->getUser();

                    $userRoles = $user->getRoles();
                    $this->emailUser = $user->getEmail();
                } else {
                }
                $this->emailServices->sendAssigend($ticket->getCreator()->getEmail(), $this->emailUser, $ticket, "emails/ticketMail.html.twig", $ticket->getTitle(), "");
                $this->entityManager->persist($ticket);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
            }

            if ($status == "En confirmation" && !in_array($search, $userRoles) && $user->getId() == $ticket->getCreator()->getId()) {
                $nav = [
              ['ticket_resolu', 'Clôturer le ticket', $id], ['ticket_probleme', 'Envoyer un message', $id],['app_ticket_index', 'Revenir à la liste']

                ];
            } else {
                $nav = [['app_ticket_index', 'Revenir à la liste'], ['ticket_informations', 'Demande des informations', $id]];
            }

            return $this->renderForm('ticket/assigned.html.twig', [
                'ticket' => $ticket,
                'nav' => $nav,
                'title' => 'Ticket (' . $ticket->getTitle() . ')',
                'commantaires' => null,
                'form' => $form,
                'demande_information' => 0,
                "affichage" => $affichage // Pass the value here

            ]);
        } catch (Exception $e) {
            $this->logger->error('Error :' . $e->getMessage());
            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        }
    }
    /**
     * @Route("/{id}/information", name="ticket_informations", methods={"GET", "POST"})
     */
    public function ticketInformations($id, Request $request, TicketRepository $ticketRepository): Response
    {

        try {





            $ticket = $this->entityManager->getRepository(Ticket::class)->findOneBy(['id' => $id]);

            $search = "ROLE_DEV";
            if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
                $user = $this->security->getUser();
                $userRoles = $user->getRoles();
            } else {
            }
            $affichage = 0;
            if (in_array($search, $userRoles) == false) {
                $affichage = 1;
            }

            $form  = $this->createForm(TypeAssignedType::class, $ticket, [
                'demande_information' => 1, 'affichage' => $affichage
            ]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
                    $user = $this->security->getUser();
                    $this->emailUser = $user->getEmail();
                } else {
                }

                $message_information = $form->get('message')->getData();


                $this->emailServices->sendInformation($ticket->getAdmin()->getEmail(), $this->emailUser, $ticket, "emails/ticketMail.html.twig", $ticket->getTitle(), $message_information, 1);
                return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
            }



            $nav = [['app_ticket_index', 'Revenir à la liste']];
            $search = "ROLE_DEV";
            if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
                $user = $this->security->getUser();
                $userRoles = $user->getRoles();
                $this->emailUser = $user->getEmail();
            } else {
            }
            return $this->renderForm('ticket/assigned.html.twig', [
                'ticket' => $ticket,
                'commantaires' => null,
                'nav' => $nav,
                'title' => 'Demande des informations',
                'form' => $form,
                'demande_information' => 1,
                "affichage" => $affichage // Pass the value here
            ]);
        } catch (Exception $e) {
            $this->logger->error('Error :' . $e->getMessage());
            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/probleme", name="ticket_probleme", methods={"GET", "POST"})
     */
    public function ticketprobleme($id, Request $request, TicketRepository $ticketRepository): Response
    {
        try {





            $ticket = $this->entityManager->getRepository(Ticket::class)->findOneBy(['id' => $id]);

            $search = "ROLE_DEV";
            if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
                $user = $this->security->getUser();
                $userRoles = $user->getRoles();
            } else {
            }
            $affichage = 0;
            if (!in_array($search, $userRoles) == false) {
                $affichage = 1;
            }

            $form  = $this->createForm(TypeAssignedType::class, $ticket, [
                'demande_information' => 1, 'affichage' => $affichage
            ]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
                    $user = $this->security->getUser();
                    $this->emailUser = $user->getEmail();
                } else {
                }

                $message_information = $form->get('message')->getData();

                $this->emailServices->sendMessageRefus($ticket->getAdmin()->getEmail(), $this->emailUser, $ticket, "emails/ticketMail.html.twig", $ticket->getTitle(), $message_information, 3);
                return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
            }



            $nav = [['app_ticket_index', 'Revenir à la liste']];
            $search = "ROLE_DEV";
            if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
                $user = $this->security->getUser();
                $userRoles = $user->getRoles();
                $this->emailUser = $user->getEmail();
            } else {
            }
            return $this->renderForm('ticket/assigned.html.twig', [
                'ticket' => $ticket,
                'commantaires' => null,
                'nav' => $nav,
                'title' => 'Envoyer Un Message',
                'form' => $form,
                'demande_information' => 1,
                "affichage" => $affichage // Pass the value here
            ]);
        } catch (Exception $e) {
            $this->logger->error('Error :' . $e->getMessage());
            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        }
    }
    /**
     * @return User|null
     */
    protected function getUser(): ?UserInterface
    {
        return parent::getUser();
    }



    /**
     * @Route("/{id}/resolu", name="ticket_resolu", methods={"GET", "POST"})
     */
    public function ticketResolu($id, Request $request, TicketRepository $ticketRepository): Response
    {

        try {

            $ticket = $this->entityManager->getRepository(Ticket::class)->findOneBy(['id' => $id]);
            $status = $ticket->getStatus();

            $ticket->setStatus("Résolu");

            $date = new \DateTime();

            if ($status == "En confirmation") {
                $ticket->setDateResolved($date->format('d-m-Y H:i:s'));
                $ticket->setResolved(true);
            }
            if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
                $user = $this->security->getUser();
                $this->emailUser = $user->getEmail();
            } else {
            }
            $this->emailServices->sendTicketResolu($ticket->getCreator()->getEmail(), $this->emailUser, $ticket, "emails/ticketMail.html.twig", $ticket->getTitle(), "", 2);

            $this->entityManager->persist($ticket);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        } catch (Exception $e) {
            $this->logger->error('Error :' . $e->getMessage());
            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        }
    }
}
