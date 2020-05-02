<?php

/**
* Cria uma instância do controlador para uso
*/
include_once('app/controladores/Login.php');
$controller = new LoginController();

/**
*   faz um switch case "escutando" as requisições do tipo GET,
*   e chamando as funções conforme o escopo da requisição.
*/
switch (key($_GET)) {
    case 'cadastrar':
        $controller->cadastrar();
        break;
    case 'info':
        $controller->info();
        break;
    case 'sair':
        $controller->sair();
        break;
    default:
        $controller->login();
}

?>