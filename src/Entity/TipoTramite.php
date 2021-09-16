<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/** 
 * @ORM\Entity
 * @ORM\Table(name="tipo_tramite")
 * @ORM\HasLifecycleCallbacks
 */
class TipoTramite {
    /**
     * @ORM\Id   
     * @ORM\GeneratedValue(strategy="AUTO")    
     * @ORM\Column(name="ID_TIPO", type="integer")
     */
    private $id;

    /**       
     * @ORM\Column(name="NOMBRE_TIPO", type="string",nullable=false)
     */
    private $tipoTramite;

    /**
     *@ORM\OneToMany(targetEntity="App\Entity\Tramite", mappedBy="tipoTramite") 
    */
    private $tramites;

    /**
     *@ORM\OneToMany(targetEntity="App\Entity\TramiteProceso", mappedBy="idTipoTramite")
     */
     private $tramiteProceso;



    public function __construct()
    {
        $this->tramites = new ArrayCollection();
    }

      /**
     * @return Collection|Tramite[]
     */

    public function getTramites(): Collection
    {
        return $this->tramites;
    }
    
    public function addTramites(Tramite $tramite): self
    {
        $this->tramites[] = $tramite;       
        return $this;
    }


    public function id($value = null) {
        if (!$value)
            return $this->id;

        $this->id = $value;

        return $this;
    }
    

    public function tipoTramite($value = null) {
        if(!$value)
            return $this->tipoTramite;

        $this->tipoTramite = $value;
        return $this;

    }


}
    