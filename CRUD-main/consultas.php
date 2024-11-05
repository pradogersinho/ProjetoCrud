<?php
// Conectar ao banco de dados
require 'conexao.php';

// Verifica se a ação de excluir foi solicitada
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $query_delete = "DELETE FROM agendamento_consulta WHERE id = $delete_id";
    if (mysqli_query($conexao, $query_delete)) {
        echo "<script>alert('Consulta excluída com sucesso!'); window.location.href = 'consultas.php';</script>";
    } else {
        echo "<script>alert('Erro ao excluir consulta: " . mysqli_error($conexao) . "'); window.location.href = 'consultas.php';</script>";
    }
}

// Verifica se a ação de editar foi solicitada
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $query_edit = "SELECT * FROM agendamento_consulta WHERE id = $edit_id";
    $result_edit = mysqli_query($conexao, $query_edit);
    $consulta = mysqli_fetch_assoc($result_edit);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_id'])) {
    $update_id = $_POST['update_id'];
    $data_consulta = mysqli_real_escape_string($conexao, $_POST['data_consulta']);
    $hora_consulta = mysqli_real_escape_string($conexao, $_POST['hora_consulta']);
    $especialidade = mysqli_real_escape_string($conexao, $_POST['especialidade']);

    $query_update = "UPDATE agendamento_consulta 
                     SET data_consulta = '$data_consulta', hora_consulta = '$hora_consulta', especialidade = '$especialidade'
                     WHERE id = $update_id";

    if (mysqli_query($conexao, $query_update)) {
        echo "<script>alert('Consulta atualizada com sucesso!'); window.location.href = 'consultas.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar consulta: " . mysqli_error($conexao) . "');</script>";
    }
}

// Consulta para listar todas as consultas agendadas
$query = "SELECT * FROM agendamento_consulta";
$result = mysqli_query($conexao, $query);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Consultas</title>
    <!-- Link para o Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link para o seu arquivo CSS personalizado -->
    <link href="styles.css" rel="stylesheet">
</head>
<body>

<header class="bg-success text-white p-3">
    <div class="container">
        <h1>Med-Core Diagnóstico</h1>
    </div>
</header>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <ul class="navbar-nav">
            <li class="nav-item"><a href="index.html" class="nav-link">Início</a></li>
            <li class="nav-item"><a href="consultas.php" class="nav-link">Consultas</a></li>
            <li class="nav-item"><a href="cadastro.php" class="nav-link">Cadastro</a></li>
        </ul>
    </div>
</nav>

<main class="container mt-5">
    <section class="content">
        <h2>Consultas Agendadas</h2>

        <!-- Tabela para exibir as consultas -->
        <table class="consulta-table table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>CPF do Paciente</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Especialidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['cpf_paciente']; ?></td>
                        <td><?php echo $row['data_consulta']; ?></td>
                        <td><?php echo $row['hora_consulta']; ?></td>
                        <td><?php echo $row['especialidade']; ?></td>
                        <td>
                            <a href="consultas.php?edit_id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Editar</a>
                            <a href="consultas.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?');" class="btn btn-danger btn-sm">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Formulário de Edição -->
        <?php if (isset($consulta)) { ?>
            <h2>Editar Consulta</h2>
            <form method="POST" action="consultas.php" class="form-edit">
                <input type="hidden" name="update_id" value="<?php echo $consulta['id']; ?>">

                <div class="form-group">
                    <label for="data_consulta">Data da Consulta:</label>
                    <input type="date" name="data_consulta" class="form-control" value="<?php echo $consulta['data_consulta']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="hora_consulta">Hora da Consulta:</label>
                    <input type="time" name="hora_consulta" class="form-control" value="<?php echo $consulta['hora_consulta']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="especialidade">Especialidade:</label>
                    <select id="especialidade" name="especialidade" class="form-control" required>
                        <option value="">Selecione...</option>
                        <option value="clinica_geral" <?php echo ($consulta['especialidade'] == 'clinica_geral') ? 'selected' : ''; ?>>Clínica Geral</option>
                        <option value="pediatria" <?php echo ($consulta['especialidade'] == 'pediatria') ? 'selected' : ''; ?>>Pediatria</option>
                        <option value="dermatologia" <?php echo ($consulta['especialidade'] == 'dermatologia') ? 'selected' : ''; ?>>Dermatologia</option>
                        <option value="cardiologia" <?php echo ($consulta['especialidade'] == 'cardiologia') ? 'selected' : ''; ?>>Cardiologia</option>
                        <option value="exames_sangue" <?php echo ($consulta['especialidade'] == 'exames_sangue') ? 'selected' : ''; ?>>Exames de Sangue</option>
                        <option value="ultrassonografia" <?php echo ($consulta['especialidade'] == 'ultrassonografia') ? 'selected' : ''; ?>>Ultrassonografia</option>
                        <option value="radiologia" <?php echo ($consulta['especialidade'] == 'radiologia') ? 'selected' : ''; ?>>Radiologia</option>
                        <option value="endocrinologia" <?php echo ($consulta['especialidade'] == 'endocrinologia') ? 'selected' : ''; ?>>Endocrinologia</option>
                        <option value="oftalmologia" <?php echo ($consulta['especialidade'] == 'oftalmologia') ? 'selected' : ''; ?>>Oftalmologia</option>
                        <option value="ortopedia" <?php echo ($consulta['especialidade'] == 'ortopedia') ? 'selected' : ''; ?>>Ortopedia</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success btn-block">Atualizar Consulta</button>
            </form>
        <?php } ?>
    </section>
</main>

<footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2024 Med-Core Diagnóstico | Todos os direitos reservados</p>
</footer>

<!-- Link para o JavaScript do Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
// Fechar a conexão com o banco de dados
mysqli_close($conexao);
?>
