<?php
class DB {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "carvows";
    private $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=utf8", $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Erro na Conexão: " . $e->getMessage();
        }
        return $this->conn;
    }

    public function listarUsuarios($pesquisa = '', $filtro_tipo = '') {
        $db = $this->connect();
        
        $sql = "SELECT id, nome, email, login, tipo FROM usuario WHERE 1=1";

        if (!empty($pesquisa)) {
            $sql .= " AND (nome LIKE :pesquisa OR email LIKE :pesquisa)";
        }
        if (!empty($filtro_tipo)) {
            $sql .= " AND tipo = :tipo";
        }
        
        $sql .= " ORDER BY nome ASC";
        $stmt = $db->prepare($sql);
        
        if (!empty($pesquisa)) {
            $param_pesquisa = "%$pesquisa%";
            $stmt->bindParam(':pesquisa', $param_pesquisa);
        }
        if (!empty($filtro_tipo)) {
            $stmt->bindParam(':tipo', $filtro_tipo);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function excluirUsuario($id) {
        $db = $this->connect();
        $sql = "DELETE FROM usuario WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function buscarUsuarioPorId($id) {
        $db = $this->connect();
        $sql = "SELECT id, nome, telefone, email, login, tipo FROM usuario WHERE id = :id LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarUsuario($id, $nome, $telefone, $email, $login, $tipo, $senha = null) {
        $db = $this->connect();

        if (!empty($senha)) {
            $senha_cripto = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "UPDATE usuario SET nome = :nome, telefone = :telefone, email = :email, login = :login, tipo = :tipo, senha = :senha WHERE id = :id";
        } else {
            $sql = "UPDATE usuario SET nome = :nome, telefone = :telefone, email = :email, login = :login, tipo = :tipo WHERE id = :id";
        }
        
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':tipo', $tipo);
        
        if (!empty($senha)) {
            $stmt->bindParam(':senha', $senha_cripto);
        }
        
        return $stmt->execute();
    }

    // Código do veículo topzera 100%

    public function excluirVeiculo($id) {
        $db = $this->connect();
        $sql = "DELETE FROM veiculo WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function listarVeiculos($termo = '', $campo_filtro = 'modelo') {
        $db = $this->connect();
        
        $sql = "SELECT id, modelo, marca, ano_fabricacao, preco, cor, potencia FROM veiculo WHERE 1=1";

        $campos_permitidos = ['modelo', 'marca', 'cor', 'ano_fabricacao'];
        if (!in_array($campo_filtro, $campos_permitidos)) {
            $campo_filtro = 'modelo';
        }

        if (!empty($termo)) {
            if ($campo_filtro === 'ano_fabricacao') {
                $sql .= " AND ano_fabricacao = :termo";
            } else {
                $sql .= " AND $campo_filtro LIKE :termo";
            }
        }
        
        $sql .= " ORDER BY modelo ASC";
        $stmt = $db->prepare($sql);
        
        if (!empty($termo)) {
            if ($campo_filtro === 'ano_fabricacao') {
                $param_termo = intval($termo);
                $stmt->bindParam(':termo', $param_termo, PDO::PARAM_INT);
            } else {
                $param_termo = "%$termo%";
                $stmt->bindParam(':termo', $param_termo);
            }
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarVeiculoPorId($id) {
        $db = $this->connect();
        $sql = "SELECT id, modelo, marca, ano_fabricacao, preco, cor, descricao, potencia, torque, velocidade_maxima FROM veiculo WHERE id = :id LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarVeiculo($id, $modelo, $marca, $ano_fabricacao, $preco, $cor, $descricao, $potencia, $torque, $velocidade_maxima) {
        $db = $this->connect();
        $sql = "UPDATE veiculo SET 
                    modelo = :modelo, 
                    marca = :marca, 
                    ano_fabricacao = :ano_fabricacao, 
                    preco = :preco, 
                    cor = :cor, 
                    descricao = :descricao, 
                    potencia = :potencia, 
                    torque = :torque, 
                    velocidade_maxima = :velocidade_maxima 
                WHERE id = :id";
                
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':ano_fabricacao', $ano_fabricacao);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':cor', $cor);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':potencia', $potencia);
        $stmt->bindParam(':torque', $torque);
        $stmt->bindParam(':velocidade_maxima', $velocidade_maxima);
        
        return $stmt->execute();
    }

    // Inicío do código clientes topzera:

    public function listarClientes($termo = '', $campo_filtro = 'nome_completo') {
        $db = $this->connect();
        
        $sql = "SELECT id, nome_completo, cpf, cidade, celular FROM cliente WHERE 1=1";

        $campos_permitidos = ['nome_completo', 'cpf', 'cidade', 'celular'];
        if (!in_array($campo_filtro, $campos_permitidos)) {
            $campo_filtro = 'nome_completo';
        }

        if (!empty($termo)) {
            $sql .= " AND $campo_filtro LIKE :termo";
        }
        
        $sql .= " ORDER BY nome_completo ASC";
        $stmt = $db->prepare($sql);
        
        if (!empty($termo)) {
            $param_termo = "%$termo%";
            $stmt->bindParam(':termo', $param_termo);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function excluirCliente($id) {
        $db = $this->connect();
        $sql = "DELETE FROM cliente WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function buscarClientePorId($id) {
        $db = $this->connect();
        $sql = "SELECT id, nome_completo, cpf, cidade, celular FROM cliente WHERE id = :id LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarCliente($id, $nome_completo, $cpf, $cidade, $celular) {
        $db = $this->connect();
        $sql = "UPDATE cliente SET 
                    nome_completo = :nome_completo, 
                    cpf = :cpf, 
                    cidade = :cidade, 
                    celular = :celular 
                WHERE id = :id";
                
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome_completo', $nome_completo);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':celular', $celular);
        
        return $stmt->execute();
    }

    // Inicio Veículos X Vendas bem legais:

    public function listarVeiculosDisponiveis($termo = '', $campo_filtro = 'modelo') {
        $db = $this->connect();

        $sql = "SELECT id, modelo, marca, ano_fabricacao, preco, cor, potencia, status 
                FROM veiculo 
                WHERE status = 'Disponivel'";
        
        $campos_permitidos = ['modelo', 'marca', 'cor', 'ano_fabricacao'];
        if (!in_array($campo_filtro, $campos_permitidos)) {
            $campo_filtro = 'modelo';
        }

        if (!empty($termo)) {
            if ($campo_filtro === 'ano_fabricacao') {
                $sql .= " AND ano_fabricacao = :termo";
            } else {
                $sql .= " AND $campo_filtro LIKE :termo";
            }
        }
        
        $sql .= " ORDER BY modelo ASC";
        $stmt = $db->prepare($sql);
        
        if (!empty($termo)) {
            if ($campo_filtro === 'ano_fabricacao') {
                $param_termo = intval($termo);
                $stmt->bindParam(':termo', $param_termo, PDO::PARAM_INT);
            } else {
                $param_termo = "%$termo%";
                $stmt->bindParam(':termo', $param_termo);
            }
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarVendedoresCombo() {
        $db = $this->connect();
        $stmt = $db->query("SELECT id, nome FROM usuario ORDER BY nome ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarClientesCombo() {
        $db = $this->connect();
        $stmt = $db->query("SELECT id, nome_completo FROM cliente ORDER BY nome_completo ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvarVenda($data_venda, $valor_final, $comissao, $usuario_id, $cliente_id, $veiculo_id) {
        $db = $this->connect();
        try {
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->beginTransaction();

            $sqlVenda = "INSERT INTO venda (data_venda, valor_final, comissao, usuario_id, cliente_id, veiculo_id) 
                         VALUES (:data_venda, :valor_final, :comissao, :usuario_id, :cliente_id, :veiculo_id)";
            
            $stmtVenda = $db->prepare($sqlVenda);
            $stmtVenda->bindParam(':data_venda', $data_venda);
            $stmtVenda->bindParam(':valor_final', $valor_final);
            $stmtVenda->bindParam(':comissao', $comissao);
            $stmtVenda->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmtVenda->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
            $stmtVenda->bindParam(':veiculo_id', $veiculo_id, PDO::PARAM_INT);
            $stmtVenda->execute();

            $sqlCarro = "UPDATE veiculo SET status = 'Vendido' WHERE id = :veiculo_id";
            $stmtCarro = $db->prepare($sqlCarro);
            $stmtCarro->bindParam(':veiculo_id', $veiculo_id, PDO::PARAM_INT);
            $stmtCarro->execute();

            $db->commit();
            return true;
        } catch (Exception $e) {
            $db->rollBack();
            return false;
        }
    }

    public function listarVendas() {
        $db = $this->connect();
        $sql = "SELECT v.id, v.data_venda, v.valor_final, v.comissao, 
                       u.nome AS vendedor, 
                       c.nome_completo AS cliente, 
                       car.marca, car.modelo
                FROM venda v
                INNER JOIN usuario u ON v.usuario_id = u.id
                INNER JOIN cliente c ON v.cliente_id = c.id
                INNER JOIN veiculo car ON v.veiculo_id = car.id
                ORDER BY v.data_venda DESC, v.id DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function excluirVenda($id) {
        $db = $this->connect();
        try {
            $db->beginTransaction();

            $stmtSelect = $db->prepare("SELECT veiculo_id FROM venda WHERE id = :id");
            $stmtSelect->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtSelect->execute();
            $venda = $stmtSelect->fetch(PDO::FETCH_ASSOC);

            if ($venda) {
                $stmtDelete = $db->prepare("DELETE FROM venda WHERE id = :id");
                $stmtDelete->bindParam(':id', $id, PDO::PARAM_INT);
                $stmtDelete->execute();
                $stmtCarro = $db->prepare("UPDATE veiculo SET status = 'Disponivel' WHERE id = :veiculo_id");
                $stmtCarro->bindParam(':veiculo_id', $venda['veiculo_id'], PDO::PARAM_INT);
                $stmtCarro->execute();
            }

            $db->commit();
            return true;
        } catch (Exception $e) {
            $db->rollBack();
            return false;
        }
    }
}
?>