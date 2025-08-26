<?php
include "conexao.php";

$autores = $conexao->query("SELECT * FROM autores");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $ano = $_POST['ano_publicacao'];
    $id_autor = $_POST['id_autor'];

    if ($ano > 1500 && $ano <= date("Y")) {
        $sql = "INSERT INTO livros (titulo, genero, ano_publicacao, id_autor)
                VALUES ('$titulo', '$genero', '$ano', '$id_autor')";
        if ($conexao->query($sql)) {
            echo "Livro adicionado!";
        } else {
            echo "Erro: " . $conexao->error;
        }
    } else {
        echo "Ano inválido!";
    }
}
?>

<form method="post">
    Título: <input type="text" name="titulo"><br>
    Gênero: <input type="text" name="genero"><br>
    Ano Publicação: <input type="number" name="ano_publicacao"><br>
    Autor:
    <select name="id_autor">
        <?php while ($autor = $autores->fetch_assoc()) { ?>
            <option value="<?= $autor['id_autor'] ?>"><?= $autor['nome'] ?></option>
        <?php } ?>
    </select><br>
    <button type="submit">Salvar</button>
</form>
