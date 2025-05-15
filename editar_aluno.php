<?php
// Conexão com o banco de dados
include 'conexao.php';


if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Verifica se o ID foi passado
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM alunos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $alunos = $result->fetch_assoc();
    } else {
        die("Aluno não encontrado.");
    }
} else {
    die("ID do aluno não especificado.");
}

// Atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = $_POST;

    $sql = "UPDATE alunos SET 
        nome = ?, nome_social = ?, cpf = ?, rg = ?, data_nascimento = ?, pais = ?, deficiencia = ?,
        nome_pai = ?, nome_mae = ?, responsavel = ?, rg_responsavel = ?, tipo_responsavel = ?, 
        tel_responsavel = ?, trabalho_responsavel = ?, tel_trabalho_responsavel = ?, renda_responsavel = ?, 
        email_responsavel = ?, email_aluno = ?, endereco = ?, bairro = ?, cidade = ?, uf = ?, cep = ?, 
        complemento = ?, telefone_fixo = ?, cel_responsavel = ?, cor = ?, ra = ?, registro_sus = ?, nis = ?, 
        tipo_sanguineo = ?, medicamento = ?, genero = ?, tem_gemeos = ?, quantos_gemeos = ?
        WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $valores = array_values($dados);
    $valores[] = $id;

    $tipos = str_repeat('s', count($dados)) . 'i';

    $stmt->bind_param($tipos, ...$valores);

    if ($stmt->execute()) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Atualizado!',
                    text: 'Você atualizou o aluno com sucesso.',
                    icon: 'success'
                }).then(function() {
                    window.location.href = 'editar_aluno.php?id=" . $id . "'; // Navega para a página de edição novamente
                });
            });
        </script>";
    } else {
        echo "<div class='alert alert-danger text-center mt-3'>Erro ao atualizar aluno: " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-purple mb-4">
  <div class="container">
    <a class="navbar-brand" href="index.php">Thurma</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="cadastro.html">Cadastro</a></li>
        <li class="nav-item"><a class="nav-link" href="listagem.php">Listagem</a></li>
    </ul>
    </div>
  </div>
</nav>

<div class="container bg-white shadow-lg rounded p-4 mb-5">
    <div class="container my-4">
    <h2 class="text-center text-purple mb-4">Editar aluno</h2>
        <form method="POST" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nome</label>
                <input type="text" class="form-control" name="nome" value="<?= $alunos['nome'] ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nome Social</label>
                <input type="text" class="form-control" name="nome_social" value="<?= $alunos['nome_social'] ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">CPF</label>
                <input type="text" class="form-control cpf" name="cpf" value="<?= $alunos['cpf'] ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">RG</label>
                <input type="text" class="form-control rg" name="rg" value="<?= $alunos['rg'] ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" name="data_nascimento" value="<?= $alunos['data_nascimento'] ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label">pais</label>
                <select class="form-select" name="pais">
                    <option value="" disabled>Informe o nome do país</option>
                    <option value="Brasil" <?= $alunos['pais'] === 'Brasil' ? 'selected' : '' ?>>Brasil</option>
                    <option value="Argentina" <?= $alunos['pais'] === 'Argentina' ? 'selected' : '' ?>>Argentina</option>
                    <option value="Estados Unidos" <?= $alunos['pais'] === 'Estados Unidos' ? 'selected' : '' ?>>Estados Unidos</option>
                    <option value="Canadá" <?= $alunos['pais'] === 'Canadá' ? 'selected' : '' ?>>Canadá</option>
                    <option value="Portugal" <?= $alunos['pais'] === 'Portugal' ? 'selected' : '' ?>>Portugal</option>
                    <option value="Espanha" <?= $alunos['pais'] === 'Espanha' ? 'selected' : '' ?>>Espanha</option>
                    <option value="França" <?= $alunos['pais'] === 'França' ? 'selected' : '' ?>>França</option>
                    <option value="Alemanha" <?= $alunos['pais'] === 'Alemanha' ? 'selected' : '' ?>>Alemanha</option>
                    <option value="Japão" <?= $alunos['pais'] === 'Japão' ? 'selected' : '' ?>>Japão</option>
                    <option value="China" <?= $alunos['pais'] === 'China' ? 'selected' : '' ?>>China</option>
                    <option value="Índia" <?= $alunos['pais'] === 'Índia' ? 'selected' : '' ?>>Índia</option>
                    <!-- Adicione mais países conforme necessário -->
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Deficiência</label>
                <select name="deficiencia" class="form-select">
                    <option value="nao" <?= $alunos['deficiencia'] === 'nao' ? 'selected' : '' ?>>Não</option>
                    <option value="sim" <?= $alunos['deficiencia'] === 'sim' ? 'selected' : '' ?>>Sim</option>
                </select>
            </div>

            <!-- Responsável -->
            <div class="col-md-6">
                <label class="form-label">Nome do Pai</label>
                <input type="text" class="form-control" name="nome_pai" value="<?= $alunos['nome_pai'] ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Nome da Mãe</label>
                <input type="text" class="form-control" name="nome_mae" value="<?= $alunos['nome_mae'] ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Responsável</label>
                <input type="text" class="form-control" name="responsavel" value="<?= $alunos['responsavel'] ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">RG Responsável</label>
                <input type="text" class="form-control rg" name="rg_responsavel" value="<?= $alunos['rg_responsavel'] ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Tipo</label>
                <input type="text" class="form-control" name="tipo_responsavel" value="<?= $alunos['tipo_responsavel'] ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label">Telefone Responsável</label>
                <input type="text" class="form-control telefone" name="tel_responsavel" value="<?= $alunos['tel_responsavel'] ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Trabalho Responsável</label>
                <input type="text" class="form-control" name="trabalho_responsavel" value="<?= $alunos['trabalho_responsavel'] ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Telefone do Trabalho</label>
                <input type="text" class="form-control telefone" name="tel_trabalho_responsavel" value="<?= $alunos['tel_trabalho_responsavel'] ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label">Renda</label>
                <input type="text" class="form-control" name="renda_responsavel" value="<?= $alunos['renda_responsavel'] ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Email Responsável</label>
                <input type="email" class="form-control" name="email_responsavel" value="<?= $alunos['email_responsavel'] ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Email Aluno</label>
                <input type="email" class="form-control" name="email_aluno" value="<?= $alunos['email_aluno'] ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Endereço</label>
                <input type="text" class="form-control" name="endereco" value="<?= $alunos['endereco'] ?>">
            </div>

            <!-- Restantes -->
            <div class="col-md-4">
                <label class="form-label">Bairro</label>
                <input type="text" class="form-control" name="bairro" value="<?= $alunos['bairro'] ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Cidade</label>
                <input type="text" class="form-control" name="cidade" value="<?= $alunos['cidade'] ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label">UF</label>
                <input type="text" class="form-control" name="uf" value="<?= $alunos['uf'] ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label">CEP</label>
                <input type="text" class="form-control cep" name="cep" value="<?= $alunos['cep'] ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Complemento</label>
                <input type="text" class="form-control" name="complemento" value="<?= $alunos['complemento'] ?>">
            </div>

            <!-- Contato -->
            <div class="col-md-4">
                <label class="form-label">Telefone Fixo</label>
                <input type="text" class="form-control telefone" name="telefone_fixo" value="<?= $alunos['telefone_fixo'] ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Celular Responsável</label>
                <input type="text" class="form-control telefone" name="cel_responsavel" value="<?= $alunos['cel_responsavel'] ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Cor</label>
                <input type="text" class="form-control" name="cor" value="<?= $alunos['cor'] ?>">
            </div>

            <!-- Outros Campos -->
            <div class="col-md-4">
                <label class="form-label">RA</label>
                <input type="text" class="form-control" name="ra" maxlength="5" value="<?= $alunos['ra'] ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Registro SUS</label>
                <input type="text" class="form-control" name="registro_sus" value="<?= $alunos['registro_sus'] ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">NIS</label>
                <input type="text" class="form-control" name="nis" value="<?= $alunos['nis'] ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label">Tipo Sanguíneo</label>
                <input type="text" class="form-control" name="tipo_sanguineo" value="<?= $alunos['tipo_sanguineo'] ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Medicamento</label>
                <input type="text" class="form-control" name="medicamento" value="<?= $alunos['medicamento'] ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Gênero</label>
                <input type="text" class="form-control" name="genero" value="<?= $alunos['genero'] ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Tem Gêmeos?</label>
                <select class="form-select" name="tem_gemeos">
                    <option value="nao" <?= $alunos['tem_gemeos'] === 'nao' ? 'selected' : '' ?>>Não</option>
                    <option value="sim" <?= $alunos['tem_gemeos'] === 'sim' ? 'selected' : '' ?>>Sim</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Quantos Gêmeos?</label>
                <input type="number" class="form-control" name="quantos_gemeos" value="<?= $alunos['quantos_gemeos'] ?>">
            </div>

            <div class="col-12 text-center mt-4">
                <button type="button" class="btn-cinza" onclick="window.location.href='listagem.php'">Voltar</button>
                <button type="submit" class="btn-purple">Atualizar</button>
            </div>
        </form>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-mask-plugin@1.14.16/dist/jquery.mask.min.js"></script>
    <script>
        $('.cpf').mask('000.000.000-00');
        $('.rg').mask('00.000.000-0');
        $('.telefone').mask('(00) 00000-0000');
        $('.cep').mask('00000-000');
    </script>
    
</body>
</html>
