<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class BasketAction extends AbstractController
{
    #[Route(path: "/", name: "index")]
    public function index()
    {
        return $this->render('base.html.twig');
    }
}
