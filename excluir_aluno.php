<?php
// Conexão com o banco de dados
include 'conexao.php';

// Verificando a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Verifica se o ID do aluno foi passado via URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Prepara a consulta para excluir o aluno
    $sql = "DELETE FROM alunos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Excluido!',
                    text: 'Você excluiu o aluno com sucesso.',
                    icon: 'success'
                }).then(function() {
                    window.location.href = 'listagem.php'; // Navega para a página de edição novamente
                });
            });
        </script>";
    } else {
        echo "<div class='alert alert-danger text-center mt-3'>Erro ao excluir aluno: " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conn->close();
} else {
    die("ID do aluno não especificado ou inválido.");
}
?>
