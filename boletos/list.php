<?

include('config.php');
if (isset($_GET['imovel_id'])) {
    $imovel_id = (int) $_GET['imovel_id'];
    $result = mysql_query("SELECT endereco FROM imoveis where id = '$imovel_id'") or trigger_error(mysql_error());
    $endereco = mysql_result($result, 0);
    echo '<strong>' . $endereco . '</strong> | <a href=/locacao/imoveis/list.php>Voltar</a><br /><br />';
    echo "<table border=1 >";
    echo "<tr>";
    echo "<td><b>Vencimento</b></td>";
    echo "<td><b>Num Doc</b></td>";
    echo "<td><b>Aluguel</b></td>";
    echo "<td><b>Copel</b></td>";
    echo "<td><b>Sanepar</b></td>";
    echo "<td><b>Material</b></td>";
    echo "<td><b>Iptu</b></td>";
    echo "<td><b>Limpeza</b></td>";
    echo "<td><b>Outros</b></td>";
    echo "<td><b>Total</b></td>";
    echo "<td><b>Desconto</b></td>";
    echo "<td><b>Nosso Num</b></td>";
    echo "<td><b>Pago</b></td>";
    echo "<td><b>Data Pagto</b></td>";
    echo "<td><b>Valor Pago</b></td>";
    echo "</tr>";
    $imovel_id = (int) $_GET['imovel_id'];
    $result = mysql_query("SELECT * FROM `boletos` where imovel_id = '$imovel_id'") or trigger_error(mysql_error());
    while ($row = mysql_fetch_array($result)) {
        foreach ($row AS $key => $value) {
            $row[$key] = stripslashes($value);
        }
        echo "<tr>";
        echo "<td valign='top'>" . $row['vencimento'] . "</td>";
        echo "<td valign='top'>" . $row['num_doc'] . "</td>";
        echo "<td valign='top'>" . $row['aluguel'] . "</td>";
        echo "<td valign='top'>" . $row['copel'] . "</td>";
        echo "<td valign='top'>" . $row['sanepar'] . "</td>";
        echo "<td valign='top'>" . $row['material'] . "</td>";
        echo "<td valign='top'>" . $row['iptu'] . "</td>";
        echo "<td valign='top'>" . $row['limpeza'] . "</td>";
        echo "<td valign='top'>" . $row['outros'] . "</td>";
        echo "<td valign='top'>" . number_format(($row['aluguel'] + $row['copel'] + $row['sanepar'] + $row['material'] + $row['iptu'] + $row['limpeza'] + $row['outros']), 2) . "</td>";
        echo "<td valign='top'>" . $row['desconto'] . "</td>";
        echo "<td valign='top'>" . $row['nosso_num'] . "</td>";
        if ($row['pago'] == 1)
            echo "<td valign='top'>Sim</td>";
        else
            echo "<td valign='top'>Nao</td>";
        echo "<td valign='top'>" . $row['data_pagto'] . "</td>";
        echo "<td valign='top'>" . $row['valor_pago'] . "</td>";
        echo "<td valign='top'><a href=edit.php?id={$row['id']}&imovel_id=$imovel_id>Editar</a></td><td><a href=delete.php?id={$row['id']}&imovel_id=$imovel_id>Excluir</a></td> ";
        echo "</tr>";
    }
    echo "</table>";
    echo "<a href=new.php?imovel_id=$imovel_id>Novo cadastro</a> | ";
    echo "<a href=banco.php?imovel_id=$imovel_id>Dados bancarios</a>";
}
?>