<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Ticket;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Route('/comment')]

class CommentController extends AbstractController
{

    private EntityManagerInterface $entityManager; // Declare the EntityManagerInterface



    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/{id}', name: 'app_comment')]
    public function index($id): JsonResponse
    {

        $commentRepository = $this->entityManager->getRepository(Comment::class);
        $comments = $commentRepository->findAll();

        $simplifiedComments = [];

        foreach ($comments as $comment) {
            if ($comment->getTicket()->getId() == $id) {
                $simplifiedComment = [
                    'id' => $comment->getId(),
                    'content' => $comment->getContent(),
                    'user' => $comment->getUser()->getFirstname() . ' ' . $comment->getUser()->getLastname() ,
                    'userId' => $comment->getUser()->getId(),
                    'date' => $comment->getCreatedAt()
                ];

                $simplifiedComments[] = $simplifiedComment;
            }
        }

        return $this->json($simplifiedComments);
    }

    #[Route('/new/comment', name: 'app_comment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        
        $data = json_decode($request->getContent(), true);
        
        $user = $entityManager->getRepository(User::class)->find($data['userId']);
        $ticket = $entityManager->getRepository(Ticket::class)->find($data['ticketId']);
        $comment = new Comment();
        $comment->setUser($user);
        $comment->setTicket($ticket);
        $comment->setContent($data['message']);
        $comment->setCreatedAt(new \DateTime());
        $entityManager->persist($comment);
        $entityManager->flush();
        $response = [
            'code' => 200,
            'msg' => 'Comment added successfully',
        ];

        return new JsonResponse($response);
    }
}
