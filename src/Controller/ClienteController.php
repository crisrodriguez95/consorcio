<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Cliente;

class ClienteController extends AbstractController
{
    /**
     * @Route("/cliente", name="cliente")
     */
    public function getView(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            if ($request->getMethod() == 'GET') {
                $tipo = $request->query->get('tipo');
                if ($tipo) {
                    if ($tipo == 1) {
                        return new JsonResponse($this->registrar());
                    }else if($tipo == 6){
                        return new JsonResponse($this->deleteClient());
                        
                    }
                }
            }
        }
        return $this->render('client/cliente.html.twig');
    }

    public function registrar()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();

        $em = $this->getDoctrine()->getManager();

        // die('<pre>'.print_r($request->query->get('cedula'),true).'</pre>');

        if (
            $this->getDoctrine()
                ->getRepository(Cliente::class)
                ->find($request->query->get('cedula'))
        ) {
            return 'El cliente que desea registrar ya esta registrado';
        }

        $cliente = new Cliente();

        $cliente->cedula($request->query->get('cedula'));
        $cliente->nombre($request->query->get('nombre'));
        $cliente->apellido($request->query->get('apellido'));
        $cliente->direccion($request->query->get('direccion'));
        $cliente->estadocivil($request->query->get('estadoCivil'));
        $cliente->telefono($request->query->get('telefono'));
        $cliente->movil($request->query->get('celular'));
        $cliente->email($request->query->get('correo'));
        $cliente->estado('Activo');
        $em->persist($cliente);
        $em->flush();

        return 'heythere';
    }
    // -------------------- Delete cliente -------------------- 
    public function deleteClient(){
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $id = $request->query->get('id');

        $em = $this->getDoctrine()->getManager();
        $cliente = $em->getRepository(Cliente::class)->find($id);
        
        
        $cliente->estado("Inactivo");
        $em->flush();
    }

    // -------------------- Rendering clientes --------------------
    public function getClienteList()
    {
        $em = $this->getDoctrine()->getManager();
        $clientes = $em->getRepository(Cliente::class)->findAll();

        $campos = [
            'Cédula',
            'Nombre',
            'Estado Civil',
            'Dirección',
            'Teléfono',
            'Movil',
            'Email',
            'Estado'
        ];
        $clients = [];
        
        // $idClients = [];

        foreach ($clientes as $key => $data) {
            // print_r($data->id());
            // array_push($idClients, $data->id());
            $clients[$key] = [
                $data->id(),
                $data->cedula(),
                $data->nombre(),
                $data->estadocivil(),
                $data->direccion(),
                $data->telefono(),
                $data->movil(),
                $data->email(),
                $data->estado()
            ];
        }
        // dd($clients);
        
        return $this->render('/components/_tabla.html.twig', [
            'datos' => $clients,
            'campos' => $campos,
            'crear' => 'Crear nuevo cliente',
            'tituloTabla' => 'Clientes',
            
            
        ]);
    }
}
