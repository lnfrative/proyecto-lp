<?php

namespace App\Controller;

use App\Entity\Cubiculo;
use App\Entity\Horario;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Clock\MockClock;
use Symfony\Component\Clock\Clock;

use DateTime;

class CubiculosController extends AbstractController
{
    // Christopher
    #[Route('/cubiculos/disponibles', name: 'app_cubiculos_disponibles', methods: ['GET'])]
    public function disponibles(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hora = $request->query->get('hora');

        if (is_null($hora)) {
            return $this->redirectToRoute('app_cubiculos_disponibles', ['hora' => '08:00']); 
        }

        $dateTime = new DateTime();
        $inicio = DateTime::createFromFormat('H:i', $hora);
        
        $cubiculos = $entityManager->getRepository(Cubiculo::class)
            ->createQueryBuilder('c')
            ->select('c, COUNT(r.id) AS reservas_hechas')
            ->leftJoin('c.reservas', 'r')
            ->leftJoin('r.horario', 'h')
            ->where('h.hora = :horaInicio OR h.hora IS NULL')
            ->andWhere('(r.created_at BETWEEN :dateMin AND :dateMax) OR r.id IS NULL')
            ->setParameter('horaInicio', $inicio)
            ->setParameter('dateMin', $dateTime->format('Y-m-d 00:00:00'))
            ->setParameter('dateMax', $dateTime->format('Y-m-d 23:59:59'))
            ->groupBy('c.id')
            ->getQuery()
            ->getResult();
    
    

        // TODO
        // $time = DateTime::createFromFormat('H:i', $request->query->get('time'));
        // $horario = $entityManager->getRepository(Horario::class)->findBy(array('hora' => $time));


        return $this->json($cubiculos);

        // return $this->render('cubiculos/disponibles.html.twig', [
        //     'controller_name' => 'CubiculosController',
        // ]);
    }
    
    // José Baidal
    #[Route('/cubiculos/creados', name: 'app_cubiculos_creados', methods: ['GET'])]
    public function creados(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cubiculos = $entityManager->getRepository(Cubiculo::class)->findAll();

        $cubiculos_data = array_map(function(Cubiculo $cubiculo) {
            return array(
                'id' => $cubiculo->getId(),
                'capacidad' => $cubiculo->getCapacidad()
            );
        }, $cubiculos);

        return $this->render('cubiculos/creados.html.twig', [
            'cubiculos_data' => $cubiculos_data
        ]);
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
