<?php
include 'conexao.php';

// Inicializa os filtros
$temGemeos = '';
$genero = '';
$pais = '';
$sala = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $temGemeos = isset($_POST['temGemeo']) ? $_POST['temGemeo'] : '';
    $genero = isset($_POST['genero']) ? $_POST['genero'] : '';
    $pais = isset($_POST['pais']) ? $_POST['pais'] : '';
    $sala = isset($_POST['sala']) ? trim($_POST['sala']) : '';

    // Monta a query com base nos filtros
    $query = "SELECT COUNT(*) AS total_alunos, 
                     SUM(CASE WHEN genero = 'Masculino' THEN 1 ELSE 0 END) AS total_masculino,
                     SUM(CASE WHEN genero = 'Feminino' THEN 1 ELSE 0 END) AS total_feminino,
                     SUM(CASE WHEN genero = 'Outro' THEN 1 ELSE 0 END) AS total_outro
              FROM alunos WHERE 1=1";
    $params = [];
    $types = '';

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
    if (!empty($sala)) {
        $query .= " AND sala = ?";
        $params[] = $sala;
        $types .= 's';
    }
    if (!empty($pais)) {
        $query .= " AND pais = ?";
        $params[] = $pais;
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
                                   SUM(CASE WHEN genero = 'Feminino' THEN 1 ELSE 0 END) AS total_feminino,
                                   SUM(CASE WHEN genero = 'Outro' THEN 1 ELSE 0 END) AS total_outro
                            FROM alunos");
    $stats = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Relatório de alunos</title>
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
    <div class="col-md-3">
      <div class="card card-aluno">
        <div class="card-body">
          <h5 class="card-title">Total de alunos</h5>
          <p class="card-text fs-3"><?= $stats['total_alunos'] ?? 0 ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card card-masculino">
        <div class="card-body">
          <h5 class="card-title">Masculino</h5>
          <p class="card-text fs-3"><?= $stats['total_masculino'] ?? 0 ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card card-feminino">
        <div class="card-body">
          <h5 class="card-title">Feminino</h5>
          <p class="card-text fs-3"><?= $stats['total_feminino'] ?? 0 ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card card-outro">
        <div class="card-body">
          <h5 class="card-title">Outro</h5>
          <p class="card-text fs-3"><?= $stats['total_outro'] ?? 0 ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Formulário de filtros -->
  <form method="POST" class="row g-3">
    <div class="col-md-3">
      <label for="genero" class="form-label">Gênero</label>
      <select class="form-select select-purple" id="genero" name="genero">
        <option value="">Selecione</option>
        <option value="Masculino" <?= $genero === 'Masculino' ? 'selected' : '' ?>>Masculino</option>
        <option value="Feminino" <?= $genero === 'Feminino' ? 'selected' : '' ?>>Feminino</option>
        <option value="Outro" <?= $genero === 'Outro' ? 'selected' : '' ?>>Outro</option>
      </select>
    </div>
    <div class="col-md-3">
      <label for="sala" class="form-label">Sala</label>
      <select class="form-select select-purple" id="sala" name="sala">
          <option value="">Selecione</option>
          <option value="1º Ano Fundamental" <?= $sala === '1º Ano Fundamental' ? 'selected' : '' ?>>1º Ano Fundamental</option>
          <option value="2º Ano Fundamental" <?= $sala === '2º Ano Fundamental' ? 'selected' : '' ?>>2º Ano Fundamental</option>
          <option value="3º Ano Fundamental" <?= $sala === '3º Ano Fundamental' ? 'selected' : '' ?>>3º Ano Fundamental</option>
          <option value="4º Ano Fundamental" <?= $sala === '4º Ano Fundamental' ? 'selected' : '' ?>>4º Ano Fundamental</option>
          <option value="5º Ano Fundamental" <?= $sala === '5º Ano Fundamental' ? 'selected' : '' ?>>5º Ano Fundamental</option>
          <option value="6º Ano Fundamental" <?= $sala === '6º Ano Fundamental' ? 'selected' : '' ?>>6º Ano Fundamental</option>
          <option value="7º Ano Fundamental" <?= $sala === '7º Ano Fundamental' ? 'selected' : '' ?>>7º Ano Fundamental</option>
          <option value="8º Ano Fundamental" <?= $sala === '8º Ano Fundamental' ? 'selected' : '' ?>>8º Ano Fundamental</option>
          <option value="9º Ano Fundamental" <?= $sala === '9º Ano Fundamental' ? 'selected' : '' ?>>9º Ano Fundamental</option>
          <option value="1º Ano Médio" <?= $sala === '1º Ano Médio' ? 'selected' : '' ?>>1º Ano Médio</option>
          <option value="2º Ano Médio" <?= $sala === '2º Ano Médio' ? 'selected' : '' ?>>2º Ano Médio</option>
          <option value="3º Ano Médio" <?= $sala === '3º Ano Médio' ? 'selected' : '' ?>>3º Ano Médio</option>
        </select>
    </div>
    <div class="col-md-3">
      <label for="temGemeo" class="form-label">Tem gêmeos</label>
      <select class="form-select select-purple" id="temGemeo" name="temGemeo">
        <option value="">Selecione</option>
        <option value="sim" <?= $temGemeos === 'sim' ? 'selected' : '' ?>>Sim</option>
        <option value="nao" <?= $temGemeos === 'nao' ? 'selected' : '' ?>>Não</option>
      </select>
    </div>
    <div class="col-md-3">
      <label for="pais" class="form-label">País</label>
      <select class="form-select select-purple" id="pais" name="pais">
        <option value="">Selecione</option>
        <option value="Afeganistão" <?= $pais === 'Afeganistão' ? 'selected' : '' ?>>Afeganistão</option>
        <option value="África do Sul" <?= $pais === 'África do Sul' ? 'selected' : '' ?>>África do Sul</option>
        <option value="Albânia" <?= $pais === 'Albânia' ? 'selected' : '' ?>>Albânia</option>
        <option value="Alemanha" <?= $pais === 'Alemanha' ? 'selected' : '' ?>>Alemanha</option>
        <option value="Andorra" <?= $pais === 'Andorra' ? 'selected' : '' ?>>Andorra</option>
        <option value="Angola" <?= $pais === 'Angola' ? 'selected' : '' ?>>Angola</option>
        <option value="Antígua e Barbuda" <?= $pais === 'Antígua e Barbuda' ? 'selected' : '' ?>>Antígua e Barbuda</option>
        <option value="Arábia Saudita" <?= $pais === 'Arábia Saudita' ? 'selected' : '' ?>>Arábia Saudita</option>
        <option value="Argélia" <?= $pais === 'Argélia' ? 'selected' : '' ?>>Argélia</option>
        <option value="Argentina" <?= $pais === 'Argentina' ? 'selected' : '' ?>>Argentina</option>
        <option value="Armênia" <?= $pais === 'Armênia' ? 'selected' : '' ?>>Armênia</option>
        <option value="Austrália" <?= $pais === 'Austrália' ? 'selected' : '' ?>>Austrália</option>
        <option value="Áustria" <?= $pais === 'Áustria' ? 'selected' : '' ?>>Áustria</option>
        <option value="Azerbaijão" <?= $pais === 'Azerbaijão' ? 'selected' : '' ?>>Azerbaijão</option>
        <option value="Bahamas" <?= $pais === 'Bahamas' ? 'selected' : '' ?>>Bahamas</option>
        <option value="Bahrein" <?= $pais === 'Bahrein' ? 'selected' : '' ?>>Bahrein</option>
        <option value="Bangladesh" <?= $pais === 'Bangladesh' ? 'selected' : '' ?>>Bangladesh</option>
        <option value="Barbados" <?= $pais === 'Barbados' ? 'selected' : '' ?>>Barbados</option>
        <option value="Bielorrússia" <?= $pais === 'Bielorrússia' ? 'selected' : '' ?>>Bielorrússia</option>
        <option value="Bélgica" <?= $pais === 'Bélgica' ? 'selected' : '' ?>>Bélgica</option>
        <option value="Belize" <?= $pais === 'Belize' ? 'selected' : '' ?>>Belize</option>
        <option value="Benin" <?= $pais === 'Benin' ? 'selected' : '' ?>>Benin</option>
        <option value="Bermudas" <?= $pais === 'Bermudas' ? 'selected' : '' ?>>Bermudas</option>
        <option value="Bielorrússia" <?= $pais === 'Bielorrússia' ? 'selected' : '' ?>>Bielorrússia</option>
        <option value="Bolívia" <?= $pais === 'Bolívia' ? 'selected' : '' ?>>Bolívia</option>
        <option value="Bósnia e Herzegovina" <?= $pais === 'Bósnia e Herzegovina' ? 'selected' : '' ?>>Bósnia e Herzegovina</option>
        <option value="Botsuana" <?= $pais === 'Botsuana' ? 'selected' : '' ?>>Botsuana</option>
        <option value="Brasil" <?= $pais === 'Brasil' ? 'selected' : '' ?>>Brasil</option>
        <option value="Brunei" <?= $pais === 'Brunei' ? 'selected' : '' ?>>Brunei</option>
        <option value="Bulgária" <?= $pais === 'Bulgária' ? 'selected' : '' ?>>Bulgária</option>
        <option value="Burkina Faso" <?= $pais === 'Burkina Faso' ? 'selected' : '' ?>>Burkina Faso</option>
        <option value="Burundi" <?= $pais === 'Burundi' ? 'selected' : '' ?>>Burundi</option>
        <option value="Cabo Verde" <?= $pais === 'Cabo Verde' ? 'selected' : '' ?>>Cabo Verde</option>
        <option value="Camarões" <?= $pais === 'Camarões' ? 'selected' : '' ?>>Camarões</option>
        <option value="Camboja" <?= $pais === 'Camboja' ? 'selected' : '' ?>>Camboja</option>
        <option value="Canadá" <?= $pais === 'Canadá' ? 'selected' : '' ?>>Canadá</option>
        <option value="Catar" <?= $pais === 'Catar' ? 'selected' : '' ?>>Catar</option>
        <option value="Cazaquistão" <?= $pais === 'Cazaquistão' ? 'selected' : '' ?>>Cazaquistão</option>
        <option value="Chade" <?= $pais === 'Chade' ? 'selected' : '' ?>>Chade</option>
        <option value="Chile" <?= $pais === 'Chile' ? 'selected' : '' ?>>Chile</option>
        <option value="China" <?= $pais === 'China' ? 'selected' : '' ?>>China</option>
        <option value="Chipre" <?= $pais === 'Chipre' ? 'selected' : '' ?>>Chipre</option>
        <option value="Colômbia" <?= $pais === 'Colômbia' ? 'selected' : '' ?>>Colômbia</option>
        <option value="Comores" <?= $pais === 'Comores' ? 'selected' : '' ?>>Comores</option>
        <option value="Congo" <?= $pais === 'Congo' ? 'selected' : '' ?>>Congo</option>
        <option value="Coreia do Norte" <?= $pais === 'Coreia do Norte' ? 'selected' : '' ?>>Coreia do Norte</option>
        <option value="Coreia do Sul" <?= $pais === 'Coreia do Sul' ? 'selected' : '' ?>>Coreia do Sul</option>
        <option value="Costa do Marfim" <?= $pais === 'Costa do Marfim' ? 'selected' : '' ?>>Costa do Marfim</option>
        <option value="Costa Rica" <?= $pais === 'Costa Rica' ? 'selected' : '' ?>>Costa Rica</option>
        <option value="Croácia" <?= $pais === 'Croácia' ? 'selected' : '' ?>>Croácia</option>
        <option value="Cuba" <?= $pais === 'Cuba' ? 'selected' : '' ?>>Cuba</option>
        <option value="Dinamarca" <?= $pais === 'Dinamarca' ? 'selected' : '' ?>>Dinamarca</option>
        <option value="Djibuti" <?= $pais === 'Djibuti' ? 'selected' : '' ?>>Djibuti</option>
        <option value="Dominica" <?= $pais === 'Dominica' ? 'selected' : '' ?>>Dominica</option>
        <option value="Egito" <?= $pais === 'Egito' ? 'selected' : '' ?>>Egito</option>
        <option value="El Salvador" <?= $pais === 'El Salvador' ? 'selected' : '' ?>>El Salvador</option>
        <option value="Emirados Árabes Unidos" <?= $pais === 'Emirados Árabes Unidos' ? 'selected' : '' ?>>Emirados Árabes Unidos</option>
        <option value="Equador" <?= $pais === 'Equador' ? 'selected' : '' ?>>Equador</option>
        <option value="Espanha" <?= $pais === 'Espanha' ? 'selected' : '' ?>>Espanha</option>
        <option value="Estados Unidos" <?= $pais === 'Estados Unidos' ? 'selected' : '' ?>>Estados Unidos</option>
        <option value="Estônia" <?= $pais === 'Estônia' ? 'selected' : '' ?>>Estônia</option>
        <option value="Eswatini" <?= $pais === 'Eswatini' ? 'selected' : '' ?>>Eswatini</option>
        <option value="Etiópia" <?= $pais === 'Etiópia' ? 'selected' : '' ?>>Etiópia</option>
        <option value="Fiji" <?= $pais === 'Fiji' ? 'selected' : '' ?>>Fiji</option>
        <option value="Filipinas" <?= $pais === 'Filipinas' ? 'selected' : '' ?>>Filipinas</option>
        <option value="Finlândia" <?= $pais === 'Finlândia' ? 'selected' : '' ?>>Finlândia</option>
        <option value="França" <?= $pais === 'França' ? 'selected' : '' ?>>França</option>
        <option value="Gabão" <?= $pais === 'Gabão' ? 'selected' : '' ?>>Gabão</option>
        <option value="Gana" <?= $pais === 'Gana' ? 'selected' : '' ?>>Gana</option>
        <option value="Geórgia" <?= $pais === 'Geórgia' ? 'selected' : '' ?>>Geórgia</option>
        <option value="Gibraltar" <?= $pais === 'Gibraltar' ? 'selected' : '' ?>>Gibraltar</option>
        <option value="Granada" <?= $pais === 'Granada' ? 'selected' : '' ?>>Granada</option>
        <option value="Grécia" <?= $pais === 'Grécia' ? 'selected' : '' ?>>Grécia</option>
        <option value="Groenlândia" <?= $pais === 'Groenlândia' ? 'selected' : '' ?>>Groenlândia</option>
        <option value="Guadalupe" <?= $pais === 'Guadalupe' ? 'selected' : '' ?>>Guadalupe</option>
        <option value="Guatemala" <?= $pais === 'Guatemala' ? 'selected' : '' ?>>Guatemala</option>
        <option value="Guiana" <?= $pais === 'Guiana' ? 'selected' : '' ?>>Guiana</option>
        <option value="Guiné" <?= $pais === 'Guiné' ? 'selected' : '' ?>>Guiné</option>
        <option value="Guiné Equatorial" <?= $pais === 'Guiné Equatorial' ? 'selected' : '' ?>>Guiné Equatorial</option>
        <option value="Guiné-Bissau" <?= $pais === 'Guiné-Bissau' ? 'selected' : '' ?>>Guiné-Bissau</option>
        <option value="Haiti" <?= $pais === 'Haiti' ? 'selected' : '' ?>>Haiti</option>
        <option value="Holanda" <?= $pais === 'Holanda' ? 'selected' : '' ?>>Holanda</option>
        <option value="Honduras" <?= $pais === 'Honduras' ? 'selected' : '' ?>>Honduras</option>
        <option value="Hong Kong" <?= $pais === 'Hong Kong' ? 'selected' : '' ?>>Hong Kong</option>
        <option value="Hungria" <?= $pais === 'Hungria' ? 'selected' : '' ?>>Hungria</option>
        <option value="Iémen" <?= $pais === 'Iémen' ? 'selected' : '' ?>>Iémen</option>
        <option value="Ilhas Cayman" <?= $pais === 'Ilhas Cayman' ? 'selected' : '' ?>>Ilhas Cayman</option>
        <option value="Ilhas Cook" <?= $pais === 'Ilhas Cook' ? 'selected' : '' ?>>Ilhas Cook</option>
        <option value="Ilhas Malvinas" <?= $pais === 'Ilhas Malvinas' ? 'selected' : '' ?>>Ilhas Malvinas</option>
        <option value="Ilhas Marshall" <?= $pais === 'Ilhas Marshall' ? 'selected' : '' ?>>Ilhas Marshall</option>
        <option value="Ilhas Salomão" <?= $pais === 'Ilhas Salomão' ? 'selected' : '' ?>>Ilhas Salomão</option>
        <option value="Ilhas Virgens Americanas" <?= $pais === 'Ilhas Virgens Americanas' ? 'selected' : '' ?>>Ilhas Virgens Americanas</option>
        <option value="Ilhas Virgens Britânicas" <?= $pais === 'Ilhas Virgens Britânicas' ? 'selected' : '' ?>>Ilhas Virgens Britânicas</option>
        <option value="Índia" <?= $pais === 'Índia' ? 'selected' : '' ?>>Índia</option>
        <option value="Indonésia" <?= $pais === 'Indonésia' ? 'selected' : '' ?>>Indonésia</option>
        <option value="Irã" <?= $pais === 'Irã' ? 'selected' : '' ?>>Irã</option>
        <option value="Iraque" <?= $pais === 'Iraque' ? 'selected' : '' ?>>Iraque</option>
        <option value="Irlanda" <?= $pais === 'Irlanda' ? 'selected' : '' ?>>Irlanda</option>
        <option value="Islândia" <?= $pais === 'Islândia' ? 'selected' : '' ?>>Islândia</option>
        <option value="Itália" <?= $pais === 'Itália' ? 'selected' : '' ?>>Itália</option>
        <option value="Jamaica" <?= $pais === 'Jamaica' ? 'selected' : '' ?>>Jamaica</option>
        <option value="Japão" <?= $pais === 'Japão' ? 'selected' : '' ?>>Japão</option>
        <option value="Jordânia" <?= $pais === 'Jordânia' ? 'selected' : '' ?>>Jordânia</option>
        <option value="Kiribati" <?= $pais === 'Kiribati' ? 'selected' : '' ?>>Kiribati</option>
        <option value="Kuwait" <?= $pais === 'Kuwait' ? 'selected' : '' ?>>Kuwait</option>
        <option value="Laos" <?= $pais === 'Laos' ? 'selected' : '' ?>>Laos</option>
        <option value="Lesoto" <?= $pais === 'Lesoto' ? 'selected' : '' ?>>Lesoto</option>
        <option value="Letônia" <?= $pais === 'Letônia' ? 'selected' : '' ?>>Letônia</option>
        <option value="Líbano" <?= $pais === 'Líbano' ? 'selected' : '' ?>>Líbano</option>
        <option value="Libéria" <?= $pais === 'Libéria' ? 'selected' : '' ?>>Libéria</option>
        <option value="Líbia" <?= $pais === 'Líbia' ? 'selected' : '' ?>>Líbia</option>
        <option value="Liechtenstein" <?= $pais === 'Liechtenstein' ? 'selected' : '' ?>>Liechtenstein</option>
        <option value="Lituânia" <?= $pais === 'Lituânia' ? 'selected' : '' ?>>Lituânia</option>
        <option value="Luxemburgo" <?= $pais === 'Luxemburgo' ? 'selected' : '' ?>>Luxemburgo</option>
        <option value="Macau" <?= $pais === 'Macau' ? 'selected' : '' ?>>Macau</option>
        <option value="Madagascar" <?= $pais === 'Madagascar' ? 'selected' : '' ?>>Madagascar</option>
        <option value="Malásia" <?= $pais === 'Malásia' ? 'selected' : '' ?>>Malásia</option>
        <option value="Malawi" <?= $pais === 'Malawi' ? 'selected' : '' ?>>Malawi</option>
        <option value="Maldivas" <?= $pais === 'Maldivas' ? 'selected' : '' ?>>Maldivas</option>
        <option value="Mali" <?= $pais === 'Mali' ? 'selected' : '' ?>>Mali</option>
        <option value="Malta" <?= $pais === 'Malta' ? 'selected' : '' ?>>Malta</option>
        <option value="Marrocos" <?= $pais === 'Marrocos' ? 'selected' : '' ?>>Marrocos</option>
        <option value="Maurício" <?= $pais === 'Maurício' ? 'selected' : '' ?>>Maurício</option>
        <option value="Mauritânia" <?= $pais === 'Mauritânia' ? 'selected' : '' ?>>Mauritânia</option>
        <option value="México" <?= $pais === 'México' ? 'selected' : '' ?>>México</option>
        <option value="Micronésia" <?= $pais === 'Micronésia' ? 'selected' : '' ?>>Micronésia</option>
        <option value="Moçambique" <?= $pais === 'Moçambique' ? 'selected' : '' ?>>Moçambique</option>
        <option value="Moldávia" <?= $pais === 'Moldávia' ? 'selected' : '' ?>>Moldávia</option>
        <option value="Mongólia" <?= $pais === 'Mongólia' ? 'selected' : '' ?>>Mongólia</option>
        <option value="Montenegro" <?= $pais === 'Montenegro' ? 'selected' : '' ?>>Montenegro</option>
        <option value="Namíbia" <?= $pais === 'Namíbia' ? 'selected' : '' ?>>Namíbia</option>
        <option value="Nepal" <?= $pais === 'Nepal' ? 'selected' : '' ?>>Nepal</option>
        <option value="Nicarágua" <?= $pais === 'Nicarágua' ? 'selected' : '' ?>>Nicarágua</option>
        <option value="Nigéria" <?= $pais === 'Nigéria' ? 'selected' : '' ?>>Nigéria</option>
        <option value="Noruega" <?= $pais === 'Noruega' ? 'selected' : '' ?>>Noruega</option>
        <option value="Nova Caledônia" <?= $pais === 'Nova Caledônia' ? 'selected' : '' ?>>Nova Caledônia</option>
        <option value="Nova Zelândia" <?= $pais === 'Nova Zelândia' ? 'selected' : '' ?>>Nova Zelândia</option>
        <option value="Omã" <?= $pais === 'Omã' ? 'selected' : '' ?>>Omã</option>
        <option value="Países Baixos" <?= $pais === 'Países Baixos' ? 'selected' : '' ?>>Países Baixos</option>
        <option value="Panamá" <?= $pais === 'Panamá' ? 'selected' : '' ?>>Panamá</option>
        <option value="Papua Nova Guiné" <?= $pais === 'Papua Nova Guiné' ? 'selected' : '' ?>>Papua Nova Guiné</option>
        <option value="Paquistão" <?= $pais === 'Paquistão' ? 'selected' : '' ?>>Paquistão</option>
        <option value="Paraguai" <?= $pais === 'Paraguai' ? 'selected' : '' ?>>Paraguai</option>
        <option value="Peru" <?= $pais === 'Peru' ? 'selected' : '' ?>>Peru</option>
        <option value="Polônia" <?= $pais === 'Polônia' ? 'selected' : '' ?>>Polônia</option>
        <option value="Portugal" <?= $pais === 'Portugal' ? 'selected' : '' ?>>Portugal</option>
        <option value="Quênia" <?= $pais === 'Quênia' ? 'selected' : '' ?>>Quênia</option>
        <option value="Quirguistão" <?= $pais === 'Quirguistão' ? 'selected' : '' ?>>Quirguistão</option>
        <option value="Reino Unido" <?= $pais === 'Reino Unido' ? 'selected' : '' ?>>Reino Unido</option>
        <option value="República Centro-Africana" <?= $pais === 'República Centro-Africana' ? 'selected' : '' ?>>República Centro-Africana</option>
        <option value="República Checa" <?= $pais === 'República Checa' ? 'selected' : '' ?>>República Checa</option>
        <option value="República Democrática do Congo" <?= $pais === 'República Democrática do Congo' ? 'selected' : '' ?>>República Democrática do Congo</option>
        <option value="República Dominicana" <?= $pais === 'República Dominicana' ? 'selected' : '' ?>>República Dominicana</option>
        <option value="Romênia" <?= $pais === 'Romênia' ? 'selected' : '' ?>>Romênia</option>
        <option value="Ruanda" <?= $pais === 'Ruanda' ? 'selected' : '' ?>>Ruanda</option>
        <option value="Rússia" <?= $pais === 'Rússia' ? 'selected' : '' ?>>Rússia</option>
        <option value="Saara Ocidental" <?= $pais === 'Saara Ocidental' ? 'selected' : '' ?>>Saara Ocidental</option>
        <option value="Saint Kitts e Nevis" <?= $pais === 'Saint Kitts e Nevis' ? 'selected' : '' ?>>Saint Kitts e Nevis</option>
        <option value="Saint Pierre e Miquelon" <?= $pais === 'Saint Pierre e Miquelon' ? 'selected' : '' ?>>Saint Pierre e Miquelon</option>
        <option value="Saint Vincent e Granadinas" <?= $pais === 'Saint Vincent e Granadinas' ? 'selected' : '' ?>>Saint Vincent e Granadinas</option>
        <option value="Samoa" <?= $pais === 'Samoa' ? 'selected' : '' ?>>Samoa</option>
        <option value="San Marino" <?= $pais === 'San Marino' ? 'selected' : '' ?>>San Marino</option>
        <option value="Santa Lúcia" <?= $pais === 'Santa Lúcia' ? 'selected' : '' ?>>Santa Lúcia</option>
        <option value="Senegal" <?= $pais === 'Senegal' ? 'selected' : '' ?>>Senegal</option>
        <option value="Serra Leoa" <?= $pais === 'Serra Leoa' ? 'selected' : '' ?>>Serra Leoa</option>
        <option value="Sérvia" <?= $pais === 'Sérvia' ? 'selected' : '' ?>>Sérvia</option>
        <option value="Singapura" <?= $pais === 'Singapura' ? 'selected' : '' ?>>Singapura</option>
        <option value="Síria" <?= $pais === 'Síria' ? 'selected' : '' ?>>Síria</option>
        <option value="Somália" <?= $pais === 'Somália' ? 'selected' : '' ?>>Somália</option>
        <option value="Sri Lanka" <?= $pais === 'Sri Lanka' ? 'selected' : '' ?>>Sri Lanka</option>
        <option value="Suazilândia" <?= $pais === 'Suazilândia' ? 'selected' : '' ?>>Suazilândia</option>
        <option value="Sudão" <?= $pais === 'Sudão' ? 'selected' : '' ?>>Sudão</option>
        <option value="Sudão do Sul" <?= $pais === 'Sudão do Sul' ? 'selected' : '' ?>>Sudão do Sul</option>
        <option value="Suécia" <?= $pais === 'Suécia' ? 'selected' : '' ?>>Suécia</option>
        <option value="Suíça" <?= $pais === 'Suíça' ? 'selected' : '' ?>>Suíça</option>
        <option value="Suriname" <?= $pais === 'Suriname' ? 'selected' : '' ?>>Suriname</option>
        <option value="Tailândia" <?= $pais === 'Tailândia' ? 'selected' : '' ?>>Tailândia</option>
        <option value="Taiwan" <?= $pais === 'Taiwan' ? 'selected' : '' ?>>Taiwan</option>
        <option value="Tajiquistão" <?= $pais === 'Tajiquistão' ? 'selected' : '' ?>>Tajiquistão</option>
        <option value="Tanzânia" <?= $pais === 'Tanzânia' ? 'selected' : '' ?>>Tanzânia</option>
        <option value="Timor-Leste" <?= $pais === 'Timor-Leste' ? 'selected' : '' ?>>Timor-Leste</option>
        <option value="Togo" <?= $pais === 'Togo' ? 'selected' : '' ?>>Togo</option>
        <option value="Tonga" <?= $pais === 'Tonga' ? 'selected' : '' ?>>Tonga</option>
        <option value="Trinidad e Tobago" <?= $pais === 'Trinidad e Tobago' ? 'selected' : '' ?>>Trinidad e Tobago</option>
        <option value="Tunísia" <?= $pais === 'Tunísia' ? 'selected' : '' ?>>Tunísia</option>
        <option value="Turcomenistão" <?= $pais === 'Turcomenistão' ? 'selected' : '' ?>>Turcomenistão</option>
        <option value="Turquia" <?= $pais === 'Turquia' ? 'selected' : '' ?>>Turquia</option>
        <option value="Tuvalu" <?= $pais === 'Tuvalu' ? 'selected' : '' ?>>Tuvalu</option>
        <option value="Ucrânia" <?= $pais === 'Ucrânia' ? 'selected' : '' ?>>Ucrânia</option>
        <option value="Uganda" <?= $pais === 'Uganda' ? 'selected' : '' ?>>Uganda</option>
        <option value="Uruguai" <?= $pais === 'Uruguai' ? 'selected' : '' ?>>Uruguai</option>
        <option value="Uzbequistão" <?= $pais === 'Uzbequistão' ? 'selected' : '' ?>>Uzbequistão</option>
        <option value="Vanuatu" <?= $pais === 'Vanuatu' ? 'selected' : '' ?>>Vanuatu</option>
        <option value="Vaticano" <?= $pais === 'Vaticano' ? 'selected' : '' ?>>Vaticano</option>
        <option value="Venezuela" <?= $pais === 'Venezuela' ? 'selected' : '' ?>>Venezuela</option>
        <option value="Viêt Nam" <?= $pais === 'Viêt Nam' ? 'selected' : '' ?>>Viêt Nam</option>
        <option value="Zâmbia" <?= $pais === 'Zâmbia' ? 'selected' : '' ?>>Zâmbia</option>
        <option value="Zimbábue" <?= $pais === 'Zimbábue' ? 'selected' : '' ?>>Zimbábue</option>
      </select>
    </div>

    <div class="col-md-12 text-end">
      <button type="submit" class="btn-purple">Filtrar</button>
    </div>
  </form>

  <!-- Gráficos lado a lado -->
  <div class="d-flex justify-content-center align-items-start gap-5">
    <!-- Removido o gráfico de colunas -->
    <!-- Gráfico de pizza -->
    <div>
      <canvas id="pieChart" style="width: 400px; height: 400px;"></canvas>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>
  // Dados do gráfico
  const chartData = {
    labels: ['Masculino', 'Feminino', 'Outro'],
    datasets: [
      {
        label: 'Alunos por gênero',
        data: [
          <?= $stats['total_masculino'] ?? 0 ?>,
          <?= $stats['total_feminino'] ?? 0 ?>,
          <?= $stats['total_outro'] ?? 0 ?>
        ],
        backgroundColor: ['#4e73df', '#e74a3b', '#1cc88a'],
        borderWidth: 0 // Remove a linha branca entre as fatias
      }
    ]
  };

  // Configurações padrão do gráfico
  const chartOptions = {
    responsive: true,
    plugins: {
      legend: {
        display: true,
        position: 'top',
        labels: {
          font: {
            size: 16,
            family: 'Arial, sans-serif',
            weight: 'bold'
          },
          color: '#333'
        }
      },
      datalabels: {
        color: '#fff',
        font: {
          size: 14,
          weight: 'bold'
        },
        formatter: (value, context) => {
          const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
          const percentage = ((value / total) * 100).toFixed(1);
          return `${percentage}%`;
        }
      }
    },
    hoverOffset: 15
  };

  // Inicializa apenas o gráfico de pizza
  const pieCtx = document.getElementById('pieChart').getContext('2d');
  const pieChart = new Chart(pieCtx, {
    type: 'pie',
    data: chartData,
    options: chartOptions,
    plugins: [ChartDataLabels]
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>