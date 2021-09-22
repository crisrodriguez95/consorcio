<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="cliente")
 * @ORM\HasLifecycleCallbacks
 */
class Cliente {
    /**
     * @ORM\Id   
     * @ORM\GeneratedValue(strategy="AUTO")    
     * @ORM\Column(name="ID_CLIENTE", type="integer")
     */
    private $id;

    /**       
     * @ORM\Column(name="CEDULA", type="integer",nullable=false)
     */
    private $cedula;

    /**       
     * @ORM\Column(name="NOMBRE", type="string",nullable=false)
     */
    private $nombre;

    /**       
     * @ORM\Column(name="APELLIDO", type="string",nullable=false)
     */
    private $apellido;
    /**       
     * @ORM\Column(name="ESTADO_CIVIL", type="string",nullable=false)
     */
    private $estadocivil;

    /**       
     * @ORM\Column(name="DIRECCION", type="string",nullable=false)
     */
    private $direccion;

     /**       
     * @ORM\Column(name="TELEFONO", type="integer",nullable=false)
     */
    private $telefono;

     /**       
     * @ORM\Column(name="MOVIL", type="integer",nullable=false)
     */
    private $movil;

     /**       
     * @ORM\Column(name="EMAIL", type="string",nullable=false)
     */
    private $email;

    /**
    *@ORM\OneToMany(targetEntity="App\Entity\ClienteTramite", mappedBy="idCliente")
    */
    private $clienteTramite;

    public function id($value = null) {
        if (!$value)
            return $this->id;

        $this->id = $value;

        return $this;
    }
    public function cedula($value = null) {
        if (!$value)
            return $this->cedula;

        $this->cedula = $value;

        return $this;
    }
    public function nombre($value = null) {
        if (!$value)
            return $this->nombre;

        $this->nombre = $value;

        return $this;
    }
    public function apellido($value = null) {
        if (!$value)
            return $this->apellido;

        $this->apellido = $value;

        return $this;
    }
    public function estadocivil($value = null) {
        if (!$value)
            return $this->estadocivil;

        $this->estadocivil = $value;

        return $this;
    }
    public function direccion($value = null) {
        if (!$value)
            return $this->direccion;

        $this->direccion = $value;

        return $this;
    }
    public function telefono($value = null) {
        if (!$value)
            return $this->telefono;

        $this->telefono = $value;

        return $this;
    }
    public function movil($value = null) {
        if (!$value)
            return $this->movil;

        $this->movil = $value;

        return $this;
    }
    public function email($value = null) {
        if (!$value)
            return $this->email;

        $this->email = $value;

        return $this;
    }


}
    