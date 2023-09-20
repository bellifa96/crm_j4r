<?php

namespace App\Controller\Conversation;

use App\Entity\Affaire\Devis;
use App\Entity\Conversation\ConversationApresNegociationDemande;
use App\Entity\Conversation\ConversationChantier;
use App\Entity\Conversation\ConversationClient;
use App\Entity\Conversation\ConversationMetreDemande;
use App\Entity\Conversation\Message;
use App\Entity\Demande;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    #[Route('/conversation/message/{id}/{type}', name: 'app_conversation_message')]
    public function newMessageDemandeMetre(Demande $demande, $type, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!empty($request->request->get('message'))) {

            $message = new Message();
            $message->setCreateur($this->getUser());

            if ($type == 'metre') {
                if (empty($demande->getConversationMetreDemande())) {
                    $conversation = new ConversationMetreDemande();
                    $conversation->setDemande($demande);
                    $entityManager->persist($conversation);
                }
                $message->setMessage($request->request->get('message'));
                $message->setConversationDemandeMetre($demande->getConversationMetreDemande());
            } elseif ($type == 'negociation') {
                if (empty($demande->getConversationApresNegociationDemande())) {
                    $conversation = new ConversationApresNegociationDemande();
                    $conversation->setDemande($demande);
                    $entityManager->persist($conversation);
                }
                $message->setMessage($request->request->get('message'));
                $message->setConversationApresNegociationDemande($demande->getConversationApresNegociationDemande());
            } elseif ($type == 'client') {

                if (empty($demande->getConversationClient())) {
                    $conversation = new ConversationClient();
                    $conversation->setDemande($demande);
                    $entityManager->persist($conversation);
                }
                $message->setMessage($request->request->get('message'));
                $message->setConversationClient($demande->getConversationClient());
            }else{
                return new Response(json_encode(['code' => 403, 'message' => 'commentaire vide']));
            }
            $entityManager->persist($message);
            $entityManager->flush();
            return new Response(json_encode(
                [
                    'code' => 200,
                    'message' => [
                        'createur' => $this->getUser()->getFirstname() . " " . $this->getUser()->getlastname(),
                        'message' => $request->request->get('message'),
                        'date' => $message->getCreatedAt()->format('d/m/Y H:i:s'),
                    ]
                ]
            ));


        }
        return new Response(json_encode(['code' => 403, 'message' => 'commentaire vide']));
    }

    #[Route('/devis/conversation/message/{id}/{type}', name: 'app_conversation_message_chantier')]
    public function newMessageDevisChantier(Devis $devis, $type, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!empty($request->request->get('message'))) {

            $message = new Message();
            $message->setCreateur($this->getUser());

            if ($type == 'chantier') {

                if (empty($devis->getConversationChantier())) {
                    $conversation = new ConversationChantier();
                    $conversation->setDevis($devis);
                    $entityManager->persist($conversation);
                }
                $message->setMessage($request->request->get('message'));
                $message->setConversationChantier($devis->getConversationChantier());
            }else{
                return new Response(json_encode(['code' => 403, 'message' => 'commentaire vide']));
            }
            $entityManager->persist($message);
            $entityManager->flush();
            return new Response(json_encode(
                [
                    'code' => 200,
                    'message' => [
                        'createur' => $this->getUser()->getFirstname() . " " . $this->getUser()->getlastname(),
                        'message' => $request->request->get('message'),
                        'date' => $message->getCreatedAt()->format('d/m/Y H:i:s'),
                    ]
                ]
            ));


        }
        return new Response(json_encode(['code' => 403, 'message' => 'commentaire vide']));
    }


}
