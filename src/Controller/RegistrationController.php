<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Entity\UsuarioRol;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'app_registration', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('registration/index.html.twig', [
            'controller_name' => 'RegistrationController',
        ]);
    }

    #[Route('/registration', name: 'app_registration_crear', methods: ['POST'])]
    public function crearUsuario(UserPasswordHasherInterface $passwordHasher, Request $request, EntityManagerInterface $entityManager): Response
    {
        $parameters = json_decode($request->getContent(), true);
    
        if ($parameters['email'] && $parameters['password']) {
            $rol = $entityManager->getRepository(UsuarioRol::class)->find(1);

            $usuario = new Usuario();

            $hashedPassword = $passwordHasher->hashPassword(
                $usuario,
                $parameters['password']
            );

            $usuario->setEmail($parameters['email']);
            $usuario->setRol($rol);
            $usuario->setPassword($hashedPassword);

            $entityManager->persist($usuario);
            $entityManager->flush();
        }

        return $this->json([$parameters]);
    }
}
