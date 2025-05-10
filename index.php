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
    $query = "SELECT COUNT(*) AS total_alunos, 
                     SUM(CASE WHEN genero = 'Masculino' THEN 1 ELSE 0 END) AS total_masculino,
                     SUM(CASE WHEN genero = 'Feminino' THEN 1 ELSE 0 END) AS total_feminino
              FROM alunos WHERE 1=1";
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
    $stats = $result->fetch_assoc();
} else {
    $result = $conn->query("SELECT COUNT(*) AS total_alunos, 
                                   SUM(CASE WHEN genero = 'Masculino' THEN 1 ELSE 0 END) AS total_masculino,
                                   SUM(CASE WHEN genero = 'Feminino' THEN 1 ELSE 0 END) AS total_feminino
                            FROM alunos");
    $stats = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
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
  <h2 class="text-center text-purple mb-4">Relatório de alunos</h2>

  <!-- Estatísticas -->
  <div class="row text-center mb-4">
    <div class="col-md-4">
      <div class="card bg-light">
        <div class="card-body">
          <h5 class="card-title">Total de Alunos</h5>
          <p class="card-text fs-3"><?= $stats['total_alunos'] ?? 0 ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bg-light">
        <div class="card-body">
          <h5 class="card-title">Total Masculino</h5>
          <p class="card-text fs-3"><?= $stats['total_masculino'] ?? 0 ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bg-light">
        <div class="card-body">
          <h5 class="card-title">Total Feminino</h5>
          <p class="card-text fs-3"><?= $stats['total_feminino'] ?? 0 ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Formulário de filtros -->
  <form method="POST" class="row g-3">
    <div class="col-md-3">
      <label for="cpf" class="form-label">CPF</label>
      <input type="text" class="form-control" id="cpf" name="cpf" value="<?= htmlspecialchars($cpf) ?>">
    </div>
    <div class="col-md-3">
      <label for="temGemeo" class="form-label">Tem Gêmeos</label>
      <select class="form-select" id="temGemeo" name="temGemeo">
        <option value="">Selecione</option>
        <option value="sim" <?= $temGemeos === 'sim' ? 'selected' : '' ?>>Sim</option>
        <option value="nao" <?= $temGemeos === 'nao' ? 'selected' : '' ?>>Não</option>
      </select>
    </div>
    <div class="col-md-3">
      <label for="genero" class="form-label">Gênero</label>
      <select class="form-select" id="genero" name="genero">
        <option value="">Selecione</option>
        <option value="Masculino" <?= $genero === 'Masculino' ? 'selected' : '' ?>>Masculino</option>
        <option value="Feminino" <?= $genero === 'Feminino' ? 'selected' : '' ?>>Feminino</option>
      </select>
    </div>
    <div class="col-md-3">
      <label for="nacionalidade" class="form-label">Nacionalidade</label>
      <input type="text" class="form-control" id="nacionalidade" name="nacionalidade" value="<?= htmlspecialchars($nacionalidade) ?>">
    </div>
    <div class="col-md-3">
      <label for="dataNascimento" class="form-label">Data de Nascimento</label>
      <input type="date" class="form-control" id="dataNascimento" name="dataNascimento" value="<?= htmlspecialchars($dataNascimento) ?>">
    </div>
    <div class="col-md-12 text-end">
      <button type="submit" class="btn btn-primary">Filtrar</button>
    </div>
  </form>

  <!-- Gráfico -->
  <div class="mt-5">
    <canvas id="alunosChart"></canvas>
  </div>
</div>

<script>
  const ctx = document.getElementById('alunosChart').getContext('2d');
  const alunosChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Total de Alunos', 'Masculino', 'Feminino'],
      datasets: [{
        label: 'Quantidade',
        data: [<?= $stats['total_alunos'] ?? 0 ?>, <?= $stats['total_masculino'] ?? 0 ?>, <?= $stats['total_feminino'] ?? 0 ?>],
        backgroundColor: ['#4e73df', '#1cc88a', '#e74a3b'],
        borderColor: ['#4e73df', '#1cc88a', '#e74a3b'],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>