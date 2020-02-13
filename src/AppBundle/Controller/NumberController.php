<?php
// src/Controller/LuckyController.php
namespace AppBundle\Controller;
//AppBundle\Controller\LuckyController

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NumberController extends AbstractController
{

    /**
     * @Route("/gnumber")
     */
    public function numberAction()
    {
        $number = random_int(0, 100);

        return $this->render('number.html.twig', ['number' => $number]);
    }
}