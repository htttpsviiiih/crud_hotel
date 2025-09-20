<?php
//Mostrar erros do PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once(__DIR__ . "/../../controller/ClienteController.php");
require_once(__DIR__ . "/../../model/Cliente.php");
require_once(__DIR__ . "/../../model/Funcionario.php");
require_once(__DIR__ . "/../../model/Pacote.php");

$msgErro = "";
$cliente = NULL;

//recebendo os dados pra inserir
if (isset($_POST['nome'])) {
    //clicou no gravar 
    $nome = trim($_POST['nome']) ? trim($_POST['nome']) : NULL;
    $cpf = trim($_POST['cpf']) ? ($_POST['cpf']) : NULL;
    $telefone = trim($_POST['telefone']) ? trim($_POST['telefone']) : NULL;
    $endereco = trim($_POST['endereco']) ? trim($_POST['endereco']) : NULL;
    $possuiAcompanhante = trim($_POST['possui_acompanhante']) ? trim($_POST['possui_acompanhante']) : NULL;
    $data = trim($_POST['data_cadastro']) ? trim($_POST['data_cadastro']) : NULL;
    $idFuncionario = is_numeric($_POST['id_funcionario']) ? ($_POST['id_funcionario']) : NULL;
    $idPacote = is_numeric($_POST['id_pacote']) ? ($_POST['id_pacote']) : NULL;

    //criando o obj
    $cliente = new Cliente();
    $cliente->setIdCliente(0);
    $cliente->setNome($nome);
    $cliente->setCpf($cpf);
    $cliente->setTelefone($telefone);
    $cliente->setEndereco($endereco);
    $cliente->setPossuiAcompanhante($possuiAcompanhante);
    $cliente->setDataCadastro($data);

    // pegar o id do funcionário (suporta id_funcionario ou idFuncionario)
    $idFuncionarioRaw = $_POST['id_funcionario'] ?? $_POST['idFuncionario'] ?? null;
    if (!empty($idFuncionarioRaw) && is_numeric($idFuncionarioRaw)) {
        $func = new Funcionario();
        $func->setIdFuncionario((int)$idFuncionarioRaw);
        $cliente->setFuncionario($func); // passa o objeto, como a função exige
    } else {
        $cliente->setFuncionario(null);
    }

    // pacote (mesma ideia)
    $idPacoteRaw = $_POST['id_pacote'] ?? $_POST['idPacote'] ?? null;
    if (!empty($idPacoteRaw) && is_numeric($idPacoteRaw)) {
        $pacote = new Pacote();
        $pacote->setIdPacote((int)$idPacoteRaw);
        $cliente->setPacote($pacote);
    } else {
        $cliente->setPacote(null);
    }
   

    $clienteController = new ClienteController();
    $erros = $clienteController->inserir($cliente);

    if (! $erros) {
        //Redirecionar para o listar
        header("location: listar.php");
        exit;
    } else {
        //Converter o array de erros para string
        $msgErro = implode("<br>", $erros);
    }
}
