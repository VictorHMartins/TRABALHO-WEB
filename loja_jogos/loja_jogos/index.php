<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja de Jogos</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Bem-vindo à Loja de Jogos</h1>

    <!-- Menu -->
    <nav>
        <ul>
            <li><a href="#" class="menu-link" data-page="cadastro_jogo.php">Cadastrar Jogos</a></li>
            <li><a href="#" class="menu-link" data-page="cadastro_cliente.php">Cadastrar Cliente</a></li>
            <li><a href="#" class="menu-link" data-page="cadastro_fornecedor.php">Cadastrar Fornecedor</a></li>
            <li><a href="#" class="menu-link" data-page="registro_venda.php">Registrar Venda</a></li>
            <li><a href="#" class="menu-link" data-page="relatorio_clientes.php">Relatório de Clientes</a></li>
            <li><a href="#" class="menu-link" data-page="relatorio_jogos.php">Relatório de Jogos</a></li>
            <li><a href="#" class="menu-link" data-page="relatorio_vendas.php">Relatório de Vendas</a></li>
        </ul>
    </nav>

    <!-- Área para o conteúdo carregado dinamicamente -->
    <div id="conteudo"></div>
    
    <!-- Área para mensagens de feedback -->
    <div id="mensagem" style="color: red; margin-top: 20px;"></div>

    <script>
        $(document).ready(function(){
            // Carregar conteúdo quando um link do menu é clicado
            $('.menu-link').on('click', function(e){
                e.preventDefault(); // Impede o redirecionamento padrão do link
                var page = $(this).data('page'); // Pega o valor do atributo data-page
                
                // Carregar a página selecionada dentro do div #conteudo
                $('#conteudo').load(page, function(response, status, xhr) {
                    if (status == "error") {
                        var msg = "Erro ao carregar a página: " + xhr.status + " " + xhr.statusText;
                        $("#mensagem").text(msg); // Exibir mensagem de erro
                    } else {
                        $("#mensagem").text(""); // Limpar mensagem de erro se a página carregar corretamente
                    }
                });
            });
        });
    </script>
</body>
</html>
