<?php
include_once("./db/conexao.php");
// Verificar se foi feito um POST no Servidor
// Variaveis de Ambiente
// $_SERVER = variaveis do servidor
// $_POST = variaveis de envio de formulario POST
// $_GET = variaveis de envio de formulario GET
// $_SESSION = variaveis de sessão
$erro = "";
$mensagem = "";
// Valores das variaveis dos campos do formulario (input)
$id = "";
$nome = "";
$email = "";
$login = "";
$nascimento = "";
$senha = "";

// Verificar se tem um id no GET, se tiver, buscar os dados do usuario
// isset = verifica se uma variavel existe
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    // Verificar se o ID é numerico
    if (!is_numeric($id)) {
        $erro = "ID inválido.";
    }
    else {
        // Buscar os dados do usuario no banco
        //Instrução SQL - SELECT = selecionar dados de uma tabela
        // tabela usuarios ONDE (WHERE) o id é igual ao id do GET
        $sql = "SELECT * FROM usuarios WHERE usuario_id = ?";
        // comando para iniciar uma consulta
        $stmt = $conexao->prepare($sql);
        // Vincular o parametro (id) ao comando SQL
        // i = inteiro (int)
        $stmt->bind_param("i", $id);
        // Executar o comando SQL
        $stmt->execute();
        // Pegar o resultado da consulta
        $resultado = $stmt->get_result();
        // Verificar se encontrou o usuario
        if ($resultado->num_rows == 1) {
            // Pegar os dados da linha retornada
            $linha = $resultado->fetch_object();
            $nome = $linha->nome;
            $email = $linha->email;
            $login = $linha->login;
            $nascimento = $linha->nascimento;
        }
        else {
            $erro = "Usuário não encontrado.";
        }
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // variavel = POST ?? Se o POST não existir o valor será ""
    $nome = $_POST["nome"] ?? "";
    $email = $_POST["email"] ?? "";
    $login = $_POST["login"] ?? "";
    $nascimento = $_POST["nascimento"] ?? "";
    $senha = $_POST["senha"] ?? "";
    //echo("$nome - $email - $login - $nascimento - $senha");
    if (strlen($nome) < 6) {
        $erro .= "Informe o nome com pelo menos 6 caracteres";
    }
    $sql = "INSERT INTO usuarios 
        (nome, email, login, nascimento, senha) 
        VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param(
        "sssss",
        $nome,
        $email,
        $login,
        $nascimento,
        $senha
    );
    // tratamento de erro
    if ($stmt->execute() === true) {
        $id = $stmt->insert_id;
        $mensagem = "Usuário cadastrado com sucesso.";
    } else {
        $erro = "Erro ao cadastrar o usuário: " . $stmt->error;
    }
}

?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema...</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <div class="container my-4">
        <!-- Barra de titulo -->
        <div class="card shadow bg-body-tertiary">
            <h3 class="p-3 fw-bold">Cadastro de Usuário</h3>
        </div>
        <?php
        // != diferente
        if ($mensagem != "") {
            echo ("
                <div class='alert alert-primary my-3' role='alert'>
                    $mensagem
                </div>
            ");
        }
        if ($erro != "") {
            echo ("
                <div class='alert alert-danger my-3' role='alert'>
                    $erro
                </div>
            ");
        }
        ?>
        <!-- Formulário de cadastro -->
        <div class="card shadow bg-body-tertiary my-3">
            <div class="card-body">
                <form method="post">
                    <!-- Mostrar o ID -->
                    <div class="mb-3">
                        <label class="form-label">ID do Usuário</label>
                        <input type="text" class="form-control" readonly
                            id="codigo" name="codigo" value="<?php echo ($id); ?>">
                    </div>
                    <div class="mb-3">
                        <!-- tag atributo = valor -->
                        <label class="form-label">Informe o seu nome</label>
                        <input type="text" class="form-control"
                            id="nome" name="nome" value="<?php echo ($nome); ?>"
                            required minlength="6" maxlength="200">
                    </div>
                    <!-- email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">email</label>
                        <input type="email" class="form-control"
                            id="email" name="email" value="<?php echo ($email); ?>"
                            minlength="5" maxlength="100" required>
                        <div class="invalid-feedback">
                            Informe um email valido
                        </div>
                    </div>
                    <!-- login -->
                    <div class="mb-3">
                        <label for="login" class="form-label">Login</label>
                        <input type="text" class="form-control"
                            id="login" name="login" value="<?php echo ($login); ?>"
                            required minlength="4" maxlength="20">
                        <div class="invalid-feedback">
                            Informe um login
                        </div>
                    </div>
                    <!-- Data Nasc -->
                    <div class="mb-3">
                        <label for="nascimento" class="form-label">Data Nascimento</label>
                        <input type="date" class="form-control"
                            id="nascimento" name="nascimento"
                            value="<?php echo ($nascimento); ?>"
                            min="1900-01-01" max="2020-01-01" required>
                        <div class="invalid-feedback">
                            Informe a data de nascimento
                        </div>
                    </div>
                    <!-- Input senha -->
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" id="senha" name="senha"
                            class="form-control" required minlength="6" maxlength="30">
                    </div>
                    <!-- Button -->
                    <div>
                        <button class="btn btn-success" type="submit">
                            Gravar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>