<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\ClienteTramite;
use App\Entity\TipoTramiteTransferencia;
use App\Entity\TramiteTransferencia;
use App\Entity\Cliente;
use App\Entity\User;
use App\Entity\UsuarioTramite;

class ClienteTramiteController extends AbstractController
{
    /**
     * @Route("/clienteTramite", name="clienteTramite");
     */

    public function getViewTramite(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            if ($request->getMethod() == 'GET') {
                $tipo = $request->query->get('tipo');
                if ($tipo) {
                    if ($tipo == 1) {
                        return new JsonResponse(
                            $this->registerClienteTramite()
                        );
                    }else if($tipo == 2){
                        return new JsonResponse($this->updateClienteTramite());                   
                    }else if($tipo == 7){
                        return new JsonResponse($this->dataClienteTramite());
                    }
                }
            }
        }
        return $this->render('tramite/clienteTramite.html.twig');
    }

    public function registerClienteTramite()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        // _------ Registering table Cliente trámite ------
        $cliente = $em
            ->getRepository(Cliente::class)
            ->find($request->query->get('cliente'));

        $TipoTramite = $em
            ->getRepository(TipoTramiteTransferencia::class)
            ->find($request->query->get('tipo_tramite'));

        $clienteTramite = new ClienteTramite();

        $clienteTramite->setIdCliente($cliente);
        $clienteTramite->setIdTipoTramite($TipoTramite);
        $clienteTramite->fechaInicio(date('Y-m-d'));

        $em->persist($clienteTramite);
        $em->flush();

        // ------ Registering table Usuario trámite ------

        $users = $em
            ->getRepository(User::class)
            ->findBy(['estado' => 'Activo']);

        $usuariosTramites = $em
            ->getRepository(UsuarioTramite::class)
            ->findAll();

        $idUsuarios = [];

        foreach ($users as $key => $user) {
            $idUsuarios[$key] = $user->getId();
        }

        $countUsuarios = count($idUsuarios);
        //dd($idUsuarios);
        if (count($usuariosTramites) > 0) {
            $usersTramites = [];

            foreach ($idUsuarios as $key => $idUsuario) {
                $users = $em
                    ->getRepository(UsuarioTramite::class)
                    ->findByIdUser($idUsuario);

                $tipoTramitesId = [];
                if (count($users) <= 0) {
                    $tipoTramitesId = 0;
                } else {
                    foreach ($users as $key => $user) {
                        $tipoTramiteId = $user
                            ->getIdClienteTramite()
                            ->getIdTipoTramiteTransferencia()
                            ->id();

                        $tipoTramitesId[] = $tipoTramiteId;
                    }
                }
                $usersTramites[$idUsuario] = $tipoTramitesId;
            }

            $cargaUsuario = [];
            foreach ($usersTramites as $key => $userTramite) {
                $suma = 0;

                if ($userTramite != 0) {
                    foreach ($userTramite as $tipoTramite) {
                        $tiposTramites = $em
                            ->getRepository(TipoTramiteTransferencia::class)
                            ->find($tipoTramite);

                        $tiempo = $tiposTramites->pesoTiempo();
                        $carga = $tiposTramites->pesoCarga();

                        $suma += $tiempo + $carga;
                    }
                    $cargaUsuario[$key] = $suma;
                } else {
                    $cargaUsuario[$key] = $userTramite;
                }
            }

            $menor = min($cargaUsuario);
            $id = [];
            function getUsuario($x, $menor)
            {
                foreach ($x as $key => $usuario) {
                    if ($usuario == $menor) {
                        $id[] = $key;
                    }
                }
                return $id;
            }

            $u = getUsuario($cargaUsuario, $menor);
            if (count($u) > 1) {
                $randomUsuario = rand(0, count($u) - 1);
                $getUsuario = $u[$randomUsuario];
                $user = $em->getRepository(User::class)->find($getUsuario);
            } else {
                $user = $em->getRepository(User::class)->find($u[0]);
            }
        } else {
            $randomUsuario = rand(0, $countUsuarios - 1);
            $getUsuario = $idUsuarios[$randomUsuario];
            $user = $em->getRepository(User::class)->find($getUsuario);
        }

        $clienTrami = $em
            ->getRepository(ClienteTramite::class)
            ->find($clienteTramite->id());

        $usuarioTramite = new UsuarioTramite();
        $usuarioTramite->setIdClienteTramite($clienTrami);
        $usuarioTramite->setIdUsuario($user);
        $usuarioTramite->estado('Y');
        $usuarioTramite->fecha(date('Y-m-d'));
        $usuarioTramite->describe('');
        $usuarioTramite->estadoProceso('NO INICIADO');


        $em->persist($usuarioTramite);
        

        $tramiteTransferencia= new TramiteTransferencia();
        $tramiteTransferencia->setIdClienteTramite($clienteTramite);
        
        $em->persist($tramiteTransferencia);
        $em->flush();


    }

    public function getCliente()
    {
        $em = $this->getDoctrine()->getManager();
        $clientes = $em->getRepository(Cliente::class)->findBy(['estado' => 'Activo']);;

        return $this->render('client/modal/_cliente.html.twig', [
            'clientes' => $clientes,
        ]);
    }

    public function getTipoTramite()
    {
        $em = $this->getDoctrine()->getManager();
        $tramite = $em
            ->getRepository(TipoTramiteTransferencia::class)
            ->findAll();
        return $this->render('tramite/modal/_tipoTramite.html.twig', [
            'tiposTramite' => $tramite,
        ]);
    }

    // -------------------- update cliente trámite -------------------- 

    public function updateClienteTramite(){
    
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();
  
        $id = $request->query->get('id');
        $clienteTramite = $em->getRepository(ClienteTramite::class)->find($id);

        $cliente = $em
            ->getRepository(Cliente::class)
            ->find($request->query->get('cliente'));

        $TipoTramite = $em
            ->getRepository(TipoTramiteTransferencia::class)
            ->find($request->query->get('tipo_tramite'));

  
          $clienteTramite->setIdCliente($cliente);
          $clienteTramite->setIdTipoTramite($TipoTramite);
         
          $em->flush();
      }

    // -----------------------Data cliente trámite--------------
    public function dataClienteTramite(){
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $id = $request->query->get('id');

        $em = $this->getDoctrine()->getManager();
        $clienteTramite = $em->getRepository(Cliente::class)->find($id);
        
        $dato = [
          'cliente' => $clienteTramite->getIdCliente(),
          'tipo' => $clienteTramite->getIdTipoTramiteTransferencia(),
        ];

       $data = [
           'datooos' => $dato
       ];

        return $data;
    
    }
    // --------------------------------------------------------------
    public function getClienteTramiteList()
    {
        $em = $this->getDoctrine()->getManager();
        $clientesTramites = $em
            ->getRepository(ClienteTramite::class)
            ->findAll();
        // dd($clientesTramites[0]->getIdTipoTramiteTransferencia()->tramite());
        //print_r($clientesTramites->getIdCliente()->id, true);

        $campos = ['Cliente Nombre', 'Cliente Apellido', 'Tramite', 'Fecha de Incio'];
        $clientsTramite = [];

        foreach ($clientesTramites as $key => $data) {
            $clientsTramite[$key] = [
                $data->id(),
                $data->getIdCliente()->nombre(),
                $data->getIdCliente()->apellido(),
                $data->getIdTipoTramiteTransferencia()->tramite(),
                $data->fechaInicio(),
            ];
        }

        return $this->render('/components/_tabla.html.twig', [
            'datos' => $clientsTramite,
            'campos' => $campos,
            'crear' => ' Asignar tipo trámite a cliente',
            'tituloTabla' => 'Asignacion',
        ]);
    }
}
