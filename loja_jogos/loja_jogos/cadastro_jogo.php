<?php
include 'conexao.php';

$message = ""; // Variável para armazenar mensagens

// Consulta para obter todos os fornecedores
$sql_fornecedores = "SELECT id_fornecedor, nome FROM fornecedores";
$stmt_fornecedores = $pdo->prepare($sql_fornecedores);
$stmt_fornecedores->execute();
$fornecedores = $stmt_fornecedores->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $plataforma = $_POST['plataforma'];
    $preco = $_POST['preco'];
    $quantidade_estoque = $_POST['quantidade_estoque'];
    $fornecedor_id = $_POST['fornecedor']; // Pegar o ID do fornecedor selecionado

    try {
        // Verificar se o jogo já existe no banco de dados
        $sql_verificar = "SELECT * FROM jogos WHERE nome = ? AND plataforma = ?";
        $stmt_verificar = $pdo->prepare($sql_verificar);
        $stmt_verificar->execute([$nome, $plataforma]);
        $jogo_existente = $stmt_verificar->fetch(PDO::FETCH_ASSOC);

        if ($jogo_existente) {
            // Se o jogo já existe, atualizar a quantidade de estoque
            $nova_quantidade = $jogo_existente['quantidade_estoque'] + $quantidade_estoque;
            $sql_atualizar = "UPDATE jogos SET quantidade_estoque = ?, preco = ? WHERE id = ?";
            $stmt_atualizar = $pdo->prepare($sql_atualizar);
            $stmt_atualizar->execute([$nova_quantidade, $preco, $jogo_existente['id']]);
            $message = "Estoque atualizado com sucesso!";
        } else {
            // Se o jogo não existe, inserir um novo registro
            $sql_inserir = "INSERT INTO jogos (nome, plataforma, preco, quantidade_estoque, id_fornecedor) VALUES (?, ?, ?, ?, ?)";
            $stmt_inserir = $pdo->prepare($sql_inserir);
            if ($stmt_inserir->execute([$nome, $plataforma, $preco, $quantidade_estoque, $fornecedor_id])) {
                $message = "Jogo cadastrado com sucesso!";
            } else {
                $message = "Erro ao cadastrar o jogo.";
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

<h2>Cadastrar Jogo</h2>
<form id="form-jogo" method="post">
    Nome: <input type="text" name="nome" required><br>
    Plataforma: <input type="text" name="plataforma" required><br>
    Preço: <input type="text" name="preco" required><br>
    Quantidade em Estoque: <input type="number" name="quantidade_estoque" required><br>
    Fornecedor:
    <select name="fornecedor" required>
        <option value="">Selecione um fornecedor</option>
        <?php foreach ($fornecedores as $fornecedor): ?>
            <option value="<?php echo $fornecedor['id_fornecedor']; ?>"><?php echo $fornecedor['nome']; ?></option>
        <?php endforeach; ?>
    </select><br>
    <input type="submit" value="Cadastrar Jogo">
</form>

<!-- Área para mostrar mensagens -->
<div id="mensagem" style="color: green; font-weight: bold; margin-top: 10px;"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Usando jQuery para enviar o formulário via AJAX
    $('#form-jogo').on('submit', function(e) {
        e.preventDefault(); // Impede o envio padrão do formulário
        $.ajax({
            type: 'POST',
            url: 'cadastro_jogo.php', // A mesma página para onde o formulário normalmente enviaria
            data: $(this).serialize(), // Envia os dados do formulário
            success: function(response) {
                // Exibir a resposta do servidor na área de mensagem
                $('#mensagem').html(response);
                // Opcional: limpar o formulário após o envio
                $('#form-jogo')[0].reset();
            },
            error: function() {
                $('#mensagem').html('Erro ao cadastrar o jogo.');
            }
        });
    });
</script>
