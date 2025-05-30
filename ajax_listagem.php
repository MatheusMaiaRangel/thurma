<?php
include 'conexao.php';

header('Content-Type: application/json');

$cpf = isset($_GET['cpf']) ? trim($_GET['cpf']) : '';
$temGemeos = isset($_GET['temGemeo']) ? $_GET['temGemeo'] : '';
$genero = isset($_GET['genero']) ? $_GET['genero'] : '';
$pais = isset($_GET['pais']) ? trim($_GET['pais']) : '';
$dataNascimento = isset($_GET['dataNascimento']) ? $_GET['dataNascimento'] : '';
$sala = isset($_GET['sala']) ? trim($_GET['sala']) : '';

$query = "SELECT id, nome, cpf, ra, sala FROM alunos WHERE 1=1";
$params = [];
$types = '';

if (!empty($cpf)) {
    $query .= " AND cpf LIKE ?";
    $params[] = "%$cpf%";
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
    echo json_encode(['error' => $conn->error]);
    exit;
}
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$alunos = [];
while ($row = $result->fetch_assoc()) {
    $alunos[] = $row;
}
echo json_encode($alunos);
