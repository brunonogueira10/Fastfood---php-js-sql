<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = htmlspecialchars(trim($_POST['nome']));
    $data_nascimento = htmlspecialchars(trim($_POST['data_nascimento']));
    $morada = htmlspecialchars(trim($_POST['morada']));

    if (empty($nome) || empty($data_nascimento) || empty($morada)) {
        die('<div class="container"><h1 class="error-title">Erro</h1><p class="error-message">Todos os campos são obrigatórios.</p><a href="index.php">Voltar para a Página Inicial</a></div>');
    }

    $hoje = new DateTime();
    $nascimento = new DateTime($data_nascimento);

    if ($nascimento > $hoje) {
        die('<div class="container"><h1 class="error-title">Erro</h1><p class="error-message">Você não pode ter nascido no futuro.</p><a href="index.php">Voltar para a Página Inicial</a></div>');
    }

    $idade = $hoje->diff($nascimento)->y;

    if ($idade < 18) {
        die('
        <div class="container">
            <h1 class="error-title">Erro</h1>
            <p class="error-message">Você deve ter 18 anos ou mais para realizar a compra.</p>
            <a href="index.php">Voltar para a Página Inicial</a>
        </div>
        ');
    }

    $carrinho = $_SESSION['carrinho'];
    $totalValue = $_SESSION['total'];

    try {
        $pdo->beginTransaction();

        
        $stmt = $pdo->prepare("
            INSERT INTO Encomendas (nome, data_nascimento, morada, produto_id, quantidade, preco_total)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        foreach ($carrinho as $produtoId => $quantidade) {
            $stmt->execute([$nome, $data_nascimento, $morada, $produtoId, $quantidade, $totalValue]);
        }

        
        $stmtUpdate = $pdo->prepare("UPDATE Produtos SET quantidade = quantidade - ? WHERE id = ?");
        foreach ($carrinho as $produtoId => $quantidade) {
            $stmtUpdate->execute([$quantidade, $produtoId]);
        }

        $pdo->commit();

       
        unset($_SESSION['carrinho'], $_SESSION['total']);

       
        echo "<div class='success-container'>";
        echo "<h3>Encomenda realizada com sucesso!</h3>";
        echo "<p>Obrigado, <strong>$nome</strong>! Sua encomenda foi registrada.</p>";
        echo "<p>Valor total: <strong>€" . number_format($totalValue, 2) . "</strong></p>";
        echo '<a href="index.php">Voltar para a Página Inicial</a>';
        echo "</div>";
    } catch (Exception $e) {
        $pdo->rollBack();
        die('<div class="container"><h1 class="error-title">Erro</h1><p class="error-message">Erro ao processar a encomenda: ' . $e->getMessage() . '</p><a href="index.php">Voltar para a Página Inicial</a></div>');
    }
} else {
    die('<div class="container"><h1 class="error-title">Erro</h1><p class="error-message">Acesso inválido.</p><a href="index.php">Voltar para a Página Inicial</a></div>');
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Transação</title>
    <link rel="stylesheet" href="style/finalizar_transacao.css">
</head>
<body>
</body>
</html>
