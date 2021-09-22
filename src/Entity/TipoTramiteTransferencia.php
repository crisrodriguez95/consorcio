<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "Tipos_Tramite_Transferencia")
 * @ORM\HasLifecycleCallbacks
 */

class TipoTramiteTransferencia {

  /**
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")    
   * @ORM\Column(name = "ID_TRAMITE", type = "integer")
   */
  private $id;

  /**
   * @ORM\Column(name = "TRAMITE", type = "string", nullable = false)
   */
  private $tramite; 

  /**
   * @ORM\Column(name = "OBSERVACION", type = "string", nullable = false)
   */
  private $observacion; 

  /**
    *@ORM\OneToMany(targetEntity="App\Entity\ClienteTramite", mappedBy="idTipoTramite")
    */
  private $clienteTramite;

  public function id($value = null){
    if(!$value)
      return $this->id;
    
    $this->id = $value;
    return $this;

  }

  public function tramite($value = null){
    if(!$value)
      return $this->tramite;
    
    $this->tramite = $value;
    return $this;

  }

  public function Observa($value = null){
    if(!$value)
      return $this->observacion;
    
    $this->observacion = $value;
    return $this;

  }

}