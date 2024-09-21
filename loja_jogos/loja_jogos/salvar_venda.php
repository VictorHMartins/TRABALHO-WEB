<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente = $_POST['id_cliente'];
    $id_jogo = $_POST['id_jogo'];
    $quantidade = $_POST['quantidade'];

    $stmt = $pdo->prepare("SELECT preco FROM jogos WHERE id_jogo = ?");
    $stmt->execute([$id_jogo]);
    $preco = $stmt->fetchColumn();
    $preco_total = $preco * $quantidade;

    $sql = "INSERT INTO vendas (id_cliente, id_jogo, quantidade, preco_total) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_cliente, $id_jogo, $quantidade, $preco_total]);

    echo "Venda registrada com sucesso!";
}
?>
