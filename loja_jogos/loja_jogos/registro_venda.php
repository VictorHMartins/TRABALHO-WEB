<?php
include 'conexao.php';
$message = "";

// Consultar clientes
$sql_clientes = "SELECT id_cliente, nome FROM clientes";
$stmt_clientes = $pdo->prepare($sql_clientes);
$stmt_clientes->execute();
$clientes = $stmt_clientes->fetchAll();

// Consultar jogos
$sql_jogos = "SELECT id_jogo, nome FROM jogos";
$stmt_jogos = $pdo->prepare($sql_jogos);
$stmt_jogos->execute();
$jogos = $stmt_jogos->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $id_jogo = $_POST['id_jogo'];
    $quantidade = $_POST['quantidade'];
    $data_venda = date('Y-m-d'); // Data atual

    // Obter o preço do jogo
    $sql_preco = "SELECT preco FROM jogos WHERE id_jogo = ?";
    $stmt_preco = $pdo->prepare($sql_preco);
    $stmt_preco->execute([$id_jogo]);
    $preco_jogo = $stmt_preco->fetchColumn();
    
    $preco_total = $preco_jogo * $quantidade; // Calcular o preço total

    try {
        $sql_inserir = "INSERT INTO vendas (id_cliente, id_jogo, quantidade, data_venda, preco_total) VALUES (?, ?, ?, ?, ?)";
        $stmt_inserir = $pdo->prepare($sql_inserir);
        if ($stmt_inserir->execute([$id_cliente, $id_jogo, $quantidade, $data_venda, $preco_total])) {
            $message = "Venda registrada com sucesso!";
        } else {
            $message = "Erro ao registrar a venda.";
        }
    } catch (PDOException $e) {
        $message = "Erro: " . $e->getMessage();
    }

    // Retornar a mensagem como resposta
    echo $message;
    exit;
}
?>

<h2>Registrar Venda</h2>
<form id="form-venda" method="post">
    Cliente: 
    <select name="id_cliente" required>
        <option value="">Selecione um cliente</option>
        <?php foreach ($clientes as $cliente): ?>
            <option value="<?php echo $cliente['id_cliente']; ?>"><?php echo $cliente['nome']; ?></option>
        <?php endforeach; ?>
    </select><br>

    Jogo: 
    <select name="id_jogo" required>
        <option value="">Selecione um jogo</option>
        <?php foreach ($jogos as $jogo): ?>
            <option value="<?php echo $jogo['id_jogo']; ?>"><?php echo $jogo['nome']; ?></option>
        <?php endforeach; ?>
    </select><br>

    Quantidade: <input type="number" name="quantidade" required><br>
    
    <input type="submit" value="Registrar Venda">
</form>

<div id="mensagem-venda" style="color: green; font-weight: bold; margin-top: 10px;"></div>

<script>
    $('#form-venda').on('submit', function(e) {
        e.preventDefault(); // Impede o envio padrão do formulário
        $.ajax({
            type: 'POST',
            url: 'registro_venda.php', // A mesma página para onde o formulário normalmente enviaria
            data: $(this).serialize(), // Envia os dados do formulário
            success: function(response) {
                // Exibir a resposta do servidor na área de mensagem
                $('#mensagem-venda').html(response);
                $('#form-venda')[0].reset(); // Limpa o formulário
            },
            error: function() {
                $('#mensagem-venda').html('Erro ao registrar a venda.');
            }
        });
    });
</script>
