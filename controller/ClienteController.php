    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once(__DIR__ . "/../dao/ClienteDao.php");
    require_once(__DIR__ . "/../service/ClienteService.php");

    class ClienteController
    {
        private ClienteDao $clienteDAO;
        private ClienteService $clienteService;

        public function __construct()
        {
            $this->clienteDAO = new ClienteDAO();
            $this->clienteService = new ClienteService($this->clienteDAO);
        }
        public function buscarPorId($id)
        {
            return $this->clienteDAO->buscarPorId($id);
        }
        public function listarClientes()
        {
            $lista = $this->clienteDAO->listar();
            return $lista;
        }
        public function inserir(Cliente $cliente)
        {
            $erros = $this->clienteService->validarCliente($cliente);
            if (count($erros) > 0)
                return $erros;
            // Se não tiver erros, chama o DAO
            $erro = $this->clienteDAO->inserir($cliente);


            if (isset($erro)) {

                array_push($erros, "Erro ao salvar o cliente!");
                if (defined('AMB_DEV') && AMB_DEV) {
                    if (is_object($erro) && method_exists($erro, 'getMessage')) {
                        array_push($erros, $erro->getMessage());
                    } else {
                        array_push($erros, is_string($erro) ? $erro : 'Erro desconhecido.');
                    }
                }
            }

            return $erros;
        }

        public function alterar(Cliente $cliente)
        {
            $erros = $this->clienteService->validarCliente($cliente);
            if (count($erros) > 0)
                return $erros;

            // Se não tiver erros, chama o DAO
            $erro = $this->clienteDAO->alterar($cliente);
            if ($erro) {
                array_push($erros, "Erro ao alterar o cliente!");
                if (defined('AMB_DEV') && AMB_DEV) {
                    if (is_object($erro) && method_exists($erro, 'getMessage')) {
                        array_push($erros, $erro->getMessage());
                    } else {
                        array_push($erros, is_string($erro) ? $erro : 'Erro desconhecido.');
                    }
                }
            }

            return $erros;
        }
        public function excluir(int $id)
        {
        $erros = array();
        
        $erro = $this->clienteDAO->excluir($id);
        if($erro) {
            array_push($erros, "Erro ao excluir cliente!");
            if(AMB_DEV)
                array_push($erros, $erro->getMessage());
        }

        return $erros;

    }
}