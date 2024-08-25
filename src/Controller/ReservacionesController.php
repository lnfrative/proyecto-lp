<?php

namespace App\Controller;

use App\Entity\Reserva;
use App\Entity\Horario;
use App\Entity\Cubiculo;
use App\Entity\ReservaEstado;
use App\Entity\Usuario;

use function Symfony\Component\Clock\now;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\RedirectResponse;

use DateTime;

class ReservacionesController extends AbstractController
{
    // Christopher
    #[Route('/reservaciones/crear', name: 'app_reservaciones_crear', methods: ['POST'])]
    public function crear(Request $request, EntityManagerInterface $entityManager): Response
    {
        $parameters = json_decode($request->getContent(), TRUE);

        $email = $parameters['email'];
        $hora = DateTime::createFromFormat('H:i', $parameters['hora']);
        $numeroDeCubiculo = $parameters['numero_cubiculo'];

        $usuariosEncontrados = $entityManager->getRepository(Usuario::class)->findBy(array('email' => $email));
        $horarioEncontrados = $entityManager->getRepository(Horario::class)->findBy(array('hora' => $hora));
        $reservaEstadoEncontrados = $entityManager->getRepository(ReservaEstado::class)->findBy(array('estado' => 'PENDIENTE'));
        $cubiculo = $entityManager->getRepository(Cubiculo::class)->find($numeroDeCubiculo);
        

        // crear la reserva objeto
        $reserva = new Reserva();
        $reserva->setHorario($horarioEncontrados[0]);
        $reserva->setCubiculo($cubiculo);
        $reserva->setEstado($reservaEstadoEncontrados[0]);
        $reserva->setUsuario($usuariosEncontrados[0]);
        $reserva->setCreatedAt(now());


        // guardar en db
        $entityManager->persist($reserva);
        $entityManager->flush();

        return $this->json(array(
            'reserva_id' => $reserva->getId(),
            'hora' => $horarioEncontrados[0]->getHora()->format('H:i'),
            'estado' => $reservaEstadoEncontrados[0]->getEstado(),
            'cubiculo_id' => $cubiculo->getId(),
            'usuario_email' => $usuariosEncontrados[0]->getEmail(),
        ));
    }

    // Stephany
    #[Route('/reservaciones/aprobadas', name: 'app_reservaciones_aprobadas', methods: ['GET'])]
    public function aprobadas(Request $request, EntityManagerInterface $entityManager): Response
    {
      // filtra reservas que tengan estado APROBADO
      $reservas = $entityManager->getRepository(Reserva::class)
          ->createQueryBuilder('r') // Alias para Reserva
          ->join('r.estado', 'e')    // Join con la entidad ReservaEstado
          ->where('e.estado = :estado') // Filtrar por el estado de ReservaEstado
          ->setParameter('estado', 'APROBADO')
          ->orderBy('r.created_at', 'DESC')
          ->getQuery()
          ->getResult();

      // crea la lista con los datos que devolverá la request
      $reservas_data = array_map(function(Reserva $reserva) {
          return array(
              'reserva_id' => $reserva->getId(),
              'hora' => $reserva->getHorario()->getHora()->format('H:i'),
              'estado' => $reserva->getEstado()->getEstado(),
              'cubiculo_id' => $reserva->getCubiculo()->getId(),
              'usuario_email' => $reserva->getUsuario()->getEmail(),
              'fecha_de_reservacion' => $reserva->getCreatedAt()->format('Y-m-d')
          );
      }, $reservas);

      return $this->render('reservaciones/aprobadas.html.twig', [
        'controller_name' => 'ReservacionesController',
        'titulo' => 'Reservaciones Aprobadas',
        'reservaciones_data' => $reservas_data,
      ]);
  }

    // Stephany
    #[Route('/reservaciones/aprobar', name: 'app_reservaciones_aprobar', methods: ['POST'])]
    public function aprobar(Request $request, EntityManagerInterface $entityManager): Response
    {
      $reservaId = $request->request->get('reserva_id');

      // busca la reserva en la db
      $reserva = $entityManager->getRepository(Reserva::class)->find($reservaId);

      // busca el estado aprobado en la db
      $reservaEstadoAprobado = $entityManager->getRepository(ReservaEstado::class)->find(1);

      // actualiza el estado de la reservacion
      $reserva->setEstado($reservaEstadoAprobado);

      // guardar en db
      $entityManager->persist($reserva);
      $entityManager->flush();

      return $this->redirectToRoute('app_reservaciones_aprobadas'); 
  }

    // Stephany
    #[Route('/reservaciones/cancelar', name: 'app_reservaciones_cancelar', methods: ['POST'])]
    public function cancelar(Request $request, EntityManagerInterface $entityManager): Response
    {
      $reservaId = $request->request->get('reserva_id');

      // busca la reserva en la db
      $reserva = $entityManager->getRepository(Reserva::class)->find($reservaId);

      // busca el estado cancelado en la db
      $reservaEstadoCancelado = $entityManager->getRepository(ReservaEstado::class)->find(4);

      // actualiza el estado de la reservacion
      $reserva->setEstado($reservaEstadoCancelado);

      // guardar en db
      $entityManager->persist($reserva);
      $entityManager->flush();

      return $this->redirectToRoute('app_reservaciones_consultar'); 
    }

    // Stephany
    #[Route('/reservaciones/rechazar', name: 'app_reservaciones_rechazar', methods: ['POST'])]
    public function rechazar(Request $request, EntityManagerInterface $entityManager): Response
    {
      $reservaId = $request->request->get('reserva_id');

      // busca la reserva en la db
      $reserva = $entityManager->getRepository(Reserva::class)->find($reservaId);

      // busca el estado rechazado en la db
      $reservaEstadoRechazado = $entityManager->getRepository(ReservaEstado::class)->find(3);

      // actualiza el estado de la reservacion
      $reserva->setEstado($reservaEstadoRechazado);

      // guardar en db
      $entityManager->persist($reserva);
      $entityManager->flush();

      return $this->redirectToRoute('app_reservaciones_consultar'); 
    }

    // Stephany
    #[Route('/reservaciones/consultar', name: 'app_reservaciones_consultar', methods: ['GET'])]
    public function consultar(Request $request, EntityManagerInterface $entityManager): Response
    {
      $user = $this->getUser();

      $db = $entityManager->getRepository(Reserva::class)
          ->createQueryBuilder('r');
          
      if ($user->getRol()->getRol() == 'Estudiante') {
        $db = $db->join('r.usuario', 'u')
          ->where('u.id = :usuario_id')
          ->setParameter('usuario_id', $user->getId());
      }

      $reservas = $db->orderBy('r.created_at', 'DESC')
        ->getQuery()
        ->getResult();

      $reservas_data = array_map(function(Reserva $reserva) {
        return array(
            'reserva_id' => $reserva->getId(),
            'hora' => $reserva->getHorario()->getHora()->format('H:i'),
            'estado' => $reserva->getEstado()->getEstado(),
            'cubiculo_id' => $reserva->getCubiculo()->getId(),
            'usuario_email' => $reserva->getUsuario()->getEmail(),
            'fecha_de_reservacion' => $reserva->getCreatedAt()->format('Y-m-d')
        );
      }, $reservas);
  
      return $this->render('reservaciones/consultar.html.twig', [
        'reservaciones_data' => $reservas_data
      ]);
    }
}
