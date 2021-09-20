<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="proceso")
 * @ORM\HasLifecycleCallbacks
 */

class Proceso {
  /**
   *  @ORM\Id
   *  @ORM\GeneratedValue(strategy="AUTO")
   *  @ORM\Column(name="ID_PROCESO", type="integer")
   */ 

  private $id_proceso;

  /**
   * @ORM\Column(name="NOMBRE_PROCESO", type="string")
   */
  private $nombreProceso; 
  
  /**
   * @ORM\Column(name="DETALLE", type="string")
   */
  private $detalle; 

  /**
   *@ORM\OnetoMany(targetEntity="App\Entity\TramiteProceso", mappedBy="idProceso")
   */
  private $proceso;


  public function id($value = null )  {
    if( !$value )
      return $this->id_proceso;

    $this->id_proceso = $value;

    return $this;
  }

  public function nombreProceso($value = null )  {
    if( !$value )
      return $this->nombreProceso;

    $this->nombreProceso = $value;

    return $this;
  }

  public function detalle($value = null )  {
    if( !$value )
      return $this->detalle;

    $this->detalle = $value;

    return $this;
  }



}




