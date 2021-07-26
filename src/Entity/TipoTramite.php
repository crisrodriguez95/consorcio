<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    