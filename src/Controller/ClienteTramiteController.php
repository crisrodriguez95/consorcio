<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\ClienteTramite;
use App\Entity\TipoTramiteTransferencia;
use App\Entity\Cliente;

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
                        // return new JsonResponse($this->funcionairio());
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
    }

    public function funcionairio()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(" SELECT c.funcionario, count(c.funcionario) 
                                  FROM App\Entity\ClienteTramite c
                                  GROUP BY c.funcionario");

        $tramites = $query->getResult();

        $funcionarios = [
            [
                'funcionario' => 'Cristina',
                'value' => 0,
            ],
            [
                'funcionario' => 'Daniela',
                'value' => 0,
            ],
            [
                'funcionario' => 'David',
                'value' => 0,
            ],
        ];

        $funcionario = rand(1, 3);
        // $min = $tramites[0];
        dd($funcionario);

        // for ($i = 0; $i < count($tramites); $i++) {
        //   if ($tramites[$i][1] < $min[1]) {
        //       $min = $tramites[$i];
        //    }
        // }
        // return $min['funcionario'];
    }

    public function getCliente()
    {
        $em = $this->getDoctrine()->getManager();
        $clientes = $em->getRepository(Cliente::class)->findAll();
        

        return $this->render('/components/cliente/_cliente.html.twig', [
            'clientes' => $clientes,
        ]);
    }

    public function getTipoTramite()
    {
        $em = $this->getDoctrine()->getManager();
        $tramite = $em
            ->getRepository(TipoTramiteTransferencia::class)
            ->findAll();

        return $this->render('/components/tramite/_tipoTramite.html.twig', [
            'tiposTramite' => $tramite,
        ]);
    }

    
    public function getClienteTramiteList()
    {
        $em = $this->getDoctrine()->getManager();
        $clientesTramites = $em->getRepository(ClienteTramite::class)->findAll();
    // dd($clientesTramites[0]->getIdTipoTramiteTransferencia()->tramite());
     //print_r($clientesTramites->getIdCliente()->id, true);

        $campos = [
            'Id',
            'Cliente',
            'Tramite',
            'Fecha de Incio',                  
        ];
        $clientsTramite = [];

        foreach ($clientesTramites as $key => $data) {
            
            $clientsTramite[$key] = [
                $data->id(),
                $data->getIdCliente()->nombre(),
                $data->getIdTipoTramiteTransferencia()->tramite(),                
                $data->fechaInicio(),               
            ];
        }

        return $this->render('/components/_tabla.html.twig', [
            'datos' => $clientsTramite,
            'campos' => $campos,
            'crear' => 'Crear tipo de trámite',
            'tituloTabla' => 'Asignacion'
        ]);
    }
}
