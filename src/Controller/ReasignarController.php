<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Tramite;
use App\Entity\User;
use App\Entity\TipoTramite;
use App\Entity\UsuarioTramite;
use App\Entity\TramiteTransferencia;
use App\Entity\ClienteTramite;

class ReasignarController extends AbstractController
{
    public $tramite;
    /**
     * @Route("/tramite", name="tramite")
     */
    public function getViewTramite(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            if ($request->getMethod() == 'GET') {
                $tipo = $request->query->get('tipo');
                if ($tipo) {
                    if ($tipo == 1) {
                        return new JsonResponse($this->registerTramite());
                    }
                }
            }
        }
        return $this->render('usuario/crearTramite.html.twig');
    }

    public function registerTramite()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        $tipoTramite = $em
            ->getRepository(TipoTramite::class)
            ->find($request->query->get('tipo_tramite'));

        $tramite = new Tramite();
        // relates this tramite to the tipoTramite
        $tramite->setTipoTramite($tipoTramite);
        $tramite->tramite($request->query->get('tramite'));
        $em->persist($tramite);
        $em->flush();

        return 'Saved new tramite';
    }

    public function getTipoTramite()
    {
        $em = $this->getDoctrine()->getManager();
        $tipoTramite = $em->getRepository(TipoTramite::class)->findAll();

        return $this->render('/components/_tipoTramite.html.twig', [
            'tiposTramite' => $tipoTramite,
        ]);
    }

   /**
     * @Route("/procesotramite/{idTramite}", name="procesotramite", requirements={"idTramite"="\d+"})
     */
    public function getProcesoTramiteView($idTramite, Request $request) {
        if ($request->isXmlHttpRequest()) {
            if ($request->getMethod() == 'GET') {
                $tipo = $request->query->get('tipo');
                if ($tipo) {
                    if ($tipo == 10)
                    return new JsonResponse($this->updateProcesoTramite());
                }
            }
        }

        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();
       
        $modi = $em->getRepository(TramiteTransferencia::class)->find($idTramite);
        $idTipoTramiteT = $modi->getIdClienteTramite()->getIdTipoTramiteTransferencia();
        

        $usuario = $em->getRepository(UsuarioTramite::class)->find($idTramite);
        $clienteTramite = $usuario->getIdClienteTramite()->id();
        
        $fecha = $usuario->fecha();
        $userName = $usuario->getIdUsuario()->getNombre();
        $userLastName = $usuario->getIdUsuario()->getApellido();
        $clientName = $usuario->getIdClienteTramite()->getIdCliente()->nombre();
        $clientLastName = $usuario->getIdClienteTramite()->getIdCliente()->apellido();
        $tipoTramite = $usuario->getIdClienteTramite()->getIdTipoTramiteTransferencia()->tramite();
        
        if ($modi)
        $modi = [$modi];       
        
        
        return $this->render('tramite/procesotramite.html.twig',  [
            "informacion" => $modi, 
            "tipoTramite" => $idTipoTramiteT, 
            'fecha' => $fecha,
            'nombreUsuario' => $userName,
            'apellidoUsuario' => $userLastName,
            'nombreCliente' => $clientName, 
            'apellidoCliente' => $clientLastName,
            'tipo' => $tipoTramite,
            'idTramite'=>$idTramite,
            'clienteTramite'=>$clienteTramite,
        ]);
    }

    /**
     * @Route("/actualizarTramite", name="actualizarTramite", methods = "POST")
     */
    
    public function updateProcesoTramite(Request $request) {
        //$request = $this->container->get('request_stack')->getCurrentRequest();
        dd($request);
        // $request2 = $request->isXmlHttpRequest();
        
        // $em = $this->getDoctrine()->getManager();

        // $data = json_decode($request->getContent());

        // dd($_REQUEST);

        //dd($idTramite);

       /* $clienteTramite= $em->getRepository(ClienteTramite::class)->find(1);
        dd($idTramite);
        $tramiteTransferencia= new TramiteTransferencia();
        // relates this tramite to the tipoTramite
        $tramiteTransferencia->setIdClienteTramite($clienteTramite);
        $tramiteTransferencia->cedula('YES');
        $tramiteTransferencia->papeleta('YES');
        $tramiteTransferencia->escrituraBienes('YES');*/
        // $a = json_decode($request->getContent(), true);
       // return $this->json($a);
       
        
       dd('hols');
        //dd($request->query->get('cedula'));
        //dd($request->getMethod());
       $clienteTramite= $em
        ->getRepository(ClienteTramite::class)
        ->find($idTramite);


    $tramiteTransferencia= new TramiteTransferencia();
    // relates this tramite to the tipoTramite
    $tramiteTransferencia->setIdClienteTramite($clienteTramite);
    $tramiteTransferencia->cedula($request->query->get('cedula'));
    $tramiteTransferencia->papeleta($request->query->get('papeleta'));
    $tramiteTransferencia->escrituraBienes($request->query->get('bienes'));
    
       
        $em->persist($tramiteTransferencia);
        $em->flush();

        $response = new JsonResponse();
        $response->setData([
            'succes'=> false,
            ]);

        return $response;
                
       
    }

    public function getData($idTramite){
    //   $request = $this->container->get('request_stack')->getCurrentRequest();
    // $request = $this->container->get('request_stack')->getCurrentRequest();
    // $em = $this->getDoctrine()->getManager();
    // $clienteTramite= $em
    // ->getRepository(ClienteTramite::class)
    // ->find($idTramite);
    dd($idTramite);
    // dd($clienteTramite);
        return $this->render('tramite/modal/_datosProceso.html.twig');
    }

    /**
     * @Route("/historial/{clienteTramite}", name = "historial");
     */
    public function getViewHistorial($clienteTramite){
       
        return $this->render('tramite/reasignar.html.twig', [
            'clienteTramite' => $clienteTramite
        ]);
    }

    public function historial($clienteTramite){
        
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();
            
        $usuarioTramite = $em->getRepository(UsuarioTramite::class)->findBy(['idClienteTramite' => $clienteTramite]);

        $dataHistorial = [];
        foreach($usuarioTramite as $key => $tramite){
            $dataHistorial[$key] = [
                $tramite->getIdUsuario()->getNombre(),
                $tramite->getIdUsuario()->getApellido(),
                $tramite->describe(),
            ];
        }

        // dd($dataHistorial);
        return $this->render('tramite/modal/_historial.html.twig', [
            'datoshistorial' => $dataHistorial
        ]);
    }

    public function getUsers()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findBy(['estado' => 'Activo']);;

        return $this->render('user/modal/_usuarios.html.twig', [
            'usuarios' => $user,
        ]);
    }

    public function reasignar(){

    }

}
