<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/../../controller/ClienteController.php');
require_once(__DIR__ . '/../../controller/FuncionarioController.php');
require_once(__DIR__ . '/../../controller/PacoteController.php');

$clienteController = new ClienteController();
$funcionarioController = new FuncionarioController();
$funcionarios = $funcionarioController->listar();
$pacoteController = new PacoteController();
$pacotes = $pacoteController->listar();

$isEdicao = isset($cliente) && $cliente->getIdCliente() > 0;
$titulo = $isEdicao ? 'Alterar Cliente' : 'Inserir Cliente';
$corPrincipal = $isEdicao ? 'blue' : 'green';
?>

<?php include_once(__DIR__ . '/../include/header.php'); ?>

<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Cabeçalho do formulário -->
        <div class="bg-<?= $corPrincipal ?>-600 text-white px-6 py-4">
            <h1 class="text-2xl font-bold"><?= $titulo ?></h1>
            <p class="text-<?= $corPrincipal ?>-100 text-sm">
                <?= $isEdicao ? 'Atualize os dados do cliente' : 'Preencha os dados para cadastrar um novo cliente' ?>
            </p>
        </div>

        <!-- Mensagens de erro -->
        <?php if (isset($msgErro) && $msgErro): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mx-6 mt-4" role="alert">
                <p class="font-bold">Erro ao <?= $isEdicao ? 'Alterar' : 'Cadastrar' ?> Cliente:</p>
                <p><?= $msgErro ?></p>
            </div>
        <?php endif; ?>

        <!-- Formulário -->
        <form method="POST" action="<?= $isEdicao ? 'alterar.php' : 'inserir.php' ?>" class="p-6 space-y-6">
            <input type="hidden" name="id_cliente" value="<?= isset($cliente) ? ($cliente->getIdCliente() ?: '') : '' ?>">

            <div class="grid grid-cols-1 gap-6">
                <!-- Nome -->
                <div>
                    <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">Nome:</label>
                    <input type="text" id="nome" name="nome" maxlength="100"
                           value="<?= isset($cliente) ? ($cliente->getNome() ?: '') : (isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : '') ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-<?= $corPrincipal ?>-500 focus:border-<?= $corPrincipal ?>-500">
                </div>

                <!-- CPF -->
                <div>
                    <label for="cpf" class="block text-sm font-medium text-gray-700 mb-2">CPF:</label>
                    <input type="text" id="cpf" name="cpf" maxlength="11"
                           value="<?= isset($cliente) ? ($cliente->getCpf() ?: '') : (isset($_POST['cpf']) ? htmlspecialchars($_POST['cpf']) : '') ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-<?= $corPrincipal ?>-500 focus:border-<?= $corPrincipal ?>-500">
                </div>

                <!-- Telefone -->
                <div>
                    <label for="telefone" class="block text-sm font-medium text-gray-700 mb-2">Telefone:</label>
                    <input type="text" id="telefone" name="telefone" maxlength="15"
                           value="<?= isset($cliente) ? ($cliente->getTelefone() ?: '') : (isset($_POST['telefone']) ? htmlspecialchars($_POST['telefone']) : '') ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-<?= $corPrincipal ?>-500 focus:border-<?= $corPrincipal ?>-500">
                </div>

                <!-- Endereço -->
                <div>
                    <label for="endereco" class="block text-sm font-medium text-gray-700 mb-2">Endereço:</label>
                    <input type="text" id="endereco" name="endereco" maxlength="200"
                           value="<?= isset($cliente) ? ($cliente->getEndereco() ?: '') : (isset($_POST['endereco']) ? htmlspecialchars($_POST['endereco']) : '') ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-<?= $corPrincipal ?>-500 focus:border-<?= $corPrincipal ?>-500">
                </div>

                <!-- Acompanhante -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Possui acompanhante?</label>
                    <select id="possui_acompanhante" name="possui_acompanhante"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-<?= $corPrincipal ?>-500 focus:border-<?= $corPrincipal ?>-500">
                        <option value="">Selecione</option>
                        <option value="S" 
                            <?= (isset($cliente) && $cliente->getPossuiAcompanhante() === 'S') || (isset($_POST['possui_acompanhante']) && $_POST['possui_acompanhante'] === 'S') ? 'selected' : '' ?>>
                            Sim
                        </option>
                        <option value="N" 
                            <?= (isset($cliente) && $cliente->getPossuiAcompanhante() === 'N') || (isset($_POST['possui_acompanhante']) && $_POST['possui_acompanhante'] === 'N') ? 'selected' : '' ?>>
                            Não
                        </option>
                    </select>
                </div>

                <!-- Data de Cadastro -->
                <div>
                    <label for="data_cadastro" class="block text-sm font-medium text-gray-700 mb-2">Data de Cadastro:</label>
                    <input type="date" id="data_cadastro" name="data_cadastro"
                           value="<?= isset($cliente) ? ($cliente->getDataCadastro() ?: '') : (isset($_POST['data_cadastro']) ? htmlspecialchars($_POST['data_cadastro']) : '') ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-<?= $corPrincipal ?>-500 focus:border-<?= $corPrincipal ?>-500">
                </div>

                <!-- Funcionário Responsável -->
                <div>
                    <label for="id_funcionario" class="block text-sm font-medium text-gray-700 mb-2">Funcionário Responsável:</label>
                    <select id="id_funcionario" name="id_funcionario"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-<?= $corPrincipal ?>-500 focus:border-<?= $corPrincipal ?>-500">
                        <option value="">Selecione</option>
                        <?php foreach ($funcionarios as $f): ?>
                            <option value="<?= $f->getIdFuncionario() ?>"
                                <?= (isset($cliente) && $cliente->getFuncionario() && $cliente->getFuncionario()->getIdFuncionario() == $f->getIdFuncionario()) || 
                                   (isset($_POST['id_funcionario']) && $_POST['id_funcionario'] == $f->getIdFuncionario()) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($f->getNome()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Pacote -->
                <div>
                    <label for="id_pacote" class="block text-sm font-medium text-gray-700 mb-2">Pacote:</label>
                    <select name="id_pacote" id="id_pacote"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-<?= $corPrincipal ?>-500 focus:border-<?= $corPrincipal ?>-500">
                        <option value="">Selecione um Pacote</option>
                        <?php foreach ($pacotes as $p): ?>
                            <option value="<?= $p->getIdPacote() ?>"
                                <?= (isset($cliente) && $cliente->getPacote() && $cliente->getPacote()->getIdPacote() == $p->getIdPacote()) || 
                                   (isset($_POST['id_pacote']) && $_POST['id_pacote'] == $p->getIdPacote()) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($p->getNomePacote()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Botões -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="listar.php" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-6 rounded-md transition duration-200">
                    Voltar
                </a>
                <button type="submit" class="bg-<?= $corPrincipal ?>-600 hover:bg-<?= $corPrincipal ?>-700 text-white font-medium py-2 px-6 rounded-md transition duration-200">
                    <?= $isEdicao ? 'Alterar' : 'Inserir' ?>
                </button>
            </div>
        </form>
    </div>
</div>

<?php include_once(__DIR__ . '/../include/footer.php'); ?>