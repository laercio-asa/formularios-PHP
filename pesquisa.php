<?php
    // Conexão com o banco de dados
    include_once("./db/conexao.php");
    // SQL para selecionar todos os usuarios
    $sql = "SELECT * FROM usuarios ORDER BY nome";
    // Executar o comando SQL
    $resultado = $conexao->query($sql);
    // Verificar quantas linhas foram retornadas
    $num_linhas = $resultado->num_rows;

?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Cadastro - Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- Barra de Menu -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="principal.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pesquisa.php">Usuários</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Conteudo principal do Site -->
    <main>
        <div class="container my-5">
            <!-- titulo da página -->
            <div class="card shadow bg-body-tertiary my-4">
                <h3 class="p-3 fw-bold">Lista de Usuários</h3>
            </div>
            <!-- Resultado da Pesquisa -->
            <div class="card shadow my-4">
                <div class="card-body">
                    <!-- Area da Pesquisa e de novo -->
                    <div class="row">
                        <div class="col-md-4 col">
                            <div class="input-group">
                                <input class="form-control border-end-0" type="text"
                                    id="pesquisa" name="pesquisa"
                                    placeholder="Pesquise nome ou email">
                                <button class="input-group-text bg-white" type="button">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-8 col-auto text-end">
                            <a href="cadastro.php" class="btn btn-primary">
                                <i class="fa-solid fa-circle-plus"></i>
                                <span class="d-md-inline d-none">Novo Usuário</span>
                            </a>
                        </div>
                        <div class="col-12 py-3 table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Login</th>
                                        <th scope="col">email</th>
                                        <th scope="col">Dt. Nasc.</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contador = 0;
                                    while($linha = $resultado->fetch_object()) {
                                        $contador++;
                                    ?>
                                    <tr>
                                        <th scope="row"><?= $contador ?></th>
                                        <td><?= $linha->nome ?></td>
                                        <td><?= $linha->login ?></td>
                                        <td><?= $linha->email ?></td>
                                        <td><?= $linha->nascimento ?></td>
                                        <td>
                                            <a href="cadastro.php?id=<?= $linha->usuario_id ?>"
                                                class="btn btn-primary btn-sm">
                                                <span data-bs-toggle="tooltip" data-bs-placement="left"
                                                    data-bs-title="Alterar usuário">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </span>
                                            </a>
                                            <button class="btn btn-danger btn-sm ms-2">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Fim do row -->
                </div>
            </div>
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
</body>

</html>