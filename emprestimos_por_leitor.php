<?php
include "conexao.php";
$id_leitor = (int)($_GET['id_leitor'] ?? 0);
if ($id_leitor <= 0) {
    echo "Escolha um leitor válido.";
    echo "<br><a href='../leitores/listar.php'>Voltar</a>";
    exit;
}

$leitor = $conexao->query("SELECT nome FROM leitores WHERE id_leitor=$id_leitor")->fetch_assoc();
if (!$leitor) { echo "Leitor não encontrado"; exit; }

echo "<h2>Empréstimos de: " . htmlspecialchars($leitor['nome']) . "</h2>";
echo "<a href='../leitores/listar.php'>Voltar</a><br><br>";

$sql = "SELECT e.id_emprestimo, l.titulo, e.data_emprestimo, e.data_devolucao
        FROM emprestimos e
        JOIN livros l ON e.id_livro = l.id_livro
        WHERE e.id_leitor = $id_leitor
        ORDER BY e.data_emprestimo DESC";
$res = $conexao->query($sql);

if ($res->num_rows == 0) echo "Nenhum empréstimo encontrado.<br>";
while ($r = $res->fetch_assoc()) {
    $status = $r['data_devolucao'] ? "Devolvido em {$r['data_devolucao']}" : "Ativo desde {$r['data_emprestimo']}";
    echo "ID: {$r['id_emprestimo']} | Livro: {$r['titulo']} | $status";
    echo " [<a href='../emprestimos/editar.php?id={$r['id_emprestimo']}'>Editar</a>]<br>";
}
