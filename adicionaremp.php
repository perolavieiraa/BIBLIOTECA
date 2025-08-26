<?php
include "conexao.php";

$livros = $conexao->query("SELECT * FROM livros");
$leitores = $conexao->query("SELECT * FROM leitores");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_livro = $_POST['id_livro'];
    $id_leitor = $_POST['id_leitor'];
    $data_emprestimo = $_POST['data_emprestimo'];
    $data_devolucao = $_POST['data_devolucao'];

    $verificaLivro = $conexao->query("SELECT * FROM emprestimos WHERE id_livro = $id_livro AND data_devolucao IS NULL");
    if ($verificaLivro->num_rows > 0) {
        echo "Este livro já está emprestado!";
        exit;
    }

    $verificaLeitor = $conexao->query("SELECT COUNT(*) AS qtd FROM emprestimos WHERE id_leitor = $id_leitor AND data_devolucao IS NULL");
    $qtd = $verificaLeitor->fetch_assoc()['qtd'];
    if ($qtd >= 3) {
        echo "Este leitor já possui 3 empréstimos ativos!";
        exit;
    }

    if (!empty($data_devolucao) && $data_devolucao < $data_emprestimo) {
        echo "Data de devolução inválida!";
        exit;
    }

    $sql = "INSERT INTO emprestimos (id_livro, id_leitor, data_emprestimo, data_devolucao)
            VALUES ('$id_livro', '$id_leitor', '$data_emprestimo', " . ($data_devolucao ? "'$data_devolucao'" : "NULL") . ")";
    if ($conexao->query($sql)) {
        echo "Empréstimo registrado!";
    } else {
        echo "Erro: " . $conexao->error;
    }
}
?>

<form method="post">
    Livro:
    <select name="id_livro">
        <?php while ($livro = $livros->fetch_assoc()) { ?>
            <option value="<?= $livro['id_livro'] ?>"><?= $livro['titulo'] ?></option>
        <?php } ?>
    </select><br>
    Leitor:
    <select name="id_leitor">
        <?php while ($leitor = $leitores->fetch_assoc()) { ?>
            <option value="<?= $leitor['id_leitor'] ?>"><?= $leitor['nome'] ?></option>
        <?php } ?>
    </select><br>
    Data Empréstimo: <input type="date" name="data_emprestimo"><br>
    Data Devolução: <input type="date" name="data_devolucao"><br>
    <button type="submit">Registrar</button>
</form>
