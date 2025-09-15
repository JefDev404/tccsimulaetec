<?php
require_once __DIR__ . '/../../database/Database.php';

class Usuario {
    private $nome;
    private $email;
    private $senha;
    private $db;

    public function __construct($nome, $email, $senha) {
        $this->nome = $this->sanitizarNome($nome);
        $this->email = $this->validarEmail($email);
        $this->senha = password_hash($senha, PASSWORD_DEFAULT);
        $this->db = new Database();
    }

    public function salvar() {
        $sql = "INSERT INTO usuarios(nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $this->db->conn->prepare($sql);
    
        if (!$stmt) {
            throw new Exception("Erro ao preparar consulta: ". $this->db->conn->error);
        }
    
        $stmt->bind_param("sss", $this->nome, $this->email, $this->senha);
    
        try {
            if (!$stmt->execute()) {
                throw new Exception("Erro ao salvar usuário: " . $stmt->error);
            }
        } catch (mysqli_sql_exception $e) {
            // Verifica se o erro é de duplicidade de email (código 1062)
            if ($e->getCode() == 1062) {
                return "erro.";
            }
            throw $e; // outros erros, relança
        }
    
        return true;
    }
    
    public static function autenticar($email, $senha) {
        $db = new Database();
        $sql = "SELECT id, senha FROM usuarios WHERE email = ? LIMIT 1";
        
        $stmt = $db->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Erro ao preparar consulta de autenticação");
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();
            if (password_verify($senha, $usuario['senha'])) {
                return $usuario['id'];
            }
        }
        
        return false;
    }

    /**
     * Busca usuário pelo ID no banco de dados
     * @param int $id ID do usuário
     * @return array|null Dados do usuário ou null se não encontrado
     * @throws Exception Em caso de erro na consulta
     */
    public static function buscarPorId($id) {
        $db = new Database();
        $sql = "SELECT id, nome, email, criado_em FROM usuarios WHERE id = ? LIMIT 1";
        
        $stmt = $db->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Erro ao preparar consulta: " . $db->conn->error);
        }

        $stmt->bind_param("i", $id);
        
        if (!$stmt->execute()) {
            throw new Exception("Erro ao executar consulta: " . $stmt->error);
        }
        
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows === 1) {
            return $resultado->fetch_assoc();
        }
        
        return null;
    }
    // app/model/Usuario.php


// Dentro de Usuario.php




public static function buscarEstatisticasDesempenho($usuarioId)
{
    require_once __DIR__ . '/../../database/Database.php'; // Caminho para a classe Database
    
    $db = new Database();

    $sql1 = "
        SELECT 
            COUNT(*) as total_provas,
            AVG(tempo_gasto) as tempo_medio,
            SUM(acertos) as total_acertos,
            SUM(erros) as total_erros,
            SUM(acertos + erros) as total_questoes
        FROM desempenho_provas
        WHERE usuario_id = ?
    ";

    $stmt = $db->conn->prepare($sql1);
    if (!$stmt) {
        throw new Exception("Erro ao preparar consulta: " . $db->conn->error);
    }

    $stmt->bind_param('i', $usuarioId);
    $stmt->execute();
    $resultado1 = $stmt->get_result();
    $estatisticas = $resultado1->fetch_assoc();

    $sql2 = "SELECT * FROM desempenho_provas WHERE usuario_id = ? ORDER BY data_execucao DESC";
    $stmt2 = $db->conn->prepare($sql2);
    if (!$stmt2) {
        throw new Exception("Erro ao preparar consulta: " . $db->conn->error);
    }

    $stmt2->bind_param('i', $usuarioId);
    $stmt2->execute();
    $resultado2 = $stmt2->get_result();

    $provas = [];
    while ($row = $resultado2->fetch_assoc()) {
        $provas[] = $row;
    }

    return [
        'estatisticas' => $estatisticas,
        'provas' => $provas
    ];
}



    // Métodos auxiliares de validação
    private function sanitizarNome($nome) {
        $nome = trim($nome);
        return filter_var($nome, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    private function validarEmail($email) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email inválido");
        }
        return $email;
    }
}