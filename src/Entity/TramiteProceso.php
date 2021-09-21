<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="proceso_Tipotramite")
 * @ORM\HasLifecycleCallbacks
 */
class TramiteProceso {
  /**
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(name="ID_PROCESOTRAMITE", type="integer")
   */
  private $id;

  /**
   *@ORM\ManyToOne(targetEntity="App\Entity\Proceso", inversedBy="proceso")
   *@ORM\JoinColumn(name="ID_PROCESO", referencedColumnName="ID_PROCESO")
   */
  private $idProceso;
  
  /**
   *@ORM\ManyToOne(targetEntity="App\Entity\TipoTramite", inversedBy="tramiteProceso")
   *@ORM\JoinColumn(name="ID_TIPO", referencedColumnName="ID_TIPO")
   */
  private $idTipoTramite; 



  function id($value = null){
    if (!$value)
      return $this->id;
    
    $this->id = $value;
    return $this;

  }

  public function setIdProceso(Proceso $proceso): self {

    $this->idProceso = $proceso;
    return $this;
    
  }

  public function setIdTipoTramite(TipoTramite $tipoTramite): self{

    $this->idTipoTramite = $tipoTramite;
    return $this;

  }


}

