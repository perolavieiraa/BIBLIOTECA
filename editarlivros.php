<?php
include "conexao.php";
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { echo "ID inválido"; exit; }

$autores = $conexao->query("SELECT * FROM autores ORDER BY nome");
$livro = $conexao->query("SELECT * FROM livros WHERE id_livro=$id")->fetch_assoc();
if (!$livro) { echo "Livro não encontrado"; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $conexao->real_escape_string($_POST['titulo']);
    $genero = $conexao->real_escape_string($_POST['genero']);
    $ano = (int)$_POST['ano_publicacao'];
    $id_autor = (int)$_POST['id_autor'];

    $ano_atual = (int)date("Y");
    if ($ano <= 1500 || $ano > $ano_atual) {
        $erro = "Ano inválido.";
    } else {
        $sql = "UPDATE livros SET titulo='$titulo', genero='$genero', ano_publicacao=$ano, id_autor=$id_autor WHERE id_livro=$id";
        if ($conexao->query($sql)) {
            header("Location: listar.php");
            exit;
        } else $erro = "Erro: " . $conexao->error;
    }
}
?>
<h2>Editar Livro</h2>
<a href="listar.php">Voltar</a>
<?php if (!empty($erro)) echo "<p>$erro</p>"; ?>
<form method="post">
Titulo: <input name="titulo" value="<?= htmlspecialchars($livro['titulo']) ?>" required><br>
Gênero: <input name="genero" value="<?= htmlspecialchars($livro['genero']) ?>"><br>
Ano publicação: <input name="ano_publicacao" type="number" value="<?= $livro['ano_publicacao'] ?>" required><br>
Autor:
<select name="id_autor">
<?php while ($a = $autores->fetch_assoc()) { ?>
    <option value="<?= $a['id_autor'] ?>" <?= $a['id_autor'] == $livro['id_autor'] ? 'selected' : '' ?>>
        <?= htmlspecialchars($a['nome']) ?>
    </option>
<?php } ?>
</select><br>
<button>Atualizar</button>
</form>
