<?php
require 'conexao.php'; // Conectar ao banco de dados

// Verifica se o formulário de cadastro de paciente foi submetido
if (isset($_POST['nome'], $_POST['data_nascimento'], $_POST['cpf'], $_POST['rg'], $_POST['genero'], $_POST['tipo_sanguineo'], $_POST['endereco'], $_POST['telefone'])) {
    // Escapar os dados para evitar SQL Injection
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $data_nascimento = mysqli_real_escape_string($conexao, $_POST['data_nascimento']);
    $cpf = mysqli_real_escape_string($conexao, $_POST['cpf']);
    $rg = mysqli_real_escape_string($conexao, $_POST['rg']);
    $genero = mysqli_real_escape_string($conexao, $_POST['genero']);
    $tipo_sanguinea = mysqli_real_escape_string($conexao, $_POST['tipo_sanguineo']);
    $endereco = mysqli_real_escape_string($conexao, $_POST['endereco']);
    $telefone = mysqli_real_escape_string($conexao, $_POST['telefone']);

    // Comando SQL para inserir os dados no banco
    $query = "INSERT INTO cadastro (nome, data_nascimento, cpf, rg, genero, tipo_sanguinea, endereco, telefone) 
              VALUES ('$nome', '$data_nascimento', '$cpf', '$rg', '$genero', '$tipo_sanguinea', '$endereco', '$telefone')";

    // Verificar se a query foi executada com sucesso
    if (mysqli_query($conexao, $query)) {
        // Se sucesso, redireciona para o index.html
        echo "<script>alert('Paciente cadastrado com sucesso!'); window.location.href = 'index.html';</script>";
    } else {
        // Caso ocorra erro na query, mostre o erro e redirecione
        echo "<script>alert('Erro ao cadastrar paciente: " . mysqli_error($conexao) . "'); window.location.href = 'index.html';</script>";
    }
}

// Fechar a conexão com o banco de dados
mysqli_close($conexao);
?>
