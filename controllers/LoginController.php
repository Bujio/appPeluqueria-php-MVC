<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
  public static function login(Router $router)
  {
    $alertas = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $auth = new Usuario($_POST);
      $alertas = $auth->validarLogin();

      if (empty($alertas)) {
        //Comprobar si existe el usuario
        $usuario = Usuario::where('email', $auth->email);
        if ($usuario) {
          //Verificar el password
          if ($usuario->comprobarPasswordAndVerificarlo($auth->password)) {
            //Autentificar Usuario
            session_start();
            $_SESSION['id'] = $usuario->id;
            $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
            $_SESSION['email'] = $usuario->email;
            $_SESSION['login'] = true;

            //Redireccionamiento admin o no
            if ($usuario->admin = '1') {
              $_SESSION['admind'] = $usuario->admin ?? null;
              header('Location: /admin');
            } else {
              header('Location: /cita');
            }
          }
        } else {
          Usuario::setAlerta('error', 'Usuario o password incorrectos');
        }
      }
    }
    $alertas = Usuario::getAlertas();
    $router->render('auth/login', ['alertas' => $alertas]);
  }
  public static function logout()
  {
    echo "desde logout";
  }
  public static function olvide(Router $router)
  {
    $router->render('auth/olvide');
  }
  public static function recuperar()
  {
    echo "recuperar pass";
  }
  public static function crearCuenta(Router $router)
  {
    $usuario = new Usuario($_POST);
    $alertas = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $usuario->sincronizar($_POST);
      $alertas = $usuario->validarNuevaCuenta();

      //Revisar que alertas este vacio
      if (empty($alertas)) {
        //verificar que el usuario no está registrado
        $resultado = $usuario->existeUsuario();
        if ($resultado->num_row) {
          $alertas = Usuario::getAlertas();
        } else {
          //Hashear password
          $usuario->hashPassword();

          //Generar token
          $usuario->crearToken();


          //Enviar el email
          $email = new Email($usuario->nombre, $usuario->email, $usuario->token);

          $email->enviarConfirmacion();

          //Crear Usuario
          $resultado = $usuario->guardar();

          if ($resultado) {
            header('Location: /mensaje');
          }
        }
      }
    }
    $router->render('auth/crear-cuenta', ['usuario' => $usuario, 'alertas' => $alertas]);
  }

  public static function mensaje(Router $router)
  {
    $router->render('auth/mensaje');
  }

  public static function confirmarCuenta(Router $router)
  {
    $alertas = [];
    $token = s($_GET['token']);

    $usuario = Usuario::where('token', $token);

    if (empty($usuario)) {
      Usuario::setAlerta('error', 'Token No Válido');
    } else {
      $usuario->confirmado = '1';
      $usuario->token = null;
      $usuario->guardar();
      Usuario::setAlerta('exito', 'Cuenta Creada Correctamente');
    }
    $alertas = Usuario::getAlertas();
    $router->render('auth/confirmar-cuenta', ['alertas' => $alertas]);
  }

  public static function paginaError(Router $router)
  {
    if (!$_SERVER['REQUEST_URI']) {

      $router->render('templates/paginaError');
    }
  }
}
