<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\HttpFoundation\JsonResponse;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */

    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator)
    {
        if ($request->isXmlHttpRequest()) {
            if ($request->getMethod() == 'GET') {
                $tipo = $request->query->get('tipo');
                if ($tipo) {
                    if ($tipo == 1)
                        return new JsonResponse($this->register($request, $passwordEncoder));
                }
            }
        }
        return $this->render('usuario/index.html.twig');
    }

    public function register($request, $passwordEncoder)
    {
        //dd('hello');
        $user = new User();

        //$form = $this->createForm(RegistrationFormType::class, $user);
        //$form->handleRequest($request);
        //if ($form->isSubmitted() && $form->isValid()) {
        //die($request->cedula);
        $entityManager = $this->getDoctrine()->getManager();
        $user->setEmail($request->query->get('correo'));
        $user->setNombre($request->query->get('nombre'));
        $user->setRoles([$request->query->get('id_rol')]);
        // $user->email($request->query->get('correo'));
        // encode the plain password
        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $request->query->get('password')
            )
        );


        $entityManager->persist($user);
        $entityManager->flush();
        // do anything else you need here, like send an email

        return 'si se pudo';
        // }

       // return $this->render('usuario/index.html.twig');
    }
}
