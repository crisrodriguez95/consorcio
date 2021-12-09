<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Tramite;
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
                if ($tipo) {
                    if ($tipo == 4)
                    return new JsonResponse($this->updateProcesoTramite());
                }
            }
        }

        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();
       
        $modi = $em->getRepository(TramiteTransferencia::class)->find($idTramite);
        $idTipoTramiteT = $modi->getIdClienteTramite()->getIdTipoTramiteTransferencia();
        

        $usuario = $em->getRepository(UsuarioTramite::class)->find($idTramite);
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
            'tipo' => $tipoTramite
        ]);
    }
    
    public function updateProcesoTramite(int $idTramite= 0) {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();
        //dd($idTramite);

       /* $clienteTramite= $em->getRepository(ClienteTramite::class)->find(1);
        dd($idTramite);
        $tramiteTransferencia= new TramiteTransferencia();
        // relates this tramite to the tipoTramite
        $tramiteTransferencia->setIdClienteTramite($clienteTramite);
        $tramiteTransferencia->cedula('YES');
        $tramiteTransferencia->papeleta('YES');
        $tramiteTransferencia->escrituraBienes('YES');*/


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
}
