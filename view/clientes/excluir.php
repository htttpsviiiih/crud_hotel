<?php
require_once(__DIR__ . "/../../controller/ClienteController.php");

$id = 0;
if (isset($_GET['id_cliente'])) {
    $id = $_GET['id_cliente'];
}
$clienteCont= new ClienteController();
$cliente = $clienteCont->buscarPorId($id);
if($cliente){
    $erros = $clienteCont->excluir($id);

    if ($erros) {
        $msgErro = implode("<br>", $erros);
        echo $msgErro;
    }else {
        header("location: listar.php");
        exit;
    }
}else {
   echo "Cliente não encontrado!<br>";
   echo "<a href='listar.php'>Voltar</a>";
}

