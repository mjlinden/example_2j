<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController
{
    #[Route('/lucky/number/{max}')]
    public function number($max): Response
    {
        $number = random_int(0, $max);
        $dagen=["maandag","dinsdag","woensdag","donderdag","vrijdag"];
        return $this->render('bezoeker/lucky.html.twig',
            ['number'=>$number,
            'days'=>$dagen]);
    }

    #[Route('/goedemorgen',name:'morgen')]
    public function goedemorgenAction():Response
    {
        return new Response('<h1>goedemorgen</h1>');
    }

}