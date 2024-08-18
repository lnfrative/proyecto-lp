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

use DateTime;

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
      // filtra reservas que tengan estado APROBADO
      $reservas = $entityManager->getRepository(Reserva::class)
          ->createQueryBuilder('r') // Alias para Reserva
          ->join('r.estado', 'e')    // Join con la entidad ReservaEstado
          ->where('e.estado = :estado') // Filtrar por el estado de ReservaEstado
          ->setParameter('estado', 'APROBADO')
          ->getQuery()
          ->getResult();

      // crea la lista con los datos que devolverá la request
      $data = array_map(function(Reserva $reserva) {
          return array(
              'reserva_id' => $reserva->getId(),
              'hora' => $reserva->getHorario()->getHora()->format('H:i'),
              'estado' => $reserva->getEstado()->getEstado(),
              'cubiculo_id' => $reserva->getCubiculo()->getId(),
              'usuario_email' => $reserva->getUsuario()->getEmail(),
              'fecha_de_reservacion' => $reserva->getCreatedAt()->format('Y-m-d H:i:s')
          );
      }, $reservas);

      return $this->json($data);
  }

    // Stephany
    #[Route('/reservaciones/aprobar', name: 'app_reservaciones_aprobar', methods: ['POST'])]
    public function aprobar(Request $request, EntityManagerInterface $entityManager): Response
    {
      $parameters = json_decode($request->getContent(), TRUE);

      $reservaId = $parameters['reserva_id'];

      // busca la reserva en la db
      $reserva = $entityManager->getRepository(Reserva::class)->find($reservaId);

      // busca el estado aprobado en la db
      $reservaEstadoAprobado = $entityManager->getRepository(ReservaEstado::class)->find(1);

      // actualiza el estado de la reservacion
      $reserva->setEstado($reservaEstadoAprobado);

      // guardar en db
      $entityManager->persist($reserva);
      $entityManager->flush();

      return $this->json(array(
          'reserva_id' => $reserva->getId(),
          'hora' => $reserva->getHorario()->getHora()->format('H:i'),
          'estado' => $reserva->getEstado()->getEstado(),
          'cubiculo_id' => $reserva->getCubiculo()->getId(),
          'usuario_email' => $reserva->getUsuario()->getEmail(),
          'fecha_de_reservacion' => $reserva->getCreatedAt()->format('Y-m-d H:i:s')
      ));
  }

    // Stephany
    #[Route('/reservaciones/cancelar', name: 'app_reservaciones_cancelar', methods: ['POST'])]
    public function cancelar(Request $request, EntityManagerInterface $entityManager): Response
    {
      $parameters = json_decode($request->getContent(), TRUE);

      $reservaId = $parameters['reserva_id'];

      // busca la reserva en la db
      $reserva = $entityManager->getRepository(Reserva::class)->find($reservaId);

      // busca el estado cancelado en la db
      $reservaEstadoCancelado = $entityManager->getRepository(ReservaEstado::class)->find(4);

      // actualiza el estado de la reservacion
      $reserva->setEstado($reservaEstadoCancelado);

      // guardar en db
      $entityManager->persist($reserva);
      $entityManager->flush();

      return $this->json(array(
          'reserva_id' => $reserva->getId(),
          'hora' => $reserva->getHorario()->getHora()->format('H:i'),
          'estado' => $reserva->getEstado()->getEstado(),
          'cubiculo_id' => $reserva->getCubiculo()->getId(),
          'usuario_email' => $reserva->getUsuario()->getEmail(),
          'fecha_de_reservacion' => $reserva->getCreatedAt()->format('Y-m-d H:i:s')
      ));
  }

    // Stephany
    #[Route('/reservaciones/rechazar', name: 'app_reservaciones_rechazar', methods: ['POST'])]
    public function rechazar(Request $request, EntityManagerInterface $entityManager): Response
    {
      $parameters = json_decode($request->getContent(), TRUE);

      $reservaId = $parameters['reserva_id'];

      // busca la reserva en la db
      $reserva = $entityManager->getRepository(Reserva::class)->find($reservaId);

      // busca el estado rechazado en la db
      $reservaEstadoRechazado = $entityManager->getRepository(ReservaEstado::class)->find(3);

      // actualiza el estado de la reservacion
      $reserva->setEstado($reservaEstadoRechazado);

      // guardar en db
      $entityManager->persist($reserva);
      $entityManager->flush();

      return $this->json(array(
          'reserva_id' => $reserva->getId(),
          'hora' => $reserva->getHorario()->getHora()->format('H:i'),
          'estado' => $reserva->getEstado()->getEstado(),
          'cubiculo_id' => $reserva->getCubiculo()->getId(),
          'usuario_email' => $reserva->getUsuario()->getEmail(),
          'fecha_de_reservacion' => $reserva->getCreatedAt()->format('Y-m-d H:i:s')
      ));
  }

    // Stephany
    #[Route('/reservaciones/consultar', name: 'app_reservaciones_consultar', methods: ['GET'])]
    public function consultar(Request $request, EntityManagerInterface $entityManager): Response
    {
      $email = $request->query->get('email');

      $usuariosEncontrados = $entityManager->getRepository(Usuario::class)->findBy(array('email' => $email));
      $usuario = $usuariosEncontrados[0];

      // filtra reservas que tengan el ID del usurio
      $reservas = $entityManager->getRepository(Reserva::class)
          ->createQueryBuilder('r') // Alias para Reserva
          ->join('r.usuario', 'u')    // Join con la entidad Usuario
          ->where('u.id = :usuario_id') // Filtrar por el id de usuario
          ->setParameter('usuario_id', $usuario->getId())
          ->getQuery()
          ->getResult();


          $data = array_map(function(Reserva $reserva) {
              return array(
                  'reserva_id' => $reserva->getId(),
                  'hora' => $reserva->getHorario()->getHora()->format('H:i'),
                  'estado' => $reserva->getEstado()->getEstado(),
                  'cubiculo_id' => $reserva->getCubiculo()->getId(),
                  'usuario_email' => $reserva->getUsuario()->getEmail(),
                  'fecha_de_reservacion' => $reserva->getCreatedAt()->format('Y-m-d H:i:s')
              );
          }, $reservas);
  
          return $this->json($data);
  }
}