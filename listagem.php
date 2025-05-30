<?php
include 'conexao.php';

// Inicializa os filtros
$cpf = '';
$temGemeos = '';
$genero = '';
$pais = '';
$dataNascimento = '';
$sala = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cpf = isset($_POST['cpf']) ? trim($_POST['cpf']) : '';
    $temGemeos = isset($_POST['temGemeo']) ? $_POST['temGemeo'] : '';
    $genero = isset($_POST['genero']) ? $_POST['genero'] : '';
    $pais = isset($_POST['pais']) ? trim($_POST['pais']) : '';
    $dataNascimento = isset($_POST['dataNascimento']) ? $_POST['dataNascimento'] : '';
    $sala = isset($_POST['sala']) ? trim($_POST['sala']) : '';
    // Monta query com base nos filtros
    $query = "SELECT id, nome, cpf, ra, sala FROM alunos WHERE 1=1";
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
    if (!empty($pais)) {
        $query .= " AND pais = ?";
        $params[] = $pais;
        $types .= 's';
    }
    if (!empty($dataNascimento)) {
        $query .= " AND data_nascimento = ?";
        $params[] = $dataNascimento;
        $types .= 's';
    }
    if (!empty($sala)) {
        $query .= " AND sala = ?";
        $params[] = $sala;
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
    $result = $conn->query("SELECT id, nome, cpf, ra, sala FROM alunos ORDER BY id DESC");
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
  <h2 class="text-center text-purple mb-4">Lista de Alunos</h2>

  <!-- Formulário de pesquisa -->
  <form method="POST" class="d-flex mb-4 col-md-6 mx-auto" role="search" onsubmit="return false;">
      <input class="form-control me-2 border border-primary fw-bold" type="text" name="cpf" id="cpf"
             placeholder="Pesquisar por CPF" value="<?= htmlspecialchars($cpf) ?>">
  </form>

  <div class="table-responsive">
    <DIV> 
    <div class="text-end mb-3"> 
      <a href="cadastro.html"><img src="img/user.png"></a>
      <img src="img/filter.png" style="cursor:pointer; width:30px; height:auto;" data-bs-toggle="modal" data-bs-target="#filterModal" alt="Filtros Avançados">
    </div>
    </DIV>
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-dark text-center">
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>CPF</th>
          <th>RA</th>
          <th>Sala</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody id="alunos-tbody">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td class="text-center"><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['nome']) ?></td>
              <td><?= htmlspecialchars($row['cpf']) ?></td>
              <td><?= htmlspecialchars($row['ra']) ?></td>
              <td><?= htmlspecialchars($row['sala']) ?></td>
              <td class="text-center">
                <a href="editar_aluno.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning me-2">Editar</a>
                <a href="javascript:void(0);" class="btn btn-sm btn-danger" 
                   onclick="confirmDelete(<?= $row['id'] ?>)">Excluir</a>
              </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
              <td colspan="6" class="text-center text-muted">Nenhum aluno encontrado.</td>
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
          <!-- Campo pais -->
          <div class="mb-3">
            <label for="pais" class="form-label">País</label>
              <select class="form-select" name="pais" required>
                <option value="Brasil">Brasil</option>
                <option value="Afeganistão">Afeganistão</option>
                <option value="África do Sul">África do Sul</option>
                <option value="Albânia">Albânia</option>
                <option value="Alemanha">Alemanha</option>
                <option value="Andorra">Andorra</option>
                <option value="Angola">Angola</option>
                <option value="Antígua e Barbuda">Antígua e Barbuda</option>
                <option value="Arábia Saudita">Arábia Saudita</option>
                <option value="Argélia">Argélia</option>
                <option value="Argentina">Argentina</option>
                <option value="Armênia">Armênia</option>
                <option value="Austrália">Austrália</option>
                <option value="Áustria">Áustria</option>
                <option value="Azerbaijão">Azerbaijão</option>
                <option value="Bahamas">Bahamas</option>
                <option value="Bahrein">Bahrein</option>
                <option value="Bangladesh">Bangladesh</option>
                <option value="Barbados">Barbados</option>
                <option value="Bielorrússia">Bielorrússia</option>
                <option value="Bélgica">Bélgica</option>
                <option value="Belize">Belize</option>
                <option value="Benin">Benin</option>
                <option value="Bermudas">Bermudas</option>
                <option value="Bielorrússia">Bielorrússia</option>
                <option value="Bolívia">Bolívia</option>
                <option value="Bósnia e Herzegovina">Bósnia e Herzegovina</option>
                <option value="Botsuana">Botsuana</option>
                <option value="Brunei">Brunei</option>
                <option value="Bulgária">Bulgária</option>
                <option value="Burkina Faso">Burkina Faso</option>
                <option value="Burundi">Burundi</option>
                <option value="Cabo Verde">Cabo Verde</option>
                <option value="Camarões">Camarões</option>
                <option value="Camboja">Camboja</option>
                <option value="Canadá">Canadá</option>
                <option value="Catar">Catar</option>
                <option value="Cazaquistão">Cazaquistão</option>
                <option value="Chade">Chade</option>
                <option value="Chile">Chile</option>
                <option value="China">China</option>
                <option value="Chipre">Chipre</option>
                <option value="Colômbia">Colômbia</option>
                <option value="Comores">Comores</option>
                <option value="Congo">Congo</option>
                <option value="Coreia do Norte">Coreia do Norte</option>
                <option value="Coreia do Sul">Coreia do Sul</option>
                <option value="Costa do Marfim">Costa do Marfim</option>
                <option value="Costa Rica">Costa Rica</option>
                <option value="Croácia">Croácia</option>
                <option value="Cuba">Cuba</option>
                <option value="Dinamarca">Dinamarca</option>
                <option value="Djibuti">Djibuti</option>
                <option value="Dominica">Dominica</option>
                <option value="Egito">Egito</option>
                <option value="El Salvador">El Salvador</option>
                <option value="Emirados Árabes Unidos">Emirados Árabes Unidos</option>
                <option value="Equador">Equador</option>
                <option value="Espanha">Espanha</option>
                <option value="Estados Unidos">Estados Unidos</option>
                <option value="Estônia">Estônia</option>
                <option value="Eswatini">Eswatini</option>
                <option value="Etiópia">Etiópia</option>
                <option value="Fiji">Fiji</option>
                <option value="Filipinas">Filipinas</option>
                <option value="Finlândia">Finlândia</option>
                <option value="França">França</option>
                <option value="Gabão">Gabão</option>
                <option value="Gana">Gana</option>
                <option value="Geórgia">Geórgia</option>
                <option value="Gibraltar">Gibraltar</option>
                <option value="Granada">Granada</option>
                <option value="Grécia">Grécia</option>
                <option value="Groenlândia">Groenlândia</option>
                <option value="Guadalupe">Guadalupe</option>
                <option value="Guatemala">Guatemala</option>
                <option value="Guiana">Guiana</option>
                <option value="Guiné">Guiné</option>
                <option value="Guiné Equatorial">Guiné Equatorial</option>
                <option value="Guiné-Bissau">Guiné-Bissau</option>
                <option value="Haiti">Haiti</option>
                <option value="Holanda">Holanda</option>
                <option value="Honduras">Honduras</option>
                <option value="Hong Kong">Hong Kong</option>
                <option value="Hungria">Hungria</option>
                <option value="Iémen">Iémen</option>
                <option value="Ilhas Cayman">Ilhas Cayman</option>
                <option value="Ilhas Cook">Ilhas Cook</option>
                <option value="Ilhas Malvinas">Ilhas Malvinas</option>
                <option value="Ilhas Marshall">Ilhas Marshall</option>
                <option value="Ilhas Salomão">Ilhas Salomão</option>
                <option value="Ilhas Virgens Americanas">Ilhas Virgens Americanas</option>
                <option value="Ilhas Virgens Britânicas">Ilhas Virgens Britânicas</option>
                <option value="Índia">Índia</option>
                <option value="Indonésia">Indonésia</option>
                <option value="Irã">Irã</option>
                <option value="Iraque">Iraque</option>
                <option value="Irlanda">Irlanda</option>
                <option value="Islândia">Islândia</option>
                <option value="Itália">Itália</option>
                <option value="Jamaica">Jamaica</option>
                <option value="Japão">Japão</option>
                <option value="Jordânia">Jordânia</option>
                <option value="Kiribati">Kiribati</option>
                <option value="Kuwait">Kuwait</option>
                <option value="Laos">Laos</option>
                <option value="Lesoto">Lesoto</option>
                <option value="Letônia">Letônia</option>
                <option value="Líbano">Líbano</option>
                <option value="Libéria">Libéria</option>
                <option value="Líbia">Líbia</option>
                <option value="Liechtenstein">Liechtenstein</option>
                <option value="Lituânia">Lituânia</option>
                <option value="Luxemburgo">Luxemburgo</option>
                <option value="Macau">Macau</option>
                <option value="Madagascar">Madagascar</option>
                <option value="Malásia">Malásia</option>
                <option value="Malawi">Malawi</option>
                <option value="Maldivas">Maldivas</option>
                <option value="Mali">Mali</option>
                <option value="Malta">Malta</option>
                <option value="Marrocos">Marrocos</option>
                <option value="Maurício">Maurício</option>
                <option value="Mauritânia">Mauritânia</option>
                <option value="México">México</option>
                <option value="Micronésia">Micronésia</option>
                <option value="Moçambique">Moçambique</option>
                <option value="Moldávia">Moldávia</option>
                <option value="Mongólia">Mongólia</option>
                <option value="Montenegro">Montenegro</option>
                <option value="Namíbia">Namíbia</option>
                <option value="Nepal">Nepal</option>
                <option value="Nicarágua">Nicarágua</option>
                <option value="Nigéria">Nigéria</option>
                <option value="Noruega">Noruega</option>
                <option value="Nova Caledônia">Nova Caledônia</option>
                <option value="Nova Zelândia">Nova Zelândia</option>
                <option value="Omã">Omã</option>
                <option value="Países Baixos">Países Baixos</option>
                <option value="Panamá">Panamá</option>
                <option value="Papua Nova Guiné">Papua Nova Guiné</option>
                <option value="Paquistão">Paquistão</option>
                <option value="Paraguai">Paraguai</option>
                <option value="Peru">Peru</option>
                <option value="Polônia">Polônia</option>
                <option value="Portugal">Portugal</option>
                <option value="Quênia">Quênia</option>
                <option value="Quirguistão">Quirguistão</option>
                <option value="Reino Unido">Reino Unido</option>
                <option value="República Centro-Africana">República Centro-Africana</option>
                <option value="República Checa">República Checa</option>
                <option value="República Democrática do Congo">República Democrática do Congo</option>
                <option value="República Dominicana">República Dominicana</option>
                <option value="Romênia">Romênia</option>
                <option value="Ruanda">Ruanda</option>
                <option value="Rússia">Rússia</option>
                <option value="Saara Ocidental">Saara Ocidental</option>
                <option value="Saint Kitts e Nevis">Saint Kitts e Nevis</option>
                <option value="Saint Pierre e Miquelon">Saint Pierre e Miquelon</option>
                <option value="Saint Vincent e Granadinas">Saint Vincent e Granadinas</option>
                <option value="Samoa">Samoa</option>
                <option value="San Marino">San Marino</option>
                <option value="Santa Lúcia">Santa Lúcia</option>
                <option value="Senegal">Senegal</option>
                <option value="Serra Leoa">Serra Leoa</option>
                <option value="Sérvia">Sérvia</option>
                <option value="Singapura">Singapura</option>
                <option value="Síria">Síria</option>
                <option value="Somália">Somália</option>
                <option value="Sri Lanka">Sri Lanka</option>
                <option value="Suazilândia">Suazilândia</option>
                <option value="Sudão">Sudão</option>
                <option value="Sudão do Sul">Sudão do Sul</option>
                <option value="Suécia">Suécia</option>
                <option value="Suíça">Suíça</option>
                <option value="Suriname">Suriname</option>
                <option value="Tailândia">Tailândia</option>
                <option value="Taiwan">Taiwan</option>
                <option value="Tajiquistão">Tajiquistão</option>
                <option value="Tanzânia">Tanzânia</option>
                <option value="Timor-Leste">Timor-Leste</option>
                <option value="Togo">Togo</option>
                <option value="Tonga">Tonga</option>
                <option value="Trinidad e Tobago">Trinidad e Tobago</option>
                <option value="Tunísia">Tunísia</option>
                <option value="Turcomenistão">Turcomenistão</option>
                <option value="Turquia">Turquia</option>
                <option value="Tuvalu">Tuvalu</option>
                <option value="Ucrânia">Ucrânia</option>
                <option value="Uganda">Uganda</option>
                <option value="Uruguai">Uruguai</option>
                <option value="Uzbequistão">Uzbequistão</option>
                <option value="Vanuatu">Vanuatu</option>
                <option value="Vaticano">Vaticano</option>
                <option value="Venezuela">Venezuela</option>
                <option value="Viêt Nam">Viêt Nam</option>
                <option value="Zâmbia">Zâmbia</option>
                <option value="Zimbábue">Zimbábue</option>
              </select>
          </div>

          <!-- Campo Data de Nascimento -->
          <div class="mb-3">
            <label for="dataNascimento" class="form-label">Data de Nascimento</label>
            <input type="date" class="form-control" name="dataNascimento" id="dataNascimento">
          </div>
          <!-- Campo Sala -->
          <div class="mb-3">
            <label for="sala" class="form-label">Sala</label>
            <select class="form-select" name="sala" id="sala">
              <option value="">Selecione</option>
              <option value="1º Ano Fundamental">1º Ano Fundamental</option>
              <option value="2º Ano Fundamental">2º Ano Fundamental</option>
              <option value="3º Ano Fundamental">3º Ano Fundamental</option>
              <option value="4º Ano Fundamental">4º Ano Fundamental</option>
              <option value="5º Ano Fundamental">5º Ano Fundamental</option>
              <option value="6º Ano Fundamental">6º Ano Fundamental</option>
              <option value="7º Ano Fundamental">7º Ano Fundamental</option>
              <option value="8º Ano Fundamental">8º Ano Fundamental</option>
              <option value="9º Ano Fundamental">9º Ano Fundamental</option>
              <option value="1º Ano Médio">1º Ano Médio</option>
              <option value="2º Ano Médio">2º Ano Médio</option>
              <option value="3º Ano Médio">3º Ano Médio</option>
            </select>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-cinza" data-bs-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-purple">Aplicar Filtros</button>
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

  // AJAX para pesquisa ao vivo
  cpfInput.addEventListener('input', function() {
    const cpfValue = cpfInput.value;
    fetch('ajax_listagem.php?cpf=' + encodeURIComponent(cpfValue))
      .then(response => response.json())
      .then(data => {
        const tbody = document.getElementById('alunos-tbody');
        tbody.innerHTML = '';
        if (data.length === 0) {
          tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">Nenhum aluno encontrado.</td></tr>';
        } else {
          data.forEach(function(row) {
            tbody.innerHTML += `<tr>
              <td class="text-center">${row.id}</td>
              <td>${row.nome}</td>
              <td>${row.cpf}</td>
              <td>${row.ra}</td>
              <td>${row.sala}</td>
              <td class="text-center">
                <a href="editar_aluno.php?id=${row.id}" class="btn btn-sm btn-warning me-2">Editar</a>
                <a href="javascript:void(0);" class="btn btn-sm btn-danger" onclick="confirmDelete(${row.id})">Excluir</a>
              </td>
            </tr>`;
          });
        }
      });
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
