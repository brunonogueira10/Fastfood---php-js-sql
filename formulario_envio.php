<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['carrinho'] = $_POST['quantidade'];
    $_SESSION['total'] = $_POST['total'];
} else {
    die("Acesso inválido.");
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações para Envio</title>
    <link rel="stylesheet" href="style/formulario_envio.css">
</head>
<body>

    <form action="finalizar_transacao.php" method="POST">
    <h1>Informações para Envio</h1>
        <label for="nome">Nome Completo:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" id="data_nascimento" name="data_nascimento" required>

        <label for="morada">Morada:</label>
        <textarea id="morada" name="morada" required></textarea>

        <button type="submit">Concluir Transação</button>
    </form>
</body>
</htm
