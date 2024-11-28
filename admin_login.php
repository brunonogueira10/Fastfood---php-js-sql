<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    $stmt = $pdo->prepare("SELECT * FROM Utilizadores WHERE nome_utilizador = ? AND senha = ?");
    $stmt->execute([$username, $password]);
    $admin = $stmt->fetch();

    if ($admin) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "Nome de utilizador ou palavra-passe incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração - Login</title>
    <link rel="stylesheet" href="style/admin_login.css">
</head>
<body>
    <h1>Administração</h1>
    <?php if (isset($error)): ?>
        <div class="error-message">
            <p><?= htmlspecialchars($error) ?></p>
        </div>
    <?php endif; ?>
    <form method="POST">
        <label for="username">Nome de Utilizador:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Palavra-passe:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Entrar</button>
        <a href="index.php" class="back-link">Voltar para a Página Inicial</a>
    </form>
</body>
</html>
