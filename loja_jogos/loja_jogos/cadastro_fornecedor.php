<?php
include 'conexao.php';
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];

    try {
        $sql_inserir = "INSERT INTO fornecedores (nome, telefone, email, endereco) VALUES (?, ?, ?, ?)";
        $stmt_inserir = $pdo->prepare($sql_inserir);
        if ($stmt_inserir->execute([$nome, $telefone, $email, $endereco])) {
            $message = "Fornecedor cadastrado com sucesso!";
        } else {
            $message = "Erro ao cadastrar o fornecedor.";
        }
    } catch (PDOException $e) {
        $message = "Erro: " . $e->getMessage();
    }

    // Retornar a mensagem como resposta
    echo $message;
    exit;
}
?>

<h2>Cadastrar Fornecedor</h2>
<form id="form-fornecedor" method="post">
    Nome: <input type="text" name="nome" required><br>
    Telefone: <input type="text" name="telefone" required><br>
    Email: <input type="email" name="email" required><br>
    Endereço: <input type="text" name="endereco" required><br>
    <input type="submit" value="Cadastrar Fornecedor">
</form>

<div id="mensagem-fornecedor" style="color: green; font-weight: bold; margin-top: 10px;"></div>

<script>
    $('#form-fornecedor').on('submit', function(e) {
        e.preventDefault(); // Impede o envio padrão do formulário
        $.ajax({
            type: 'POST',
            url: 'cadastro_fornecedor.php', // A mesma página para onde o formulário normalmente enviaria
            data: $(this).serialize(), // Envia os dados do formulário
            success: function(response) {
                // Exibir a resposta do servidor na área de mensagem
                $('#mensagem-fornecedor').html(response);
                $('#form-fornecedor')[0].reset(); // Limpa o formulário
            },
            error: function() {
                $('#mensagem-fornecedor').html('Erro ao cadastrar o fornecedor.');
            }
        });
    });
</script>
