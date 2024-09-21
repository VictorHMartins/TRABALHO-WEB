<?php
include 'conexao.php';

// Consulta para obter todos os jogos
$sql = "SELECT j.id_jogo, j.nome, j.plataforma, j.preco, j.quantidade_estoque, f.nome AS fornecedor
        FROM jogos j
        LEFT JOIN fornecedores f ON j.id_fornecedor = f.id_fornecedor";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$jogos = $stmt->fetchAll();
?>

<h2>Relatório de Jogos</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Plataforma</th>
            <th>Preço</th>
            <th>Quantidade em Estoque</th>
            <th>Fornecedor</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($jogos) > 0): ?>
            <?php foreach ($jogos as $jogo): ?>
                <tr>
                    <td><?php echo $jogo['id_jogo']; ?></td>
                    <td><?php echo $jogo['nome']; ?></td>
                    <td><?php echo $jogo['plataforma']; ?></td>
                    <td><?php echo number_format($jogo['preco'], 2, ',', '.'); ?></td>
                    <td><?php echo $jogo['quantidade_estoque']; ?></td>
                    <td><?php echo $jogo['fornecedor'] ?: 'Sem fornecedor'; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Nenhum jogo cadastrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-family: 'Press Start 2P', cursive; /* Fonte pixelada */
        background-color: #222; /* Fundo da tabela */
    }
    th, td {
        padding: 8px;
        text-align: left;
        border: 1px solid #444; /* Borda escura para estilo pixelado */
        color: #fff; /* Cor do texto */
    }
    th {
        background-color: #4CAF50; /* Cor de fundo do cabeçalho */
        color: #fff; /* Cor do texto do cabeçalho */
    }
    tr:nth-child(even) {
        background-color: #333; /* Cor de fundo das linhas pares */
    }
    tr:hover {
        background-color: #555; /* Cor de fundo ao passar o mouse */
    }
</style>
