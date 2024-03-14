<?php

namespace Model;

class Usuario extends ActiveRecord
{
  //Base de datos
  protected static $tabla = 'usuarios';
  protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];
  public $id;
  public $nombre;
  public $apellido;
  public $email;
  public $password;
  public $telefono;
  public $admin;
  public $confirmado;
  public $token;

  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->nombre = $args['nombre'] ?? "";
    $this->apellido = $args['apellido'] ?? "";
    $this->email = $args['email'] ?? "";
    $this->password = $args['password'] ?? "";
    $this->telefono = $args['telefono'] ?? "";
    $this->admin = $args['admin'] ?? null;
    $this->confirmado = $args['confirmado'] ?? null;
    $this->token = $args['token'] ?? "";
  }

  //Mensajes de validacion para la creación de la cuenta

  public function validarNuevaCuenta()
  {
    if (!$this->nombre) {
      self::$alertas['error'][] = 'El nombre es obligatorio';
    }
    if (!$this->apellido) {
      self::$alertas['error'][] = 'El apellido es obligatorio';
    }
    if (!$this->email) {
      self::$alertas['error'][] = 'El email es obligatorio';
    }
    if (!$this->password) {
      self::$alertas['error'][] = 'El password es obligatorio';
    }
    if (strlen($this->password) < 6) {
      self::$alertas['error'][] = "El password debe tener al menos 6 caracteres";
    }
    if (strlen($this->telefono) !== 9) {
      self::$alertas['error'][] = "El teléfono debe tener 9 dígitos";
    }

    return self::$alertas;
  }

  public function existeUsuario()
  {
    $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "'LIMIT 1";

    $resultado = self::$db->query($query);

    if ($resultado->num_row) {
      self::$alertas['error'][] = 'El usuario ya está registrado';
    }
    return $resultado;
  }
  public function hashPassword()
  {
    $this->password = password_hash($this->password, PASSWORD_BCRYPT);
  }
}
