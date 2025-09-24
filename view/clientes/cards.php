<?php
require_once(__DIR__ . "/../../controller/ClienteController.php");

$clienteController = new ClienteController();
$lista = $clienteController->listarClientes();

include(__DIR__ . "/../include/header.php");
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Lista de Clientes</h1>
    <p class="text-gray-600 mb-8">Clientes cadastrados no sistema</p>

    <!-- Botão Novo Cliente -->
    <div class="mb-6">
        <a href="inserir.php" class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
            <i class="fas fa-plus mr-2"></i> Novo Cliente
        </a>
    </div>

    <!-- Grid de Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($lista as $cliente): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition duration-300">
                <!-- Cabeçalho do Card -->
                <div class="bg-blue-500 text-white px-4 py-3">
                    <h2 class="text-xl font-semibold truncate"><?php echo htmlspecialchars($cliente->getNome()); ?></h2>
                    <p class="text-blue-100 text-sm">ID: <?php echo htmlspecialchars($cliente->getIdCliente()); ?></p>
                </div>

                <!-- Corpo do Card -->
                <div class="p-4">
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <i class="fas fa-id-card text-gray-400 mr-3 w-5"></i>
                            <span class="text-gray-700"><?php echo htmlspecialchars($cliente->getCpf()); ?></span>
                        </div>
                        
                        <div class="flex items-center">
                            <i class="fas fa-phone text-gray-400 mr-3 w-5"></i>
                            <span class="text-gray-700"><?php echo htmlspecialchars($cliente->getTelefone()); ?></span>
                        </div>
                        
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-gray-400 mr-3 mt-1 w-5"></i>
                            <span class="text-gray-700"><?php echo htmlspecialchars($cliente->getEndereco()); ?></span>
                        </div>
                        
                        <div class="flex items-center">
                            <i class="fas fa-user-friends text-gray-400 mr-3 w-5"></i>
                            <span class="text-gray-700">
                                Acompanhante: 
                                <span class="font-medium <?php echo $cliente->getPossuiAcompanhante() == 'S' ? 'text-green-600' : 'text-red-600'; ?>">
                                    <?php echo $cliente->getPossuiAcompanhante() == 'S' ? 'Sim' : 'Não'; ?>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Rodapé do Card (Ações) -->
                <div class="bg-gray-50 px-4 py-3 border-t border-gray-200">
                    <div class="flex justify-between">
                        <a href="detalhar.php?id_cliente=<?php echo $cliente->getIdCliente(); ?>" 
                           class="text-blue-500 hover:text-blue-700 font-medium flex items-center">
                            <i class="fas fa-eye mr-1"></i> Detalhar
                        </a>
                        
                        <a href="alterar.php?id_cliente=<?php echo $cliente->getIdCliente(); ?>" 
                           class="text-yellow-500 hover:text-yellow-700 font-medium flex items-center">
                            <i class="fas fa-edit mr-1"></i> Editar
                        </a>
                        
                        <a href="excluir.php?id_cliente=<?php echo $cliente->getIdCliente(); ?>" 
                           onclick="return confirm('Confirma a exclusão?');" 
                           class="text-red-500 hover:text-red-700 font-medium flex items-center">
                            <i class="fas fa-trash mr-1"></i> Excluir
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Mensagem quando não há clientes -->
        <?php if (empty($lista)): ?>
            <div class="text-center py-12">
                <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray">No momento, não há clientes cadastrados.</p>
            </div>
        <?php endif; ?>
    </div>
    
    <?php include(__DIR__ . "/../include/footer.php"); ?>
