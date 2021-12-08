<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\UsuarioTramite;

class ReportesController extends AbstractController {

  /**
   * @Route("/download", name = "download" )
   */
  public function getRegistro(Request $request)
  {
      return $this->render('base.html.twig');
  }

  public function getUsuario(){

    $request = $this->container->get('request_stack')->getCurrentRequest();
    $em = $this->getDoctrine()->getManager();

    $query = $em->createQuery(
        "SELECT u.cedula, u.nombre, u.apellido, COUNT(u.id)
        FROM App:UsuarioTramite p, App:User u 
        WHERE p.idUser = u.id 
        GROUP BY p.idUser "
    );
    
    $usuarioTramite = $query->getResult();


    if(!$usuarioTramite)
    exit('no hay registros 2');


    $nombre = 'trámites.xls';
    
    header("Content-Disposition: attachment; filename=$nombre");
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Transfer-Encoding: binary");

    echo "Reporte de trámites gestionados por usuario";

    echo "<table style='border: 2px solid black'>"; 
    
    echo "<tr>";
        echo "<th>Fecha de emisión</th>";
        echo " <th colspan='2'>".date("Y-m-d H:i:s")."</th>"; 
    echo "</tr>";

    echo "<tr>
            <th> Cédula</th> 
            <th> Nombre</th> 
            <th> Apellido</th> 
            <th> Número de támites gestionados</th> 
        </tr>";
    
        
    foreach ($usuarioTramite as $valores) {
        
        echo "<tr>";    
            echo "<td>".$valores['cedula']."</td>";
            echo "<td>".$valores['nombre']."</td>";
            echo "<td>".$valores['apellido']."</td>";
            echo "<td>".$valores[1]."</td>";      
        echo "</tr>";
      
    }
    
    echo "</table>";
    
        exit;

  }
  
  /**
   * @Route("/reporte", name = "reporte")
   */
  public function index(Request $request){
      return $this->render('reporte.html.twig');
    }
    
    public function getTramite(){
  
      $request = $this->container->get('request_stack')->getCurrentRequest();
      $em = $this->getDoctrine()->getManager();
  

      $query = $em->createQuery(
          "SELECT t.tramite, COUNT(u.id)
          FROM App:UsuarioTramite p, App:User u, App:ClienteTramite c, App:TipoTramiteTransferencia t 
          WHERE p.idUser = u.id 
          AND p.idClienteTramite = c.id
          AND c.idTipoTramite = t.id
          GROUP BY t.tramite "
      );
      
      $tramite = $query->getResult();
  
  
      if(!$tramite)
      exit('no hay registros 2');
  
  
      $nombre = 'trámites.xls';
      
      header("Content-Disposition: attachment; filename=$nombre");
      header("Content-Type: application/vnd.ms-excel");
      header("Content-Transfer-Encoding: binary");
  
      echo "<table>"; 
      
      echo "<tr>
              <th>Trámite</th> 
              <th>Número de támites por tipo</th> 
          </tr>";
      
          
      foreach ($tramite as $valores) {
          echo "<tr>";    
              echo "<td>".$valores['tramite']."</td>";
              echo "<td>".$valores[1]."</td>";     
          echo "</tr>";
        
      }
      
      echo "</table>";
      
          exit;
  
    }

}



?>