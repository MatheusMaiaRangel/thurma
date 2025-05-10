<?php
// Conexão com o banco de dados
include 'conexao.php';


// Criando a conexão
$conn = new mysqli($host, $user, $pass, $db);

// Verificando a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Pegando dados do formulário
$campos = [
    'nome', 'nome_social', 'cpf', 'rg', 'data_nascimento', 'nacionalidade', 'deficiencia',
    'nome_pai', 'nome_mae', 'responsavel', 'rg_responsavel', 'tipo_responsavel',
    'tel_responsavel', 'empresa_responsavel', 'tel_trabalho_responsavel', 'renda_responsavel',
    'email_responsavel', 'email_aluno', 'endereco', 'bairro', 'cidade', 'uf', 'cep',
    'complemento', 'telefone_fixo', 'cel_responsavel', 'cor', 'ra', 'registro_sus',
    'nis', 'tipo_sanguineo', 'medicamento', 'genero', 'tem_gemeos', 'quantos_gemeos'
];

$dados = [];
foreach ($campos as $campo) {
    $dados[$campo] = $_POST[$campo] ?? null;
}

// Prepara a query
$sql = "INSERT INTO alunos (
    nome, nome_social, cpf, rg, data_nascimento, nacionalidade, deficiencia,
    nome_pai, nome_mae, responsavel, rg_responsavel, tipo_responsavel,
    tel_responsavel, trabalho_responsavel, tel_trabalho_responsavel, renda_responsavel,
    email_responsavel, email_aluno, endereco, bairro, cidade, uf, cep,
    complemento, telefone_fixo, cel_responsavel, cor, ra, registro_sus,
    nis, tipo_sanguineo, medicamento, genero, tem_gemeos, quantos_gemeos
) VALUES (
    ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Erro ao preparar statement: " . $conn->error);
}

$stmt->bind_param(
    "sssssssssssssssssssssssssssssssssis",
    $dados['nome'],
    $dados['nome_social'],
    $dados['cpf'],
    $dados['rg'],
    $dados['data_nascimento'],
    $dados['nacionalidade'],
    $dados['deficiencia'],
    $dados['nome_pai'],
    $dados['nome_mae'],
    $dados['responsavel'],
    $dados['rg_responsavel'],
    $dados['tipo_responsavel'],
    $dados['tel_responsavel'],
    $dados['trabalho_responsavel'],
    $dados['tel_trabalho_responsavel'],
    $dados['renda_responsavel'],
    $dados['email_responsavel'],
    $dados['email_aluno'],
    $dados['endereco'],
    $dados['bairro'],
    $dados['cidade'],
    $dados['uf'],
    $dados['cep'],
    $dados['complemento'],
    $dados['telefone_fixo'],
    $dados['cel_responsavel'],
    $dados['cor'],
    $dados['ra'],
    $dados['registro_sus'],
    $dados['nis'],
    $dados['tipo_sanguineo'],
    $dados['medicamento'],
    $dados['genero'],
    $dados['tem_gemeos'],
    $dados['quantos_gemeos']
);

if ($stmt->execute()) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Cadastrado!',
                text: 'Você cadastrou o aluno com sucesso.',
                icon: 'success'
            }).then(function() {
                window.location.href = 'listagem.php'; // Navega para a página de edição novamente
            });
        });
    </script>";
} else {
    echo "<div class='alert alert-danger text-center mt-3'>Erro ao cadastrar o aluno: " . $stmt->error . "</div>";
}

$stmt->close();
$conn->close();
?>
