<?php
//Mostrar erros do PHP
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once(__DIR__ . "/../../controller/ClienteController.php");
require_once(__DIR__ . "/../../model/Cliente.php");

$msgErro = "";
$cliente = NULL;

//recebendo os dados pra inserir
if (isset($_POST['nome'])) {
    //clicou no gravar 
    $nome = trim($_POST['nome']) ? trim($_POST['nome']) : NULL;
    $cpf = is_numeric($_POST['cpf']) ? ($_POST['cpf']) : NULL;
    $telefone = is_numeric($_POST['telefone']) ?($_POST['telefone']) : NULL;
    $endereco = trim($_POST['endereco']) ? trim($_POST['endereco']) : NULL;
    $possuiAcompanhante = trim($_POST['possuiAcompanhante']) ? trim($_POST['possuiAcompanhante']) : NULL;
    $idFuncionario = is_numeric($_POST['idFuncionario']) ? ($_POST['idFuncionario']) : NULL;

    //criando o obj
    $cliente = new Cliente();
    $cliente->setIdCliente(0);
    $cliente->setNome($nome);
    $cliente->setCpf($cpf);
    $cliente->setTelefone($telefone);
    $cliente->setEndereco($endereco);
    $cliente->setPossuiAcompanhante($possuiAcompanhante);
    $cliente->setDataCadastro(date('Y-m-d'));

    if ($idFuncionario) {
        $func = new Funcionario();
        $func->setIdFuncionario($idFuncionario);
        $cliente->setFuncionario($func);
        
    } else 
        $cliente->setFuncionario(NULL);
        $clienteCont = new ClienteController();
        $erros = $clienteCont->inserir($cliente);

         if(! $erros) {
        //Redirecionar para o listar
        header("location: listar.php");
    } else {
        //Converter o array de erros para string
        $msgErro = implode("<br>", $erros);
    }
}

include_once(__DIR__ . "/form.php");
?>