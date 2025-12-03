<?php

namespace Controllers;

use MVC\Router;

class CitaController{
    public static function index(Router $router){
        iniciarSesion();
        $isAuth = $_SESSION['login'] ?? false;

        $router->render("cita/index",[
            'nombre' => $_SESSION['nombre'] ?? '',
            'id' => $_SESSION['id'] ?? '',
            "isAuth" => $isAuth
        ]);
    }
}