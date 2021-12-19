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
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */

    public function index(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler $guardHandler,
        LoginFormAuthenticator $authenticator
    ) {
        if ($request->isXmlHttpRequest()) {
            if ($request->getMethod() == 'GET') {
                $tipo = $request->query->get('tipo');
                if ($tipo) {
                    if ($tipo == 1) {
                        return new JsonResponse(
                            $this->register($request, $passwordEncoder)
                        );
                    } elseif ($tipo == 2) {
                        return new JsonResponse($this->updateUsuario());
                    } elseif ($tipo == 6) {
                        return new JsonResponse($this->changeEstado());
                    } elseif ($tipo == 7) {
                        return new JsonResponse($this->dataUsuario());
                    }
                }
            }
        }

        $em = $this->getDoctrine()->getManager();
        $usuarios = $em->getRepository(User::class)->findAll();

        return $this->render('user/index.html.twig');
    }

    public function register($request, $passwordEncoder)
    {
        $user = new User();
        $entityManager = $this->getDoctrine()->getManager();

        $user->setEmail($request->query->get('correo'));
        $user->setCedula($request->query->get('cedula'));
        $user->setNombre($request->query->get('nombre'));
        $user->setApellido($request->query->get('apellido'));
        $user->setRoles([$request->query->get('id_rol')]);
        $user->setEstado('Activo');

        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $request->query->get('password')
            )
        );

        $entityManager->persist($user);
        $entityManager->flush();

        return 'Registro ingresado';
    }
    // -------------------- update cliente --------------------

    public function updateUsuario()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        $id = $request->query->get('id');
        $usuario = $em->getRepository(User::class)->find($id);

        $usuario->setEmail($request->query->get('correo'));
        $usuario->setCedula($request->query->get('cedula'));
        $usuario->setNombre($request->query->get('nombre'));
        $usuario->setApellido($request->query->get('apellido'));
        $usuario->setRoles([$request->query->get('id_rol')]);
        $usuario->setEstado($request->query->get('estado'));

        $em->flush();
    }

    // ------------------------------------------
    public function dataUsuario()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $id = $request->query->get('id');

        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository(User::class)->find($id);

        $rol = $usuario->getRoles()[0];
        $dato = [
            'cedula' => $usuario->getCedula(),
            'nombre' => $usuario->getNombre(),
            'apellido' => $usuario->getApellido(),
            'correo' => $usuario->getEmail(),
            'password' => $usuario->getPassword(),
            'rol' => $rol,
            'estado' => $usuario->getEstado(),
        ];

        $data = [
            'datooos' => $dato,
        ];

        return $data;
        // $cliente->estado("Inactivo");
        // $em->flush();
    }

    public function changeEstado()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $id = $request->query->get('id');

        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository(User::class)->find($id);

        $usuario->setEstado('Inactivo');
        $em->flush();
    }

    public function getUsuariosList()
    {
        $em = $this->getDoctrine()->getManager();
        $usuarios = $em->getRepository(User::class)->findAll();
        $campos = ['Cédula', 'Nombre', 'Apellido', 'Correo', 'Rol', 'Estado'];
        // dd($usuarios);
        $users = [];
        foreach ($usuarios as $key => $dato) {
            $users[$key] = [
                $dato->getId(),
                $dato->getCedula(),
                $dato->getNombre(),
                $dato->getApellido(),
                $dato->getEmail(),
                $dato->getRoles()[0],
                $dato->getEstado(),
            ];
        }

        return $this->render('/components/_tabla.html.twig', [
            'datos' => $users,
            'campos' => $campos,
            'tituloTabla' => 'Usuarios',
        ]);
    }

    /**
     *
     * @Route("/tablero", name="tablero")
     */
    public function getDashboard()
    {
        return $this->render('dashboard/index.html.twig');
    }
}
