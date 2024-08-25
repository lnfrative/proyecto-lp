<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(Request $request): Response
    {
        $user = $this->getUser();

        if (is_null($user)) {
            return $this->redirectToRoute('app_login');
        }

        return $this->redirectToRoute('app_reservaciones_consultar');        
    }
}
