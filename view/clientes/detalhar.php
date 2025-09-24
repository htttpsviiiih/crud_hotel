<?php
require_once(__DIR__ . "/../../controller/ClienteController.php");
$clienteController = new ClienteController();

$id = $_GET['id_cliente'] ?? null;

$cliente = null;
if ($id) {
    $cliente = $clienteController->buscarPorId((int)$id);
}

include(__DIR__ . "/../include/header.php");
?>

<div class="container mx-auto px-4 py-8 max-w-4xl">
    <?php if ($cliente): ?>
        <!-- Cabeçalho da página -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Detalhes do Cliente</h1>
            <p class="text-gray-600">Informações completas do hóspede</p>
        </div>

        <!-- Informações principais do cliente -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="bg-blue-600 text-white px-6 py-4">
                <h2 class="text-xl font-semibold">Dados Pessoais</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Nome completo</span>
                    <span class="text-lg text-gray-800" id="nome-cliente"><?= htmlspecialchars($cliente->getNome()) ?></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">CPF</span>
                    <span class="text-lg text-gray-800" id="cpf-cliente"><?= htmlspecialchars($cliente->getCpf()) ?></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Telefone</span>
                    <span class="text-lg text-gray-800" id="telefone-cliente"><?= htmlspecialchars($cliente->getTelefone()) ?></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Acompanhante</span>
                    <span class="text-lg" id="acompanhante-cliente">
                        <?php if ($cliente->getPossuiAcompanhante() == 'S'): ?>
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Sim</span>
                        <?php else: ?>
                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">Não</span>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="flex flex-col md:col-span-2">
                    <span class="text-sm font-medium text-gray-500">Endereço</span>
                    <span class="text-lg text-gray-800" id="endereco-cliente"><?= htmlspecialchars($cliente->getEndereco()) ?></span>
                </div>
            </div>
        </div>

        <!-- Detalhes do pacote -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="bg-green-600 text-white px-6 py-4">
                <h2 class="text-xl font-semibold">Detalhes do Pacote</h2>
            </div>
            <div class="p-6">
                <?php if ($cliente->getPacote()): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-500">Pacote contratado</span>
                            <span class="text-lg text-gray-800" id="nome-pacote">
                                <?= htmlspecialchars($cliente->getPacote()->getNomePacote()) ?>
                            </span>
                        </div>
                        <div class="flex flex-col md:col-span-2">
                            <span class="text-sm font-medium text-gray-500">Descrição do pacote</span>
                            <span class="text-lg text-gray-800" id="detalhes-pacote">
                                <?= htmlspecialchars($cliente->getPacote()->getDescricao()) ?>
                                <br>
                            </span>
                        </div>
                        <div class="flex flex-col md:col-span-2">
                            <span class="text-sm font-medium text-gray-500">Preço:</span>
                            <span class="text-lg text-gray-800" id="preco-pacote">
                                R$ <?= number_format($cliente->getPacote()->getPreco(), 2, ',', '.') ?>
                            </span>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-gift text-4xl text-gray-300 mb-2"></i>
                        <p class="text-gray-500">Nenhum pacote selecionado</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Informações do check-in -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="bg-purple-600 text-white px-6 py-4">
                <h2 class="text-xl font-semibold">Informações do Check-in</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Data de Check-in</span>
                    <span class="text-lg text-gray-800" id="data-checkin">
                        <?= date('d/m/Y', strtotime($cliente->getDataCadastro())) ?>
                    </span>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500">Atendente responsável</span>
                    <span class="text-lg text-gray-800" id="nome-funcionario">
                        <?= $cliente->getFuncionario() ? htmlspecialchars($cliente->getFuncionario()->getNome()) : 'Não informado' ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Botão voltar -->
        <div class="flex justify-center mt-8">
            <a href="listar.php" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-8 rounded-lg transition duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Voltar para a lista
            </a>
        </div>

    <?php else: ?>
        <!-- Mensagem de cliente não encontrado -->
        <div class="text-center py-12">
            <i class="fas fa-user-slash text-6xl text-gray-300 mb-4"></i>
            <h2 class="text-2xl font-bold text-gray-700 mb-2">Cliente não encontrado</h2>
            <p class="text-gray-500 mb-6">O cliente solicitado não foi encontrado em nosso sistema.</p>
            <a href="listar.php" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                Voltar para a lista
            </a>
        </div>
    <?php endif; ?>
</div>

<?php
include(__DIR__ . "/../include/footer.php");
?>