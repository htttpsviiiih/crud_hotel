<?php
require_once(__DIR__ . '/../../controller/ClienteController.php');
require_once(__DIR__ . '/../../controller/FuncionarioController.php');
require_once(__DIR__ . '/../../controller/PacoteController.php');

$clienteController = new ClienteController();
$funcionarioController = new FuncionarioController();
$funcionarios = $funcionarioController->listar();

$pacoteController = new PacoteController();
$pacotes = $pacoteController->listar();

?>

<h2>Cadastro de Cliente</h2>

<form action="" method="POST">
    <label for="cpf">CPF:</label><br>
    <input type="text" id="cpf" name="cpf" maxlength="11" required><br><br>

    <label for="telefone">Telefone:</label><br>
    <input type="text" id="telefone" name="telefone" maxlength="15" required><br><br>

    <label for="nome">Nome:</label><br>
    <input type="text" id="nome" name="nome" maxlength="100" required><br><br>

    <label for="endereco">Endereço:</label><br>
    <input type="text" id="endereco" name="endereco" maxlength="200" required><br><br>

    <label>Possui acompanhante?</label><br>
    <select id="possui_acompanhante" name="possui_acompanhante" required>
        <option value="">Selecione</option>
        <option value="S">Sim</option>
        <option value="N">Não</option>
    </select><br><br>
    <label for="data_cadastro">Data de Cadastro:</label><br>
    <input type="date" id="data_cadastro" name="data_cadastro" required><br><br>
    <label for="id_funcionario">Funcionário Responsável:</label><br>
    <select id="id_funcionario" name="id_funcionario" required>
        <option value="">Selecione</option>
        <?php
        foreach ($funcionarios as $f): ?>
            <option value="<?= $f->getIdFuncionario() ?>"
                <?php
                if (
                    isset($cliente) && $cliente->getFuncionario() &&
                    $cliente->getFuncionario()->getIdFuncionario() == $f->getIdFuncionario()
                )
                    echo "selected";
                ?>>
                <?= $f ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="id_pacote">Pacote:</label><br>

    <select name="id_pacote" id="id_pacote">
        <option value="">Selecione um Pacote</option>
        <?php
        foreach ($pacotes as $p): ?>
            <option value="<?= $p->getIdPacote() ?>"
                <?php
                if (
                    isset($cliente) && $cliente->getPacote() &&
                    $cliente->getPacote()->getIdPacote() == $p->getIdPacote()
                )
                    echo "selected";
                ?>>
                <?= $p->getNomePacote() ?>
            </option>
        <?php endforeach; ?>
    </select>

    <br><br><button type="submit">Cadastrar Cliente</button> <button><a href="listar.php">Voltar</a></button>

</form>