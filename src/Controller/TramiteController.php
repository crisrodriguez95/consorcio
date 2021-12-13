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

class TramiteController extends AbstractController
{
    
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
                dd($tipo);
                if ($tipo) {
                    if ($tipo == 10)
                    return new JsonResponse($this->updateProcesoTramite($idTramite));
                }
            }
        }

        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();
        // dd($idTramite);
        $user = $em->getRepository(UsuarioTramite::class)->find($idTramite);
        $idTipoTramiteT = $user->getIdClienteTramite()->getIdTipoTramiteTransferencia();
        $idClienteTramite = $user->getIdClienteTramite()->id();

        $tramiteTransferencia = $em->getRepository(TramiteTransferencia::class)->findBy(['idClienteTramite' => $idClienteTramite ]);
        
        $idTramiteTransferencia = $tramiteTransferencia[0]->id();
        // dd($idTramiteTransferencia);
        $usuario = $em->getRepository(UsuarioTramite::class)->find($idTramite);
        // dd($usuario);
        $clienteTramite = $usuario->getIdClienteTramite()->id();
        
        $fecha = $usuario->fecha();
        $userName = $usuario->getIdUsuario()->getNombre();
        $userLastName = $usuario->getIdUsuario()->getApellido();
        $clientName = $usuario->getIdClienteTramite()->getIdCliente()->nombre();
        $clientLastName = $usuario->getIdClienteTramite()->getIdCliente()->apellido();
        $tipoTramite = $usuario->getIdClienteTramite()->getIdTipoTramiteTransferencia()->tramite();
        
        // if ($modi)
        // $modi = [$modi];   
        
        
        return $this->render('tramite/procesotramite.html.twig',  [
            "informacion" => $tramiteTransferencia, 
            "tipoTramite" => $idTipoTramiteT, 
            'fecha' => $fecha,
            'nombreUsuario' => $userName,
            'apellidoUsuario' => $userLastName,
            'nombreCliente' => $clientName, 
            'apellidoCliente' => $clientLastName,
            'tipo' => $tipoTramite,
            'idTramite'=>$idTramiteTransferencia,
            'tramite' => $idTramite,
            'clienteTramite'=>$clienteTramite,
        ]);
    }

    /**
     * @Route("/actualizarTramite", name="actualizarTramite", methods = "POST")
     */    
    public function updateProcesoTramite(Request $request) {

  
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();
        
        $tramiteTransferencia= $em->getRepository(TramiteTransferencia::class)->find($request->request->get('idTramite'));
        $idTramite = $request->request->get('idTramite');
         
        // ------------------- Primer Proceso ------------------------
        $tramiteTransferencia->cedula($request->request->get('cedula'));
        $tramiteTransferencia->papeleta($request->request->get('papeleta'));
        $tramiteTransferencia->escrituraBienes($request->request->get('bienes'));
        $tramiteTransferencia->estaEnagenado($request->request->get('enagenado'));
        $tramiteTransferencia->minuta($tramiteTransferencia->minuta() ? $tramiteTransferencia->minuta() : $_FILES['minuta']['name'] );
        $tramiteTransferencia->insinuacionDonacion($request->request->get('insinuacionDonacion'));
        $tramiteTransferencia->valoresMunicipio($request->request->get('vmunicipio'));
        $tramiteTransferencia->peticionValores($request->request->get('pvalores'));
        $tramiteTransferencia->pagoValores($tramiteTransferencia->pagoValores() ? $tramiteTransferencia->pagoValores() : $_FILES['comprobantep']['name']);

        //-------------------- Cambiar Estado ---------------------------
        // $usuarioTramite = $em->getRepository(UsuarioTramite::class)->find($idTramite);
        // $usuarioTramite->estadoProceso('EN PROCESO');    
        
        // ------------------- Segundo Proceso ------------------------

        $date = $request->request->get('horaFirma'); 
        $date = new \DateTime(date('d-m-Y H:i:s',strtotime($date)));
        
        $date2 = $request->request->get('fechareunion'); 
        $dateReunion = new \DateTime(date('d-m-Y H:i:s',strtotime($date2)));

        $date3 = $request->request->get('fechaEjecucion'); 
        $dateEjecucion = new \DateTime(date('d-m-Y H:i:s',strtotime($date3)));
       
        $tramiteTransferencia->horaReunion($tramiteTransferencia->horaReunion() ? $tramiteTransferencia->horaReunion() : $date);
        $tramiteTransferencia->fechaReunion($tramiteTransferencia->fechaReunion() ? $tramiteTransferencia->fechaReunion() : $dateReunion);
        $tramiteTransferencia->fechaEjecucion($tramiteTransferencia->fechaEjecucion() ? $tramiteTransferencia->fechaEjecucion() : $dateEjecucion);
        $tramiteTransferencia->retraso($request->request->get('fechareunion'));
        $tramiteTransferencia->pagoTasaNotarial($request->request->get('valorTasaNotarial'));
        $tramiteTransferencia->pagoCompleto($request->request->get('pagoNotarial'));
        $tramiteTransferencia->esMutualista($request->request->get('esMutualista'));
        $tramiteTransferencia->entregadoMutualista($request->request->get('entregadoMutualista'));
        $tramiteTransferencia->documentoFirmado($tramiteTransferencia->documentoFirmado() ? $tramiteTransferencia->documentoFirmado() : $_FILES['documentoFirmado']['name']);
        $tramiteTransferencia->entregadaNotaria($request->request->get('entregaNotaria'));
        $tramiteTransferencia->subirEscritura($tramiteTransferencia->subirEscritura() ? $tramiteTransferencia->subirEscritura() : $_FILES['escritura']['name']);
        $tramiteTransferencia->entregadaRegistroPropiedad($request->request->get('entregaRP'));
        $tramiteTransferencia->clienteAprueba($request->request->get('clienteAprueba'));
        
        // ------------------- Tercer Proceso ------------------------
        $tramiteTransferencia->tituloPagoEntregado($request->request->get('tituloPago'));
        $tramiteTransferencia->tituloPago($request->request->get('pagoTitulo'));
        $tramiteTransferencia->escrituraValida($request->request->get('escrituraVali'));
        $tramiteTransferencia->actaInscripcion($request->request->get('acta'));
        $tramiteTransferencia->actaInscripcion($tramiteTransferencia->actaInscripcion() ? $tramiteTransferencia->actaInscripcion() : $_FILES['acta']['name']);
        $tramiteTransferencia->informeGastos($tramiteTransferencia->informeGastos() ? $tramiteTransferencia->informeGastos() : $_FILES['gastos']['name']);
        $tramiteTransferencia->pagoGastos($request->request->get('pagoGastos'));
        // $tramiteTransferencia->Observa($request->request->get(''));
        // $tramiteTransferencia->actaInscripcion($request->request->get(''));


       
        $em->persist($tramiteTransferencia);
        $em->flush();

        $response = new JsonResponse();
        $response->setData([
            'succes'=> false,
            ]);

        return $response;
                       
    }
   
    /**
     * @Route("/historial/{clienteTramite}/{tramite}", name = "historial");
     */
    public function getViewHistorial(Request $request, $clienteTramite, $tramite) {
        
        if ($request->isXmlHttpRequest()) {
            if ($request->getMethod() == 'GET') {
                $tipo = $request->query->get('tipo');
                if ($tipo) {
                    if ($tipo == 1) {
                        return new JsonResponse($this->reasignar($tramite));
                    }
                }
            }
        }
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

    public function reasignar($tramite){
       
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();
       

        $clienteTramite = $em->getRepository(ClienteTramite::class)->find($request->query->get('tipoTramite'));
        $user = $em->getRepository(User::class)->find($request->query->get('idusuario'));

        $usuarioTramite = new UsuarioTramite();
        
        $usuarioTramite->setIdClienteTramite($clienteTramite);
        $usuarioTramite->setIdUsuario($user);
        $usuarioTramite->estado('Y');
        $usuarioTramite->fecha(date('Y-m-d'));
        $usuarioTramite->describe($request->query->get('descrip'));
        $usuarioTramite->estadoProceso('EN PROCESO');
        
        $em->persist($usuarioTramite);
        

        $usuarioTramite = $em->getRepository(UsuarioTramite::class)->find($tramite);
        $usuarioTramite->estado('N');

        $em->flush();

        return 'heythere';


    }

}
