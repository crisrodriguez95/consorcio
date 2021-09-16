<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use App\Entity\Rol;

/** 
 * @ORM\Entity
 * @ORM\Table(name="funcionario")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(fields="email", message="Email already taken")
 */
class Usuario implements UserInterface
{
  /**
   * @ORM\Id   
   * @ORM\GeneratedValue(strategy="AUTO")    
   * @ORM\Column(name="ID_FUNC", type="integer")
   */
  private $id;

  /**
   * @ORM\ManyToOne(targetEntity="Rol")
   * @ORM\JoinColumn(name="ID_ROL", referencedColumnName="ID_ROL")
   */
  private $roles;

  /**       
   * @ORM\Column(name="CEDULA_FUN", type="integer",nullable=false)
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
   * @ORM\Column(name="EMAIL", type="string",nullable=false)
   */
  private $email;

  public function id($value = null)
  {
    if (!$value)
      return $this->id;

    $this->id = $value;

    return $this;
  }
  public function cedula($value = null)
  {
    if (!$value)
      return $this->cedula;

    $this->cedula = $value;

    return $this;
  }
  public function nombre($value = null)
  {
    if (!$value)
      return $this->nombre;

    $this->nombre = $value;

    return $this;
  }
  public function apellido($value = null)
  {
    if (!$value)
      return $this->apellido;

    $this->apellido = $value;

    return $this;
  }
  public function direccion($value = null)
  {
    if (!$value)
      return $this->direccion;

    $this->direccion = $value;

    return $this;
  }
  public function telefono($value = null)
  {
    if (!$value)
      return $this->telefono;

    $this->telefono = $value;

    return $this;
  }
  public function movil($value = null)
  {
    if (!$value)
      return $this->movil;

    $this->movil = $value;

    return $this;
  }
  public function email($value = null)
  {
    if (!$value)
      return $this->email;

    $this->email = $value;

    return $this;
  }

  public function getUsername()
  {
    return $this->email;
  }
  public function getRoles()
  {

    $rol = $this->rol;

    $rol[] = 'ROLE_USER';
    return array_unique($rol);
  }
  public function setRoles(Rol $rol)
  {
    $this->rol = $rol;

    // $rol[] = 'ROLE_USER';
    return $this;

    //return array_unique($roles);
  }
  
  public function getPassword()
  {
    return $this->password;
  }
  public function getSalt()
  {
    // return $this->salt;
  }
  public function eraseCredentials()
  {
  }
}
