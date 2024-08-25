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

use Doctrine\ORM\Query\Expr\Join;

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

        $date = new DateTime();

        $inicioDelDia = clone $date->setTime(0, 0, 0);
        $finDelDia = clone $date->setTime(23, 59, 59);

        $db = $entityManager->createQueryBuilder()
            ->select('c.id, c.capacidad')
            ->addSelect('c.capacidad - COALESCE(SUM(CASE WHEN r.created_at BETWEEN :inicioDelDia AND :finDelDia AND h.hora = :hora THEN 1 ELSE 0 END), 0) AS disponibles')
            ->from('App\Entity\Cubiculo', 'c')
            ->leftJoin('App\Entity\Reserva', 'r', Join::WITH, 'c.id = r.cubiculo')
            ->leftJoin('App\Entity\Horario', 'h', Join::WITH, 'r.horario = h.id')
            ->groupBy('c.id')
            ->having('c.capacidad - COALESCE(SUM(CASE WHEN r.created_at BETWEEN :inicioDelDia AND :finDelDia AND h.hora = :hora THEN 1 ELSE 0 END), 0) > 0')
            ->setParameter('hora', $hora)
            ->setParameter('inicioDelDia', $inicioDelDia)
            ->setParameter('finDelDia', $finDelDia);
    
        $cubiculos = $db->getQuery()->getResult();

        return $this->render('cubiculos/disponibles.html.twig', [
            'cubiculos_data' => $cubiculos,
        ]);
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
