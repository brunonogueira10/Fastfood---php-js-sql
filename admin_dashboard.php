<?php
include 'db.php';
session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $nome = htmlspecialchars(trim($_POST['nome']));
    $quantidade = intval($_POST['quantidade']);
    $preco = floatval($_POST['preco']);

    $stmt = $pdo->prepare("INSERT INTO Produtos (nome, quantidade, preco) VALUES (?, ?, ?)");
    $stmt->execute([$nome, $quantidade, $preco]);
    $message = "Produto adicionado com sucesso!";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_product'])) {
    $id = intval($_POST['id']);
    $quantidade = intval($_POST['quantidade']);
    $preco = floatval($_POST['preco']);

    $stmt = $pdo->prepare("UPDATE Produtos SET quantidade = ?, preco = ? WHERE id = ?");
    $stmt->execute([$quantidade, $preco, $id]);
    $message = "Produto atualizado com sucesso!";
}

$encomendas = $pdo->query("SELECT * FROM Encomendas")->fetchAll();

$produtos = $pdo->query("SELECT * FROM Produtos")->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
    <link rel="stylesheet" href="style/admin_dashboard.css">
 
</head>
<body>
    <h1>Painel de Administração</h1>
    <?php if (isset($message)): ?>
        <div class="success-message">
            <p><?= htmlspecialchars($message) ?></p>
        </div>
    <?php endif; ?>

    <h2>Encomendas Realizadas</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome do Cliente</th>
            <th>Data de Nascimento</th>
            <th>Morada</th>
            <th>Produto ID</th>
            <th>Quantidade</th>
            <th>Preço Total</th>
        </tr>
        <?php foreach ($encomendas as $encomenda): ?>
            <tr>
                <td><?= $encomenda['id'] ?></td>
                <td><?= htmlspecialchars($encomenda['nome']) ?></td>
                <td><?= $encomenda['data_nascimento'] ?></td>
                <td><?= htmlspecialchars($encomenda['morada']) ?></td>
                <td><?= $encomenda['produto_id'] ?></td>
                <td><?= $encomenda['quantidade'] ?></td>
                <td>€<?= number_format($encomenda['preco_total'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Produtos</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Quantidade</th>
            <th>Preço</th>
            <th>Atualizar</th>
        </tr>
        <?php foreach ($produtos as $produto): ?>
            <tr>
                <td><?= $produto['id'] ?></td>
                <td><?= htmlspecialchars($produto['nome']) ?></td>
                <td><?= $produto['quantidade'] ?></td>
                <td>€<?= number_format($produto['preco'], 2) ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                        <input type="number" name="quantidade" placeholder="Quantidade" required>
                        <input type="number" step="0.01" name="preco" placeholder="Preço" required>
                        <button type="submit" name="update_product">Atualizar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Adicionar Novo Produto</h2>
    <form class="add-produto" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <label for="quantidade">Quantidade:</label>
        <input type="number" id="quantidade" name="quantidade" required>
        <label for="preco">Preço:</label>
        <input type="number" step="0.01" id="preco" name="preco" required>
        <button type="submit" name="add_product">Adicionar Produto</button>
    </form>

    <a href="index.php">Sair</a>
</body>
</html>
