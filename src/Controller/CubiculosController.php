<?php

namespace App\Controller;

use App\Entity\Cubiculo;
use App\Entity\Horario;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use DateTime;

class CubiculosController extends AbstractController
{
    // José Baidal
    #[Route('/cubiculos/creados', name: 'app_cubiculos_creados', methods: ['GET'])]
    public function creados(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cubiculosCreados = $entityManager->getRepository(Cubiculo::class)->findAll();


        return $this->json($cubiculosCreados);
    }

    // José Baidal
    #[Route('/cubiculos/crear', name: 'app_cubiculos_crear', methods: ['POST'])]
    public function crear(Request $request, EntityManagerInterface $entityManager): Response
    {
        $parametros = json_decode($request->getContent(), TRUE);

        $cubiculo = new Cubiculo();

        $cubiculo->setCapacidad($parametros['capacidad']);

        $entityManager->persist($cubiculo);
        $entityManager->flush();

        return $this->json($cubiculo);
    }
}