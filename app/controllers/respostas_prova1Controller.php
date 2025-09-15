<?php
class respostas_prova1Controller {

    public function salvarDesempenho() {
        header('Content-Type: application/json');

        require_once __DIR__ . '/../../database/Database.php';

        $db = new Database();
        $conn = $db->conn;

        $input = json_decode(file_get_contents('php://input'), true);
        $respostas = $input['respostas'] ?? [];
        $usuario_id = $_SESSION['user_id'] ?? null;

        if (!$usuario_id || empty($respostas)) {
            echo json_encode(['success' => false, 'message' => 'Usuário não autenticado ou sem respostas.']);
            exit;
        }

        $gabarito = [
            1 => 'C',  2 => 'D',  3 => 'D',  4 => 'B',  5 => 'D',
            6 => 'D',  7 => 'E',  8 => 'C',  9 => 'A', 10 => 'E',
           11 => 'A', 12 => 'B', 13 => 'E', 14 => 'A', 15 => 'D',
           16 => 'C', 17 => 'B', 18 => 'C', 19 => 'D', 20 => 'A',
           21 => 'C', 22 => 'C', 23 => 'A', 24 => 'B', 25 => 'D',
           26 => 'E', 27 => 'C', 28 => 'E', 29 => 'D', 30 => 'A',
           31 => 'B', 32 => 'E', 33 => 'C', 34 => 'E', 35 => 'A',
           36 => 'B', 37 => 'E', 38 => 'B', 39 => 'B', 40 => 'A',
           41 => 'A', 42 => 'C', 43 => 'C', 44 => 'C', 45 => 'E',
           46 => 'E', 47 => 'C', 48 => 'D', 49 => 'B', 50 => 'B'
        ];

        $acertos = 0;
        $erros = 0;
        $correcao = [];

        foreach ($respostas as $resposta) {
            $questao = $resposta['questao'];
            $respostaUsuario = strtoupper(trim($resposta['resposta']));
            $respostaCorreta = $gabarito[$questao] ?? '';

            $acertou = ($respostaUsuario === $respostaCorreta);

            if ($acertou) {
                $acertos++;
            } else {
                $erros++;
            }

            $correcao[] = [
                'questao' => $questao,
                'resposta_usuario' => $respostaUsuario,
                'resposta_correta' => $respostaCorreta,
                'acertou' => $acertou
            ];
        }

        $tempo_total = 14400 - intval($input['tempo_restante'] ?? 0);
        $pontuacao = $acertos;

        $stmt = $conn->prepare("INSERT INTO desempenho_provas (usuario_id, prova, acertos, erros, tempo_gasto, pontuacao, data_execucao) VALUES (?, 'Prova 1', ?, ?, ?, ?, NOW())");

        if ($stmt) {
            $stmt->bind_param("iiiii", $usuario_id, $acertos, $erros, $tempo_total, $pontuacao);
            $stmt->execute();
            $stmt->close();

            echo json_encode([
                'success' => true,
                'message' => "Desempenho salvo com sucesso. Você acertou $acertos de 50 questões.",
                'correcao' => $correcao
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao preparar a query.']);
        }

        $db->close();
    }
}
