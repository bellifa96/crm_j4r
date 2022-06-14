<?php

namespace App\Controller\API;

use App\Entity\Society\Rib;
use App\Repository\Society\RibRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OCR extends AbstractController
{

    #[Route('/api/rib/new', name: 'api_rib_ocr_new',methods: 'POST')]
    /**
     * @return JsonResponse
     * @OA\Response(
     *     response=200,
     *     description="Returns the token for an user",
     * )
     * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="iban",
     *           description="iban of society.",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="bic",
     *           description="bic of society.",
     *           type="string",
     *         ),
     *       ),
     *     ),
     * )
     * @OA\Tag(name="token")
     */
    public function new(Request $request,RibRepository $ribRepository):JsonResponse
    {

        $data = json_decode($request->getContent());

        return new JsonResponse(["code"=> 200,"message"=>$data]);

        if(!empty($data->iban) and !empty($data->bic)){
            $rib = new Rib();
            $rib->setIban($data->iban);
            $rib->setBic($data->bic);

            try {
                $ribRepository->add($rib);
                return new JsonResponse(["code"=> 200,"message"=>"bien reçu"]);

            } catch (OptimisticLockException|ORMException|UniqueConstraintViolationException $e) {
                return new JsonResponse(["code"=>500,"message"=>$e->getMessage()]);
            }
        }

        return new JsonResponse(["code"=> 200,"message"=>"vide"]);
    }

}
