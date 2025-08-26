<?php
include "conexao.php";

$filtro_genero = $_GET['genero'] ?? '';
$filtro_autor = $_GET['autor'] ?? '';
$filtro_ano = $_GET['ano'] ?? '';

$sql = "SELECT livros.*, autores.nome AS autor_nome FROM livros
        JOIN autores ON livros.id_autor = autores.id_autor
        WHERE 1";

if (!empty($filtro_genero)) $sql .= " AND genero LIKE '%$filtro_genero%'";
if (!empty($filtro_autor)) $sql .= " AND autores.nome LIKE '%$filtro_autor%'";
if (!empty($filtro_ano)) $sql .= " AND ano_publicacao = $filtro_ano";

$resultado = $conexao->query($sql);
?>

<h2>Lista de Livros</h2>
<form method="get">
    Gênero: <input type="text" name="genero" value="<?= $filtro_genero ?>">
    Autor: <input type="text" name="autor" value="<?= $filtro_autor ?>">
    Ano: <input type="text" name="ano" value="<?= $filtro_ano ?>">
    <button type="submit">Filtrar</button>
</form>

<a href="adicionar.php">Adicionar Livro</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Gênero</th>
        <th>Ano</th>
        <th>Autor</th>
        <th>Ações</th>
    </tr>
    <?php while ($livro = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?= $livro['id_livro'] ?></td>
            <td><?= $livro['titulo'] ?></td>
            <td><?= $livro['genero'] ?></td>
            <td><?= $livro['ano_publicacao'] ?></td>
            <td><?= $livro['autor_nome'] ?></td>
            <td>
                <a href="editar.php?id=<?= $livro['id_livro'] ?>">Editar</a> |
                <a href="excluir.php?id=<?= $livro['id_livro'] ?>">Excluir</a>
            </td>
        </tr>
    <?php } ?>
</table>
