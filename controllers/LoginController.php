<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;

class LoginController
{
  public static function login(Router $router)
  {
    $router->render('auth/login');
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
        }else{
          //Hashear password
          $usuario->hashPassword();
          
        }
      }
    }
    $router->render('auth/crear-cuenta', ['usuario' => $usuario, 'alertas' => $alertas]);
  }
}
