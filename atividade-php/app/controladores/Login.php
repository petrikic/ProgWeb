<?php 

require 'app/modelos/Usuario.php';
require 'Controlador.php';

/**
*   Esta classe extende a classe abstrata Controller.
*/
class LoginController extends Controller  {
    
    /**
    * 
    *   @var Usuario $loggedUser este atributo recebe o usuário logado, referente a sessão.
    *   
    */
    private $loggedUser;
    
    /**
    *   Este é o método construtor da classe LoginController.
    *   Primeiramente é inicializada uma sessão.
    *   caso a sessão 'user' exista, o atributo $loggedUser recebe o valor da sessão 'user'.
    */
    function __construct() {
        session_start();
        if (isset($_SESSION['user'])) $this->loggedUser = $_SESSION['user'];
    }
    
    /**
    *   Este método é responsável pelo sistema de sessão de login.
    *   Em primeiro lugar, é verificado se a requisição recebida é do tipo post.
    *   Caso seja, ele verifica se o vetor de session 'users' existe.
    *   Em seguida ele verifica se existe um usuário com e-mail e senha
    *   dentro do vetor de sessão 'users' que coincida com os recebidos pelo post.
    *   Caso exista, ele o armazena tanto no atributo $loggedUser, quanto na sessão 'user'
    *   
    *   Após isso, se houver um usuário logado, ele o redireciona para a área 'info'.
    *   caso contrário, ele exibe a mensagem 'usuário o/ou senha incorretos.'.
    *
    *   Se a requisição não for do tipo post, ele verifica se ja existe um usuário logado.
    *   se existir, ele redireciona para área 'info'
    *   caso não exista, ele faz a requisição da página de login.
    */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_SESSION['users'])) {
                foreach ($_SESSION['users'] as $user) {
                    if ($user->igual($_POST['email'], $_POST['senha'])) {
                        $_SESSION['user'] = $this->loggedUser = $user;
                        break;
                    }
                }
            }

            if ($this->loggedUser) {
                header('Location: index.php?info');
            } else {
                header('Location: index.php?email=' . $_POST['email'] . '&mensagem=Usuário e/ou senha incorreta!');
            }
        } else {
            if (!$this->loggedUser) {
                $this->view('users/login');
            } else {
                header('Location: index.php?info');
            }
        }
    }

    /**
    *   Em primeiro lugar, é verificado se a requisição recebida é do tipo post.
    *   Caso seja, ele verifica se o vetor de session 'users' não existe.
    *   Caso não exista, ele cria o vetor de session 'users'.
    *   Logo em seguida ele vai verificar no vetor de session 'users', se o e-mail ja existe
    *   Caso exista, ele exibura a seguinte mensagem: 'Email já cadastrado!"
    *   Não existindo o e-mail, ele cria um novo objeto do tipo Usuario, e o insere no vetor.
    *   em seguida, ele retorna para a index, direcionando para a área de login.
    *   
    *   Se a requisição não for do tipo post, ele faz a requisição da página de cadastro.
    */
    public function cadastrar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['users'])) $_SESSION['users'] = array();
            
            foreach ($_SESSION['users'] as $user) {
                if ($user->email == $_POST['email']) {
                    header('Location: index.php?cadastrar&mensagem=Email já cadastrado!');
                    return;
                }
            }
            
            $user = new Usuario($_POST['email'], $_POST['senha'], $_POST['nome']);
            array_push($_SESSION['users'], $user);
            
            header('Location: index.php?email=' . $_POST['email'] . '&mensagem=Usuário cadastrado com sucesso!');
            return;
        }
        $this->view('users/cadastrar');
    }

    /**
    *   Em primeiro lugar, é verificado se não existe um usuário logado.
    *   caso não exista, ele redireciona para a área de login, exibindo a mensagem: 'você precisa
    *   se identificar primeiro'.
    *   Se existir, ele redireciona para a página de informação do usuário.
    */
    public function info() {
        if (!$this->loggedUser) {
            header('Location: index.php?entrar&mensagem=Você precisa se identificar primeiro');    
            return;
        }
        $this->view('users/info', $this->loggedUser);        
    }

    /**
    *   Em primeiro lugar, é verificado se não existe um usuário logado.
    *   caso não exita, ele redireciona para área de login, exibindo a mensagem: 'você precisa
    *   se identificar primeiro'.
    *   caso exista, ele desabilita o registro da variável de sessão 'user', e redireciona
    *   para a index com a seguinte mensagem: 'usuário deslogado com sucesso!'.
    */
    public function sair() {
        if (!$this->loggedUser) {
            header('Location: index.php?entrar&mensagem=Você precisa se identificar primeiro');
            return;
        }
        unset($_SESSION['user']);
        header('Location: index.php?mensagem=Usuário deslogado com sucesso!');
    }
}

?>