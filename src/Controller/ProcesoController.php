<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\TramiteProceso;
use App\Entity\Proceso;
use App\Entity\TipoTramite;

class ProcesoController extends AbstractController {

  /**
   * @Route("/proceso", name="proceso")
   */

  public function getViewProceso(Request $request)
  {
      if ($request->isXmlHttpRequest()) {
          if ($request->getMethod() == 'GET') {
              $tipo = $request->query->get('tipo');
              if ($tipo) {
                  if ($tipo == 1)
                      return new JsonResponse($this->registrar());
              }
          }
      }
      return $this->render('admin/crearProceso.html.twig');
  }

  public function registrar()
    {

        $request = $this->container->get('request_stack')->getCurrentRequest();

        $em = $this->getDoctrine()->getManager();

        //  die('<pre>'.print_r($request->query->get('rol'),true).'</pre>');

        // if ($this->getDoctrine()->getRepository(Proceso::class)->find($request->query->get('')))
        //     return 'El usuario que desea registrar ya esta registrado';

        $proceso = new Proceso();

        $proceso->nombreProceso($request->query->get('proceso'));
        $proceso->detalle($request->query->get('detalle'));
       
        $em->persist( $proceso );
        $em->flush();

        return 'heythere';
    }

    /**
     *@Route("/procesoTramite", name="proceso_tramite")
     */

    public function getViewProcesoTramite(Request $request){

        if ($request->isXmlHttpRequest()) {
            if ($request->getMethod() == 'GET') {
                $tipo = $request->query->get('tipo');
                if ($tipo) {
                    if ($tipo == 1)
                        return new JsonResponse($this->registerProcesoTramite());
                }
            }
        }
        return $this->render('admin/asignarProcesoTramite.html.twig');

    }

    public function registerProcesoTramite(){

        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();


        $tipoTramite = $em->getRepository(TipoTramite::class)
                       ->find($request->query->get("tipo_tramite"));

        $proceso = $em->getRepository(Proceso::class)
                       ->find($request->query->get("proceso"));
             
        // dd($proceso);
       
        $tramiteProceso = new TramiteProceso();
        

        $tramiteProceso->setIdTipoTramite($tipoTramite);
        $tramiteProceso->setIdProceso($proceso);
        $em->persist($tramiteProceso);
        $em->flush();

        return "Saved new tramite";


    }

    public function getTipoTramite(){
        $em = $this->getDoctrine()->getManager();
        $tipoTramite = $em->getRepository(TipoTramite::class)->findAll();

   

        return $this->render("/components/_tipoTramite.html.twig", ["tiposTramite" => $tipoTramite]);
        
    }

    public function getProceso(){

        $em = $this->getDoctrine()->getManager();
        $proceso = $em->getRepository(Proceso::class)->findAll();
        
        // dd($proceso);

        return $this->render("/components/_proceso.html.twig", ["procesos" => $proceso ]);


    }

}