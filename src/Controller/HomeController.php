<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use thiagoalessio\TesseractOCR\TesseractOCR;

class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
       /* $ocr = new TesseractOCR();
        $ocr->image(__DIR__.'/../../uploads/RIB/img_2.png');

        $data =$ocr->run();
        dd($data);*/
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'title'=>'Dashboard',
            'nav' => [],
        ]);
    }
}
