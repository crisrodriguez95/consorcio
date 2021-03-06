<?php

namespace App\Controller;

use App\Security\LoginFormAuthenticateAuthenticator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use App\Entity\User;

class SecurityController extends AbstractController
{
    /**
     * 
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_register');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * 
     * @Route("/login_api", name="login_api")
     */
    public function login_api(UserPasswordEncoderInterface $encoder, Request $request, LoginFormAuthenticateAuthenticator $loginFormAuthenticateAuthenticator): JsonResponse
    {   
        $em = $this->getDoctrine()->getManager();
         $credentials = [
              'email' => $request->request->get('email'),
              'password' => $request->request->get('password'),
          ];
      
           //die( '<pre>'.print_r(json_decode($request->request->get('email'),false), true).'</pre>' ) ;
        
        
        $user = $em
        ->getRepository(User::class)
        ->findBy(['email'=>$credentials['email']]);
     
        $response = new JsonResponse();
        $is_correct = $encoder->isPasswordValid($user[0], $credentials['password']);
        $is_correct = $loginFormAuthenticateAuthenticator->checkCredentials($credentials, $user[0]);
            
        if ($is_correct) {
            $response->setData([
                'succes'=> true,
                'user_id'=> $user[0]->getId(),
                'email'=> $user[0]->getEmail(),
               'nombre'=> $user[0]->getNombre(),
               'apellido'=>$user[0]->getApellido(),
               'cedula'=>$user[0]->getCedula(),
               'estado'=>$user[0]->getEstado()

            ]);
        }else{
            $response->setData([
                'succes'=> false,
                'code'    => '404',
                ]);
        }

        
        return $response;
    }

    /**
     * 
     * @Route("/consulta_api", name="consulta_api")
     */
    public function consulta_api(Request $request): Response
    {   
        
        $em = $this->getDoctrine()->getManager();
        $user_id = $request->get('id');
      //  $user_id = 16;
        $RAW_QUERY = 'SELECT user.nombre as "nombre_usuario", user.apellido as "apellido_usuario", user.cedula as "cedula_usuario", tipos_tramite_transferencia.TRAMITE, cliente.NOMBRE as "nombre_cliente", cliente.APELLIDO as "apellido_cliente", cliente.CEDULA as "cliente_c??dula", usuario_tramite.FECHA, estado_proceso from usuario_tramite, cliente_tramite, user, tipos_tramite_transferencia, cliente
        where usuario_tramite.ID_CLIENTETRAMITE = cliente_tramite.ID_CLIENTETRAMITE 
        and  usuario_tramite.ID_FUNC = user.id
        and cliente_tramite.ID_TRAMITE = tipos_tramite_transferencia.ID_TRAMITE 
        and cliente_tramite.ID_CLIENTE = cliente.ID_CLIENTE
        and usuario_tramite.ESTADO = "Y"

        and user.id='. $user_id.';';
        
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();

        $result = $statement->fetchAll();
        //dd($result);
       $response = new JsonResponse();
       $response->setData([
        'succes'=> true,
        'data'=> $result

    ]);
        return $response;
    }

    
}
