<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ReservacionesController extends AbstractController
{
    // Christopher Díaz
    #[Route('/reservaciones/crear', name: 'app_reservaciones_crear', methods: ['POST'])]
    public function crear(Request $request, EntityManagerInterface $entityManager): Response
    {
    
    }

    // Stephany
    #[Route('/reservaciones/aprobadas', name: 'app_reservaciones_aprobadas', methods: ['GET'])]
    public function aprobadas(Request $request, EntityManagerInterface $entityManager): Response
    {
      
    }

    // Stephany
    #[Route('/reservaciones/aprobar', name: 'app_reservaciones_aprobar', methods: ['POST'])]
    public function aprobar(Request $request, EntityManagerInterface $entityManager): Response
    {
      
    }

    // Stephany
    #[Route('/reservaciones/cancelar', name: 'app_reservaciones_cancelar', methods: ['POST'])]
    public function cancelar(Request $request, EntityManagerInterface $entityManager): Response
    {
      
    }

    // Stephany
    #[Route('/reservaciones/rechazar', name: 'app_reservaciones_rechazar', methods: ['POST'])]
    public function rechazar(Request $request, EntityManagerInterface $entityManager): Response
    {
       
    }

    // Stephany
    #[Route('/reservaciones/consultar', name: 'app_reservaciones_consultar', methods: ['GET'])]
    public function consultar(Request $request, EntityManagerInterface $entityManager): Response
    {
       
    }
}