<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use App\Form\TypeAssignedType;
use App\Repository\TicketRepository;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

#[Route('/ticket')]
class TicketController extends AbstractController
{
    private $logger;
    private $emailServices;
    private EntityManagerInterface $entityManager; // Declare the EntityManagerInterface

    public function __construct(LoggerInterface $logger, EmailService $emailServices, EntityManagerInterface $entityManager)
    {
        $this->logger = $logger;
        $this->emailServices = $emailServices;
        $this->entityManager = $entityManager; // Inject the EntityManagerInterface via constructor

    }
    #[Route('/', name: 'app_ticket_index', methods: ['GET'])]
    public function index(TicketRepository $ticketRepository): Response
    {
        return $this->render('ticket/index.html.twig', [
            'tickets' => $ticketRepository->findAll(),
            'title' => 'Ticket',
            'nav' => [['app_ticket_new', 'Ajouter un ticket']]
        ]);
    }

    #[Route('/new', name: 'app_ticket_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TicketRepository $ticketRepository, EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket();
        $image  = __DIR__ . "/../../public/uploads/logo/signatureService.png";
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $date = new \DateTime();
            $ticket->setDate($date->format('d-m-Y H:i:s'));
            $ticket->setCreator($this->getUser());
            $ticket->setStatus('A traiter');
            $entityManager->persist($ticket);
            $entityManager->flush();
            $this->emailServices->send("salaheddineelmamouni20@gmail.com", $ticket, "emails/ticketMail.html.twig", $ticket->getTitle(), $image);

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
            $issue = "assigned";
            $ticket = $this->entityManager->getRepository(Ticket::class)->findOneBy(['id' => $id]);

            $previousStatus = $ticket->getStatus();

            $form = $this->createForm(TypeAssignedType::class, $ticket);
            $form->handleRequest($request);

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
                $this->emailServices->send($ticket->getCreator()->getEmailPerso(), $ticket, "emails/ticketMail.html.twig", $ticket->getTitle(), "");
                $this->entityManager->persist($ticket);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
            }



            $nav = [['app_ticket_index', 'Revenir à la liste'],['app_ticket_index', 'Demande des informations']];

            return $this->renderForm('ticket/assigned.html.twig', [
                'ticket' => $ticket,
                'nav' => $nav,
                'title' => 'Prendre un ticket',
                'form' => $form,
            ]);
        } catch (Exception $e) {
            $this->logger->error('Error :'.$e->getMessage());
            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        }
    }
    /**
     * @Route("/{id}/information", name="ticket_informations", methods={"GET", "POST"})
     */
    public function ticketInformations($id, Request $request, TicketRepository $ticketRepository): Response
    {

        try {
            $issue = "informations";
            $ticket = $this->entityManager->getRepository(Ticket::class)->findOneBy(['id' => $id]);

            $previousStatus = $ticket->getStatus();

            $form = $this->createForm(TypeAssignedType::class, $ticket);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

           
             //   $this->emailServices->send($ticket->getCreator()->getEmailPerso(), $ticket, "emails/ticketMail.html.twig", $ticket->getTitle(), "");
             
                return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
            }



            $nav = [['app_ticket_index', 'Revenir à la liste']];

            return $this->renderForm('ticket/assigned.html.twig', [
                'ticket' => $ticket,
                'nav' => $nav,
                'title' => 'Demande des informations',
                'form' => $form,
            ]);
        } catch (Exception $e) {
            $this->logger->error('Error :'.$e->getMessage());
            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        }
    }
}
