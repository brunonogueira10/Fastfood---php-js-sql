<?php
include 'db.php';
session_start();

$stmt = $pdo->query("SELECT * FROM Produtos");
$produtos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast-Food Online</title>
    <link rel="stylesheet" href="style/index.css">
    <script>
        function atualizarTotal() {
            let total = 0;

            document.querySelectorAll('.product-item').forEach(function (item) {
                const preco = parseFloat(item.querySelector('.preco').innerText);
                const quantidade = parseInt(item.querySelector('.quantidade').value) || 0;

                total += preco * quantidade;
            });

            document.getElementById('totalCompra').innerText = total.toFixed(2);
        }

        function prepararCompra() {
            let form = document.getElementById('compraForm');
            let total = 0;

            document.querySelectorAll('input[type="hidden"]').forEach(function (input) {
                input.remove();
            });

            document.querySelectorAll('.product-item').forEach(function (item) {
                const preco = parseFloat(item.querySelector('.preco').innerText);
                const quantidadeDisponivel = parseInt(item.dataset.quantidade);
                const quantidade = parseInt(item.querySelector('.quantidade').value) || 0;

                if (quantidade > 0 && quantidade <= quantidadeDisponivel) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'quantidade[' + item.dataset.id + ']';
                    input.value = quantidade;
                    form.appendChild(input);

                    total += preco * quantidade;
                }
            });

            if (total === 0) {
                alert('Por favor, selecione ao menos um produto.');
                return false;
            }

            const totalInput = document.createElement('input');
            totalInput.type = 'hidden';
            totalInput.name = 'total';
            totalInput.value = total.toFixed(2);
            form.appendChild(totalInput);

            return true;
        }
    </script>
</head>
<body>
    <h1>Bem-vindo ao Fast-Food Online</h1>

    <h2>Produtos Disponíveis</h2>
    <form id="compraForm" action="formulario_envio.php" method="POST" onsubmit="return prepararCompra();">
        <div class="product-list">
            <?php foreach ($produtos as $produto): ?>
                <div class="product-item" 
                     data-id="<?= $produto['id'] ?>" 
                     data-nome="<?= htmlspecialchars($produto['nome']) ?>" 
                     data-quantidade="<?= $produto['quantidade'] ?>">
                    <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                    <p>Preço: €<span class="preco"><?= number_format($produto['preco'], 2) ?></span></p>
                    <p>
                        Quantidade disponível: 
                        <?php if ($produto['quantidade'] > 0): ?>
                            <?= $produto['quantidade'] ?>
                        <?php else: ?>
                            <span class="out-of-stock">Fora de estoque</span>
                        <?php endif; ?>
                    </p>
                    <input 
                        type="number" 
                        class="quantidade" 
                        placeholder="Quantidade" 
                        min="0" 
                        max="<?= $produto['quantidade'] ?>" 
                        <?= $produto['quantidade'] === 0 ? 'disabled' : '' ?>
                        oninput="atualizarTotal()">
                </div>
            <?php endforeach; ?>
        </div>

        <h3>Total da Compra: €<span id="totalCompra">0.00</span></h3>

        <button type="submit">Concluir Compra</button>
    </form>

    <a href="admin_login.php">Ir para Administração</a>
</body>
</html>
