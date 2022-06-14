<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use OpenApi\Annotations as OA;


class SecurityController extends AbstractController
{

    #[Route(path: '/api/login_check', name: 'app_login_check', methods: 'POST')]
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
     *           property="username",
     *           description="Email address of the user.",
     *           type="string",
     *         ),
     *         @OA\Property(
     *           property="password",
     *           description="Password address of the  user.",
     *           type="string",
     *         ),
     *       ),
     *     ),
     * )
     * @OA\Tag(name="token")
     */
    public function apiLogin(Request $request): JsonResponse
    {
        $user = $this->getUser();

        if (empty($user)) {
            return new JsonResponse([
                'code' => 403,
                'message' => "Vous n'êtes pas connecté",
            ]);
        }

        return new JsonResponse([
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ]);
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
