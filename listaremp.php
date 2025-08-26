<?php
include "conexao.php";

echo "Empréstimos Ativos";
$sqlAtivos = "SELECT e.id_emprestimo, l.titulo, le.nome AS leitor, e.data_emprestimo
              FROM emprestimos e
              JOIN livros l ON e.id_livro = l.id_livro
              JOIN leitores le ON e.id_leitor = le.id_leitor
              WHERE e.data_devolucao IS NULL";
$ativos = $conexao->query($sqlAtivos);

while ($row = $ativos->fetch_assoc()) {
    echo "ID: {$row['id_emprestimo']} | Livro: {$row['titulo']} | Leitor: {$row['leitor']} | Data: {$row['data_emprestimo']}<br>";
}

echo "Empréstimos Concluídos";
$sqlConcluidos = "SELECT e.id_emprestimo, l.titulo, le.nome AS leitor, e.data_devolucao
                  FROM emprestimos e
                  JOIN livros l ON e.id_livro = l.id_livro
                  JOIN leitores le ON e.id_leitor = le.id_leitor
                  WHERE e.data_devolucao IS NOT NULL";
$concluidos = $conexao->query($sqlConcluidos);

while ($row = $concluidos->fetch_assoc()) {
    echo "ID: {$row['id_emprestimo']} | Livro: {$row['titulo']} | Leitor: {$row['leitor']} | Devolvido em: {$row['data_devolucao']}<br>";
}
?>