<?php
include 'conexao.php';

// Consulta todas as vendas
$sql = "SELECT v.id_venda, c.nome AS cliente, j.nome AS jogo, v.quantidade, v.data_venda, v.preco_total 
        FROM vendas v 
        JOIN clientes c ON v.id_cliente = c.id_cliente 
        JOIN jogos j ON v.id_jogo = j.id_jogo";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$vendas = $stmt->fetchAll();
?>

<h2>Relatório de Vendas</h2>

<table border="1">
    <tr>
        <th>ID Venda</th>
        <th>Cliente</th>
        <th>Jogo</th>
        <th>Quantidade</th>
        <th>Data da Venda</th>
        <th>Preço Total</th>
    </tr>
    <?php foreach ($vendas as $venda): ?>
        <tr>
            <td><?php echo $venda['id_venda']; ?></td>
            <td><?php echo $venda['cliente']; ?></td>
            <td><?php echo $venda['jogo']; ?></td>
            <td><?php echo $venda['quantidade']; ?></td>
            <td><?php echo $venda['data_venda']; ?></td>
            <td><?php echo number_format($venda['preco_total'], 2, ',', '.'); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
