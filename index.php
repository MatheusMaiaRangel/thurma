<?php
include 'conexao.php';

// Inicializa os filtros
$cpf = '';
$temGemeos = '';
$genero = '';
$nacionalidade = '';
$dataNascimento = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cpf = isset($_POST['cpf']) ? trim($_POST['cpf']) : '';
    $temGemeos = isset($_POST['temGemeo']) ? $_POST['temGemeo'] : '';
    $genero = isset($_POST['genero']) ? $_POST['genero'] : '';
    $nacionalidade = isset($_POST['nacionalidade']) ? trim($_POST['nacionalidade']) : '';
    $dataNascimento = isset($_POST['dataNascimento']) ? $_POST['dataNascimento'] : '';

    // Monta a query com base nos filtros
    $query = "SELECT id, nome, cpf, ra FROM alunos WHERE 1=1";
    $params = [];
    $types = '';

    if (!empty($cpf)) {
        $query .= " AND cpf = ?";
        $params[] = $cpf;
        $types .= 's';
    }
    if (!empty($temGemeos)) {
        $query .= " AND tem_gemeos = ?";
        $params[] = $temGemeos;
        $types .= 's';
    }
    if (!empty($genero)) {
        $query .= " AND genero = ?";
        $params[] = $genero;
        $types .= 's';
    }
    if (!empty($nacionalidade)) {
        $query .= " AND nacionalidade = ?";
        $params[] = $nacionalidade;
        $types .= 's';
    }
    if (!empty($dataNascimento)) {
        $query .= " AND data_nascimento = ?";
        $params[] = $dataNascimento;
        $types .= 's';
    }

    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT id, nome, cpf, ra FROM alunos ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Lista de Alunos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-purple mb-4">
  <div class="container">
    <a class="navbar-brand" href="index.php">Thurma</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="cadastro.html">Cadastro</a></li>
    </ul>
    </div>
  </div>
</nav>

<div class="container bg-white shadow-lg rounded p-4 mb-5">
  <h2 class="text-center text-purple mb-4">Lista de Alunos</h2>

  <!-- Formulário de pesquisa -->
  <form method="POST" class="d-flex mb-4 col-md-6 mx-auto" role="search">
      <input class="form-control me-2 border border-primary fw-bold" type="text" name="cpf" id="cpf"
             placeholder="Pesquisar por CPF" value="<?= htmlspecialchars($cpf) ?>" required>
      <button class="" type="submit"><img src="img/search.png"></button>
  </form>

  <div class="table-responsive">
    <DIV>
    <div class="text-end mb-3"> 
      <a href="cadastro.html"><img src="img/user.png"></a>
       <button type="button" data-bs-toggle="modal" data-bs-target="#filterModal">
      <img src="img/filter.png">
      </button>
    </div>

    </DIV>
    
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-dark text-center">
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>CPF</th>
          <th>RA</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td class="text-center"><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['nome']) ?></td>
              <td><?= htmlspecialchars($row['cpf']) ?></td>
              <td><?= htmlspecialchars($row['ra']) ?></td>
              <td class="text-center">
  <a href="editar_aluno.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning me-2">Editar</a>
  <a href="javascript:void(0);" class="btn btn-sm btn-danger" 
     onclick="confirmDelete(<?= $row['id'] ?>)">Excluir</a>
</td>

            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
              <td colspan="5" class="text-center text-muted">Nenhum aluno encontrado.</td>
            </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal de Filtros -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="filterModalLabel">Filtros Avançados</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST">
        <div class="modal-body">
          <!-- Campo Tem Gêmeos -->
          <div class="mb-3">
            <label for="temGemeo" class="form-label">Tem Gêmeos?</label>
            <select class="form-select" name="temGemeo" id="temGemeo">
              <option value="">Selecione</option>
              <option value="sim">Sim</option>
              <option value="nao">Não</option>
            </select>
          </div>
          <!-- Campo Gênero -->
          <div class="mb-3">
            <label for="genero" class="form-label">Gênero</label>
            <select class="form-select" name="genero" id="genero">
              <option value="">Selecione</option>
              <option value="masculino">Masculino</option>
              <option value="feminino">Feminino</option>
              <option value="outro">Outro</option>
            </select>
          </div>
          <!-- Campo Nacionalidade -->
          <div class="mb-3">
            <label for="nacionalidade" class="form-label">Nacionalidade</label>
            <input type="text" class="form-control" name="nacionalidade" id="nacionalidade" placeholder="Digite a nacionalidade">
          </div>

          <!-- Campo Data de Nascimento -->
          <div class="mb-3">
            <label for="dataNascimento" class="form-label">Data de Nascimento</label>
            <input type="date" class="form-control" name="dataNascimento" id="dataNascimento">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://unpkg.com/imask"></script>
<script>
  const cpfInput = document.getElementById('cpf');
  IMask(cpfInput, {
    mask: '000.000.000-00'
  });
</script>

<script>
  function confirmDelete(id) {
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success",
        cancelButton: "btn btn-danger"
      },
      buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
      title: "Tem certeza?",
      text: "Você não poderá reverter esta ação!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Sim, excluir!",
      cancelButtonText: "Não, cancelar!",
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        // Redireciona para a página de exclusão com o ID do aluno
        window.location.href = "excluir_aluno.php?id=" + id;
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire({
          title: "Cancelado",
          text: "A exclusão foi cancelada.",
          icon: "error"
        });
      }
    });
  }
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
