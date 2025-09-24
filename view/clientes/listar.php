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

<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Lista de Clientes</h2>
    
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CPF</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Endereço</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acompanhante</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pacote</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dia do Cadastro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Funcionário responsável</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($lista as $cliente): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $cliente->getIdCliente() ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $cliente->getNome() ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $cliente->getCpf() ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $cliente->getTelefone() ?></td>
                        <td class="px-6 py-4 text-sm text-gray-500"><?= $cliente->getEndereco() ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php
                            if ($cliente->getPossuiAcompanhante() == 'S') {
                                echo '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Sim</span>';
                            } else {
                                echo '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Não</span>';
                            }
                            ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $cliente->getPacote() ? $cliente->getPacote()->getNomePacote() : 'N/A'; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $cliente->getDataCadastro() ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $cliente->getFuncionario() ? $cliente->getFuncionario()->getNome() : 'N/A' ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="detalhar.php?id_cliente=<?= $cliente->getIdCliente() ?>" class="text-blue-600 hover:text-blue-900 flex items-center" title="Detalhar">
                                <i class="fas fa-eye mr-1"></i> Detalhar
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="alterar.php?id_cliente=<?= $cliente->getIdCliente() ?>" class="text-yellow-600 hover:text-yellow-900 flex items-center" title="Editar">
                                <img src="/img/btn_editar.png" alt="" style="width: 20px; height: 20px;">
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="excluir.php?id_cliente=<?= $cliente->getIdCliente() ?>" onclick="return confirm('Confirma exclusão?')" class="text-red-600 hover:text-red-900 flex items-center" title="Excluir">
                                <img src="/img/btn_excluir.png" alt= "" style="width: 20px;">
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="flex space-x-4">
        <a href="form.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Inserir Clientes
        </a>
        <a href="cards.php" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Ver cards Clientes
        </a>
    </div>
</div>

<?php
include(__DIR__ . "/../include/footer.php");
?>