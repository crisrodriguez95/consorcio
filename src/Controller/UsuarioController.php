<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Entity\Rol;
use App\Entity\Usuario;

class UsuarioController extends AbstractController
{
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException(
            'This method can be blank - it will be intercepted by the logout key on your firewall.'
        );
    }

    public function index(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            if ($request->getMethod() == 'GET') {
                $tipo = $request->query->get('tipo');
                if ($tipo) {
                    if ($tipo == 1) {
                        return new JsonResponse($this->registerUsuario());
                    }else if ($tipo == 7){
                        
                        return new JsonResponse($this->dataUsuario());
                    }
                }
            }
        }
        // return $this->render('usuario/index.html.twig');
    }

    public function getRol()
    {
        $em = $this->getDoctrine()->getManager();
        $rol = $em->getRepository(Rol::class)->findAll();

        return $this->render('/components/_rol.html.twig', ['roles' => $rol]);
    }

    public function registerUsuario()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();

        $em = $this->getDoctrine()->getManager();

        if (
            $this->getDoctrine()
                ->getRepository(Usuario::class)
                ->find($request->query->get('cedula'))
        ) {
            return 'El usuario que desea registrar ya esta registrado';
        }

        $usuario = new Usuario();

        $usuario->setRoles($request->query->get('id_rol'));
        $usuario->cedula($request->query->get('cedula'));
        $usuario->nombre($request->query->get('nombre'));
        $usuario->apellido($request->query->get('apellido'));
        $usuario->email($request->query->get('correo'));
        $em->persist($usuario);
        $em->flush();

        return 'heythere';
    }


   
}
