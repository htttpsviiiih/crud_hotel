<?php
//Mostrar erros do PHP
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once(__DIR__ . "/../../controller/ClienteController.php");
require_once(__DIR__ . "/../../dao/ClienteDao.php");
require_once(__DIR__ . "/../../service/ClienteService.php");

$clienteController = new ClienteController();
$lista = $clienteController->listarClientes();


include(__DIR__ . "/../include/header.php");

?>

<h2>Lista de Clientes</h2>
<table class="" border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Telefone</th>
            <th>Endereço</th>
            <th>Acompanhante</th>
            <th>Pacote</th>
            <th>Dia do Cadastro</th>
            <th>Funcionário responsável</th>
            <th>Alterar</th>
            <th>Excluir</th>
            <th>Detalhar</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($lista as $cliente): ?>
            <tr>
                <td><?= $cliente->getIdCliente() ?></td>
                <td><?= $cliente->getNome() ?></td>
                <td><?= $cliente->getCpf() ?></td>
                <td><?= $cliente->getTelefone() ?></td>
                <td><?= $cliente->getEndereco() ?></td>
                <td>
                    <?php
                    if ($cliente->getPossuiAcompanhante() == 'S') {
                        echo "Sim";
                    } else {
                        echo "Não";
                    }
                    ?>
                </td>
                <td><?= $cliente->getPacote() ? $cliente->getPacote()->getDescricao() : 'N/A'; ?></td>
                <td><?= $cliente->getDataCadastro() ?></td>
                <td><?= $cliente->getFuncionario() ? $cliente->getFuncionario()->getNome() : 'N/A' ?></td>
                <td><a href="form.php?acao=alterar&id=<?= $cliente->getIdCliente() ?>">Alterar</a></td>
                <td><a href="../../controller/ClienteController.php?acao=excluir&id=<?= $cliente->getIdCliente() ?>" onclick="return confirm('Confirma exclusão?')">Excluir</a></td>
                <td><a href="detalhes.php?id=<?= $cliente->getIdCliente() ?>">Detalhar</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<button><a href="form.php">Inserir Clientes</a></button>

<?php
include(__DIR__ . "/../include/footer.php");
?>