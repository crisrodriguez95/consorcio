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
                    if ($tipo == 1)                       
                        return new JsonResponse($this->registrar());
                }
            }
        }

        return $this->render('cliente/index.html.twig');
    }
    public function registrar()
    {

        $request = $this->container->get('request_stack')->getCurrentRequest();

        $em = $this->getDoctrine()->getManager();

       // die('<pre>'.print_r($request->query->get('cedula'),true).'</pre>');

        if ($this->getDoctrine()->getRepository(Cliente::class)->find($request->query->get('cedula')))
        return 'El cliente que desea registrar ya esta registrado';

        $cliente = new Cliente();

        $cliente->cedula($request->query->get('cedula'));
        $cliente->nombre($request->query->get('nombre'));
        $cliente->apellido($request->query->get('apellido'));
        $cliente->direccion($request->query->get('direccion'));
        $cliente->estadocivil($request->query->get('estadoCivil'));
        $cliente->telefono($request->query->get('telefono'));
        $cliente->movil($request->query->get('celular'));
        $cliente->email($request->query->get('correo'));      
        $em->persist($cliente);
        $em->flush();

        return 'heythere';
    }
}
