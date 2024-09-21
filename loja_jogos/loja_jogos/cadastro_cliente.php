<?php
include 'conexao.php';

$message = ""; // Variável para armazenar mensagens

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    try {
        // Verificar se o cliente já existe no banco de dados (opcional)
        $sql_verificar = "SELECT * FROM clientes WHERE email = ?";
        $stmt_verificar = $pdo->prepare($sql_verificar);
        $stmt_verificar->execute([$email]);
        $cliente_existente = $stmt_verificar->fetch(PDO::FETCH_ASSOC);

        if ($cliente_existente) {
            $message = "Cliente já cadastrado com este e-mail.";
        } else {
            // Inserir um novo cliente
            $sql = "INSERT INTO clientes (nome, email, telefone) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$nome, $email, $telefone])) {
                $message = "Cliente cadastrado com sucesso!";
            } else {
                $message = "Erro ao cadastrar o cliente.";
            }
        }
    } catch (PDOException $e) {
        $message = "Erro: " . $e->getMessage();
    }
    // Retornar a mensagem como resposta
    echo $message;
    exit; // Encerrar a execução após a resposta
}
?>

<h2>Cadastrar Cliente</h2>
<form id="form-cliente" method="post">
    Nome: <input type="text" name="nome" required><br>
    E-mail: <input type="email" name="email" required><br>
    Telefone: <input type="text" name="telefone" required><br>
    <input type="submit" value="Cadastrar Cliente">
</form>

<!-- Área para mostrar mensagens -->
<div id="mensagem" style="color: green; font-weight: bold; margin-top: 10px;"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Usando jQuery para enviar o formulário via AJAX
    $('#form-cliente').on('submit', function(e) {
        e.preventDefault(); // Impede o envio padrão do formulário
        $.ajax({
            type: 'POST',
            url: 'cadastro_cliente.php', // A mesma página para onde o formulário normalmente enviaria
            data: $(this).serialize(), // Envia os dados do formulário
            success: function(response) {
                // Exibir a resposta do servidor na área de mensagem
                $('#mensagem').html(response);
                // Opcional: limpar o formulário após o envio
                $('#form-cliente')[0].reset();
            },
            error: function() {
                $('#mensagem').html('Erro ao cadastrar o cliente.');
            }
        });
    });
</script>
