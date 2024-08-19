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
    // Christopher
    #[Route('/cubiculos/disponibles', name: 'app_cubiculos_disponibles', methods: ['GET'])]
    public function disponibles(Request $request, EntityManagerInterface $entityManager): Response
    {
        // TODO
        // $time = DateTime::createFromFormat('H:i', $request->query->get('time'));
        // $horario = $entityManager->getRepository(Horario::class)->findBy(array('hora' => $time));
        // return $this->json($horario);


    }
    
    // José Baidal
    #[Route('/cubiculos/creados', name: 'app_cubiculos_creados', methods: ['GET'])]
    public function creados(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cubiculosCreados = $entityManager->getRepository(Cubiculo::class)->findAll();

        $data = array_map(function(Cubiculo $cubiculo) {
            return array(
                'id' => $cubiculo->getId(),
                'capacidad' => $cubiculo->getCapacidad()
            );
        }, $cubiculosCreados);

        return $this->json($data);
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
