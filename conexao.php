<?php

class Conexao
{
    private $servername = "sql109.infinityfree.com";
    private $username = "if0_34787818";
    private $password = "jyiUTaabL7fF45";
    private $dbname = "if0_34787818_trabalho_final";
    public $conexao;

    function __construct()
    {
        if (!isset($this->conexao)) {
            try {
                $this->conexao = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            } catch (PDOException $e) {
                echo 'Erro de conexão: ' . $e->getMessage();
            }
        }
    }

    function fecharConexao()
    {
        if (isset($this->conexao)) {
            $this->conexao = null;
        }
    }
}
?>