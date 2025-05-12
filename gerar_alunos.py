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

paises_exemplo = ['Afeganistão','África do Sul','Albânia','Alemanha','Andorra','Angola','Antígua e Barbuda','Arábia Saudita','Argélia','Argentina','Armênia','Austrália','Áustria','Azerbaijão','Bahamas','Bahrein','Bangladesh','Barbados','Bélgica','Belize','Benin','Bielorrússia','Bolívia','Bósnia e Herzegovina','Botsuana','Brasil','Brunei','Bulgária','Burquina Faso','Burundi','Butão','Cabo Verde','Camarões','Camboja','Canadá','Catar','Cazaquistão','Chade','Chile','China','Chipre','Colômbia','Comores','Congo','Coreia do Norte','Coreia do Sul','Costa do Marfim','Costa Rica','Croácia','Cuba','Dinamarca','Djibuti','Dominica','Egito','El Salvador','Emirados Árabes Unidos','Equador','Eritreia','Eslováquia','Eslovênia','Espanha','Estados Unidos','Estônia','Eswatini','Etiópia','Fiji','Filipinas','Finlândia','França','Gabão','Gâmbia','Gana','Geórgia','Granada','Grécia','Guatemala','Guiana','Guiné','Guiné Equatorial','Guiné-Bissau','Haiti','Holanda','Honduras','Hungria','Iémen','Ilhas Marshall','Ilhas Salomão','Índia','Indonésia','Irã','Iraque','Irlanda','Islândia','Israel','Itália','Jamaica','Japão','Jordânia','Kiribati','Kuwait','Laos','Lesoto','Letônia','Líbano','Libéria','Líbia','Liechtenstein','Lituânia','Luxemburgo','Macedônia do Norte','Madagáscar','Malásia','Malawi','Maldivas','Mali','Malta','Marrocos','Maurício','Mauritânia','México','Mianmar','Micronésia','Moçambique','Moldávia','Mônaco','Mongólia','Montenegro','Namíbia','Nauru','Nepal','Nicarágua','Níger','Nigéria','Noruega','Nova Zelândia','Omã','Palau','Panamá','Papua-Nova Guiné','Paquistão','Paraguai','Peru','Polônia','Portugal','Quênia','Quirguistão','Reino Unido','República Centro-Africana','República Checa','República Democrática do Congo','República Dominicana','Romênia','Ruanda','Rússia','Saara Ocidental','Saint Kitts e Nevis','Saint Vincent e Granadinas','Samoa','San Marino','Santa Lúcia','São Tomé e Príncipe','Senegal','Serra Leoa','Sérvia','Singapura','Síria','Somália','Sri Lanka','Suazilândia','Sudão','Sudão do Sul','Suécia','Suíça','Suriname','Tailândia','Taiwan','Tajiquistão','Tanzânia','Timor-Leste','Togo','Tonga','Trindade e Tobago','Tunísia','Turcomenistão','Turquia','Tuvalu','Ucrânia','Uganda','Uruguai','Uzbequistão','Vanuatu','Vaticano','Venezuela','Vietnã','Zâmbia','Zimbábue']

def gerar_data_nascimento(faixa_idade):
    idade = random.randint(*faixa_idade)
    hoje = datetime.now()
    nascimento = hoje.replace(year=hoje.year - idade) - timedelta(days=random.randint(0, 364))
    return nascimento.strftime('%Y-%m-%d')

def gerar_aluno(id, sala):
    idade_range = sala_idade[sala]
    genero = random.choice(['Masculino', 'Feminino', 'Outro'])
    
    if genero == 'Masculino':
        nome = fake_br.name_male()
    elif genero == 'Feminino':
        nome = fake_br.name_female()
    else:  # Gênero "Outro"
        nome = random.choice([fake_br.name_male(), fake_br.name_female()])
    
    # Nome social só se o gênero for "Outro"
    nome_social = nome if genero != 'Outro' else fake_br.first_name()
    
    cpf = fake_br.cpf()
    rg = str(random.randint(100000000, 999999999))
    data_nascimento = gerar_data_nascimento(idade_range)
    deficiencia = random.choice(['sim', 'nao'])
    nome_pai = fake_br.name_male()
    nome_mae = fake_br.name_female()
    responsavel = random.choice([nome_pai, nome_mae])
    rg_responsavel = str(random.randint(100000000, 999999999))
    tipo_responsavel = random.choice(['Pai', 'Mãe', 'Avó', 'Avô', 'Tio(a)', 'Responsável legal'])
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
    tem_gemeos = random.choice(['sim', 'nao'])
    quantos_gemeos = random.randint(1, 9) if tem_gemeos == 'sim' else 0
    pais = 'Brasil' if random.random() > 0.0064 else random.choice(paises_exemplo)  # 0.64% chance de ser de outro país

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
