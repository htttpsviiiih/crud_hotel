<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once(__DIR__ . "/../../controller/ClienteController.php");
require_once(__DIR__ . "/../../model/Cliente.php");
require_once(__DIR__ . "/../../model/Funcionario.php");
require_once(__DIR__ . "/../../model/Pacote.php");
$msgErro = "";
$cliente = null;

if (isset($_POST['id_cliente'])) {

    $id_cliente = trim($_POST['id_cliente']) ? trim($_POST['id_cliente']) : NULL;
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
    $cliente->setIdCliente($id_cliente);
    $cliente->setNome($nome);
    $cliente->setCpf($cpf);
    $cliente->setTelefone($telefone);
    $cliente->setEndereco($endereco);
    $cliente->setPossuiAcompanhante($possuiAcompanhante);
    $cliente->setDataCadastro($data);

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
    $erros = $clienteController->alterar($cliente);

    if (! $erros) {
        //Redirecionar para o listar
        header("location: listar.php");
    } else {
        //Converter o array de erros para string
        $msgErro = implode("<br>", $erros);
    }
}   else{
    $id = 0;
    if(isset($_GET["id_cliente"]))
        $id = $_GET["id_cliente"];

    $clienteCont = new ClienteController();
    $cliente = $clienteCont->buscarPorId($id);

    if(! $cliente) {
        echo "ID do cliente é inválido!<br>";
        echo "<a href='listar.php'>Voltar</a>";
        exit;
    }
}
include_once (__DIR__.'/form.php');
