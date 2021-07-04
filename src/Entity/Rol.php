<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="rol")
 * @ORM\HasLifecycleCallbacks
 */
class Rol
{
    /**
     * @ORM\Id   
     * @ORM\GeneratedValue(strategy="AUTO")    
     * @ORM\Column(name="ID_ROL", type="integer")
     */
    private $id;

    /**       
     * @ORM\Column(name="ROL", type="string",nullable=false)
     */
    private $rol;

    public function id($value = null)
    {
        if (!$value)
            return $this->id;

        $this->id = $value;

        return $this;
    }

    public function rol($value = null)
    {
        if (!$value)
            return $this->rol;

        $this->rol = $value;

        return $this;
    }
}
