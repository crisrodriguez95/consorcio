<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/** 
 * @ORM\Entity
 * @ORM\Table(name="tramite")
 * @ORM\HasLifecycleCallbacks
 */
class Tramite {
    /**
     * @ORM\Id   
     * @ORM\GeneratedValue(strategy="AUTO")    
     * @ORM\Column(name="ID_TRAMITE", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="TRAMITE", type="string", nullable=false)
     */
    private $tramite;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TipoTramite", inversedBy="tramites")
     * @ORM\JoinColumn(name="ID_TIPO", nullable=false, referencedColumnName="ID_TIPO")
     */
    private $tipoTramite;


    // public function setTipoTramite(TipoTramite $tipoTramite): self
    // {
    //     $this->tipoTramite = $tipoTramite;

    //     return $this;
    // }

    public function setTipoTramite(TipoTramite $tipoTramite){
        
        $tipoTramite->addTramites($this);
        $this->tipoTramite = $tipoTramite;
        return $this;
  }

    public function id($value = null) {
        if (!$value)
            return $this->id;

        $this->id = $value;

        return $this;
    }
    

    public function tramite($value = null) {
        if(!$value)
            return $this->tramite;

        $this->tramite = $value;
        return $this;

    }


}
    