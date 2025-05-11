from faker import Faker
import random
from datetime import datetime, timedelta

fake_br = Faker('pt_BR')
Faker.seed(42)

salas = [
    '1º Ano Fundamental','2º Ano Fundamental','3º Ano Fundamental',
    '4º Ano Fundamental','5º Ano Fundamental','6º Ano Fundamental',
    '7º Ano Fundamental','8º Ano Fundamental','9º Ano Fundamental',
    '1º Ano Médio','2º Ano Médio','3º Ano Médio'
]

sala_idade = {
    '1º Ano Fundamental': (6, 7),
    '2º Ano Fundamental': (7, 8),
    '3º Ano Fundamental': (8, 9),
    '4º Ano Fundamental': (9, 10),
    '5º Ano Fundamental': (10, 11),
    '6º Ano Fundamental': (11, 12),
    '7º Ano Fundamental': (12, 13),
    '8º Ano Fundamental': (13, 14),
    '9º Ano Fundamental': (14, 15),
    '1º Ano Médio': (15, 16),
    '2º Ano Médio': (16, 17),
    '3º Ano Médio': (17, 18)
}

paises_exemplo = ['Argentina', 'Angola', 'Alemanha', 'Japão', 'Estados Unidos', 'Itália', 'China', 'França']

def gerar_data_nascimento(faixa_idade):
    idade = random.randint(*faixa_idade)
    hoje = datetime.now()
    nascimento = hoje.replace(year=hoje.year - idade) - timedelta(days=random.randint(0, 364))
    return nascimento.strftime('%Y-%m-%d')

def gerar_aluno(id, sala):
    idade_range = sala_idade[sala]
    nome = fake_br.name()
    nome_social = nome if random.random() > 0.7 else fake_br.first_name()
    cpf = fake_br.cpf()
    rg = str(random.randint(100000000, 999999999))
    data_nascimento = gerar_data_nascimento(idade_range)
    deficiencia = random.choice(['sim', 'nao'])
    nome_pai = fake_br.name_male()
    nome_mae = fake_br.name_female()
    responsavel = random.choice([nome_pai, nome_mae])
    rg_responsavel = str(random.randint(100000000, 999999999))
    tipo_responsavel = random.choice(['pai', 'mãe', 'avó', 'tio', 'responsável legal'])
    tel_responsavel = fake_br.phone_number()
    trabalho_responsavel = fake_br.company()
    tel_trabalho_responsavel = fake_br.phone_number()
    renda_responsavel = round(random.uniform(800, 6000), 2)
    email_responsavel = fake_br.email()
    email_aluno = fake_br.email()
    endereco = fake_br.street_address().replace("'", "")
    bairro = fake_br.bairro().replace("'", "")
    cidade = fake_br.city().replace("'", "")
    uf = fake_br.estado_sigla()
    cep = fake_br.postcode().replace('-', '')
    complemento = f"Bloco {random.choice(['A', 'B', 'C'])}, Apto {random.randint(101, 305)}"
    telefone_fixo = fake_br.phone_number()
    cel_responsavel = fake_br.phone_number()
    cor = random.choice(['Branca', 'Parda', 'Preta', 'Amarela', 'Indígena'])
    ra = str(fake_br.random_number(digits=8, fix_len=True))
    registro_sus = str(fake_br.random_number(digits=15, fix_len=True))
    nis = str(fake_br.random_number(digits=11, fix_len=True))
    tipo_sanguineo = random.choice(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])
    medicamento = '' if random.random() > 0.8 else fake_br.word()
    genero = random.choice(['Masculino', 'Feminino', 'Não binário'])
    tem_gemeos = random.choice(['sim', 'nao'])
    quantos_gemeos = random.randint(1, 3) if tem_gemeos == 'sim' else 0
    pais = 'Brasil' if random.random() > 0.15 else random.choice(paises_exemplo)

    return (
        id, nome, nome_social, cpf, rg, data_nascimento, deficiencia, nome_pai, nome_mae, responsavel,
        rg_responsavel, tipo_responsavel, tel_responsavel, trabalho_responsavel, tel_trabalho_responsavel,
        renda_responsavel, email_responsavel, email_aluno, endereco, bairro, cidade, uf, cep,
        complemento, telefone_fixo, cel_responsavel, cor, ra, registro_sus, nis, tipo_sanguineo,
        medicamento, genero, tem_gemeos, quantos_gemeos, sala, pais
    )

def escape(valor):
    return valor.replace("'", "''") if isinstance(valor, str) else valor

inserts = []
id_counter = 1
for sala in salas:
    for _ in range(40):
        aluno = gerar_aluno(id_counter, sala)
        valores = ', '.join(
            f"'{escape(valor)}'" if isinstance(valor, str) else str(valor) for valor in aluno
        )
        inserts.append(f"""INSERT INTO alunos (
    id, nome, nome_social, cpf, rg, data_nascimento, deficiencia, nome_pai, nome_mae, responsavel,
    rg_responsavel, tipo_responsavel, tel_responsavel, trabalho_responsavel, tel_trabalho_responsavel,
    renda_responsavel, email_responsavel, email_aluno, endereco, bairro, cidade, uf, cep,
    complemento, telefone_fixo, cel_responsavel, cor, ra, registro_sus, nis, tipo_sanguineo,
    medicamento, genero, tem_gemeos, quantos_gemeos, sala, pais
) VALUES ({valores});\n""")

        id_counter += 1

with open("alunos_480.sql", "w", encoding="utf-8") as f:
    f.writelines(inserts)
