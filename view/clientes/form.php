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
?>

<h2>Cadastro de Cliente</h2>

<?php if (isset($msgErro) && $msgErro): ?>
    <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 20px;">
        <h3>Erro ao Cadastrar Cliente:</h3>
        <?= $msgErro ?>
    </div>
<?php endif; ?>

<form method="POST" action="inserir.php">

    <label for="nome">Nome:</label><br>
    <input type="text" id="nome" name="nome" maxlength="100" value="<?= isset($cliente) ? ($cliente->getNome() ?: '') : '' ?>" required><br><br>

    <label for="cpf">CPF:</label><br>
    <input type="text" id="cpf" name="cpf" maxlength="11" value="<?= isset($cliente) ? ($cliente->getCpf() ?: '') : '' ?>" required><br><br>

    <label for="telefone">Telefone:</label><br>
    <input type="text" id="telefone" name="telefone" maxlength="15" value="<?= isset($cliente) ? ($cliente->getTelefone() ?: '') : '' ?>" required><br><br>

    <label for="endereco">Endereço:</label><br>
    <input type="text" id="endereco" name="endereco" maxlength="200" value="<?= isset($cliente) ? ($cliente->getEndereco() ?: '') : '' ?>" required><br><br>

    <label>Possui acompanhante?</label><br>
    <select id="possui_acompanhante" name="possui_acompanhante" required>
        <option value="">Selecione</option>
        <option value="S" <?= (isset($cliente) && $cliente->getPossuiAcompanhante() === 'S') ? 'selected' : '' ?>>Sim</option>
        <option value="N" <?= (isset($cliente) && $cliente->getPossuiAcompanhante() === 'N') ? 'selected' : '' ?>>Não</option>
    </select><br><br>

    <label for="data_cadastro">Data de Cadastro:</label><br>
    <input type="date" id="data_cadastro" name="data_cadastro" value="<?= isset($cliente) ? ($cliente->getDataCadastro() ?: '') : '' ?>" required><br><br>
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
                <?= $f->getNome() ?>
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