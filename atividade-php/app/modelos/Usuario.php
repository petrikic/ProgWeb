<?php

/**
* Esta classe define um objeto do tipo Usuário.
*/
class Usuario {

    /**
    *   @var string $email
    *   Este é o atributo responsável por armazenar o e-mail do usuário no objeto.
    */
    private $email;

    /**
    *   @var string $senha
    *   Este é o atributo resposável por armazenar a senha do usuário no objeto.
    */
    private $senha;

    /**
    *   @var string $nome
    *   Este é o atributo responsável por armazenar o nome do usuário no objeto.
    */
    private $nome;

    /**
    *   Este é o método construtor da classe Usuário. É chamado toda vez
    *   que um novo objeto do tipo usuário é criado.
    *   @param string $email contém o e-mail do usuário.
    *   @param string $senha contém a senha do usuário.
    *   @param string $nome contém o nome do usuário.
    *   Cada parametro é colocado dentro de seu respectivo atributo
    *   No caso da senha, o valor é armazenado aplicando uma hash com o algoritmo sha256. 
    */
    function __construct(string $email, string $senha, string $nome) {
        $this->email = $email;
        $this->senha = hash('sha256', $senha);
        $this->nome = $nome;
    }

    /**
    *   Este método obtem o valor do atributo passado como parâmetro.
    */
    public function __get($campo) {
        return $this->$campo;
    }

    /**
    *   Este método altera o valor do atributo passado como parâmetro,
    *   substituindo pelo valor passado também via parâmetro.
    */
    public function __set($campo, $valor) {
        return $this->$campo = $valor;
    }

    /**
    *   Este método compara se o valor do e-mail e senha (aplicando a hash)
    *   são iguais aos valores presentes nos atributos do objeto.
    */
    public function igual(string $email, string $senha) {
        return $this->email === $email && $this->senha === hash('sha256', $senha);
    }
}

?>