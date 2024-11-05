<?php
require 'conexao.php'; // Conectar ao banco de dados


// Verifica se o formulário de agendamento de consulta foi submetido
if (isset($_POST['cpf'], $_POST['data_consulta'], $_POST['hora_consulta'], $_POST['especialidade'])) {
    // Escapar os dados para evitar SQL Injection
    $cpf = mysqli_real_escape_string($conexao, $_POST['cpf']);
    $data_consulta = mysqli_real_escape_string($conexao, $_POST['data_consulta']);
    $hora_consulta = mysqli_real_escape_string($conexao, $_POST['hora_consulta']);
    $especialidade = mysqli_real_escape_string($conexao, $_POST['especialidade']);

    // Verifique se o CPF corresponde a um paciente existente
    $consultaPaciente = "SELECT * FROM cadastro WHERE cpf = '$cpf'";
    $resultadoPaciente = mysqli_query($conexao, $consultaPaciente);

    if (mysqli_num_rows($resultadoPaciente) > 0) {
        // Se o paciente existir, insira o agendamento no banco
        $query = "INSERT INTO agendamento_consulta (cpf_paciente, data_consulta, hora_consulta, especialidade) 
                  VALUES ('$cpf', '$data_consulta', '$hora_consulta', '$especialidade')";
        
        if (mysqli_query($conexao, $query)) {
            echo "<script>alert('Consulta agendada com sucesso!'); window.location.href = 'index.html';</script>";
        } else {
            echo "<script>alert('Erro ao agendar consulta: " . mysqli_error($conexao) . "'); window.location.href = 'index.html';</script>";
        }
    } else {
        echo "<script>alert('Paciente não encontrado. Verifique o CPF informado.'); window.location.href = 'index.html';</script>";
    }
} 

// Fechar a conexão com o banco de dados
mysqli_close($conexao);
?>