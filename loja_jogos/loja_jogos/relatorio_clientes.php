<?php
include 'conexao.php';

// Consulta todos os clientes
$sql = "SELECT * FROM clientes";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$clientes = $stmt->fetchAll();
?>

<h2>Relatório de Clientes</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Telefone</th>
    </tr>
    <?php foreach ($clientes as $cliente): ?>
        <tr>
            <td><?php echo $cliente['id_cliente']; ?></td>
            <td><?php echo $cliente['nome']; ?></td>
            <td><?php echo $cliente['email']; ?></td>
            <td><?php echo $cliente['telefone']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
]