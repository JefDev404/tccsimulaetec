<?php
class respostas_prova2Controller {

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
                1 => 'B',  2 => 'C',  3 => 'C',  4 => 'E',  5 => 'E',
                6 => 'D',  7 => 'C',  8 => 'D',  9 => 'A', 10 => 'D',
                11 => 'B', 12 => 'C', 13 => 'A', 14 => 'C', 15 => 'B',
                16 => 'E', 17 => 'C', 18 => 'B', 19 => 'B', 20 => 'D',
                21 => 'A', 22 => 'E', 23 => 'D', 24 => 'C', 25 => 'B',
                26 => 'E', 27 => 'E', 28 => 'A', 29 => 'B', 30 => 'A',
                31 => 'C', 32 => 'C', 33 => 'B', 34 => 'A', 35 => 'B',
                36 => 'E', 37 => 'A', 38 => 'D', 39 => 'A', 40 => 'E',
                41 => 'C', 42 => 'D', 43 => 'C', 44 => 'A', 45 => 'D',
                46 => 'B', 47 => 'D', 48 => 'D', 49 => 'C', 50 => 'D'
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

        $stmt = $conn->prepare("INSERT INTO desempenho_provas (usuario_id, prova, acertos, erros, tempo_gasto, pontuacao, data_execucao) VALUES (?, 'Prova 2', ?, ?, ?, ?, NOW())");

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
