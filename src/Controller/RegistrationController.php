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
                    }
                }
            }
        }

        $em = $this->getDoctrine()->getManager();
        $usuarios = $em->getRepository(User::class)->findAll();

        return $this->render('user/index.html.twig');
    }

    public function register(
        $request,
        $passwordEncoder,
       \Swift_Mailer $mailer =null
    ) {
        $user = new User();
        $entityManager = $this->getDoctrine()->getManager();

        $user->setEmail($request->query->get('correo'));
        $user->setCedula($request->query->get('cedula'));
        $user->setNombre($request->query->get('nombre'));
        $user->setApellido($request->query->get('apellido'));
        $user->setRoles([$request->query->get('id_rol')]);
        $codePassword = substr(
            str_shuffle(
                $request->query->get('cedula') . $request->query->get('nombre')
            ),
            0,
            9
        );
        //echo $codePassword;

        // encode the plain password
        $user->setPassword(
            $passwordEncoder->encodePassword($user, $codePassword)
        );

        $entityManager->persist($user);
        $entityManager->flush();

         $asunto = 'CREACION DE CUENTA';

         $message = (new \Swift_Message($asunto))
                 ->setFrom('crisbieber9569@gmail.com')
                 ->setTo('danylove9569@hotmail.com')
                 ->setBody(
                 $this->renderView(
                         'email/registration.html.twig', ['nombre' => $request->query->get('nombre').' '.$request->query->get('apellido'),
                                                     'correo'=>$request->query->get('correo'),
                                                    'contraseña' => $codePassword,
                                                    ]
                 ), 'text/html'
                 );

               $success = $mailer->send($message);
                 return $success;
         return new Response(
                 'ok', Response::HTTP_OK
         );
        // do anything else you need here, like send an email

        return 'si se pudo, si se puede y siempre se podra';
        

        // return $this->render('usuario/index.html.twig');
    }

    public function getUsuariosList()
    {
        $em = $this->getDoctrine()->getManager();
        $usuarios = $em->getRepository(User::class)->findAll();
        $campos = ['Id', 'Cédula', 'Nombre', 'Correo', 'Estado'];
        // dd($usuarios);
        $users = [];
        foreach ($usuarios as $key => $dato) {
            $users[$key] = [
                $dato->getId(),
                $dato->getCedula(),
                $dato->getNombre(),
                $dato->getEmail(),
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
