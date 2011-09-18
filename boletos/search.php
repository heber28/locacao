<?php

include('config.php');
echo "<form method='GET'>";
echo "<p>Nosso Numero: ";
echo "<input type='text' name='search'>";
echo "<input type='submit' value='Procurar' /><input type='hidden' value='1' name='submitted' /> | ";
echo "<a href=/locacao/imoveis/list.php>Voltar</a>";
echo "</form>";

if (isset($_GET['submitted'])) {
    $search = stripslashes(mysql_real_escape_string($_GET['search']));
    $sql = "SELECT id, nosso_num, sacado, vencimento, (aluguel + iptu + sanepar + limpeza + material + copel + outros) as total, desconto, pago, data_pagto, valor_pago from boletos where nosso_num like '%$search%' ";
    $result = mysql_query($sql) or die(mysql_error());

    if (mysql_num_rows($result) == 0)
        exit;
    echo "<table>";
    echo "<tr>";
    echo "<th>nosso num</th>
        <th>sacado</th>
        <th>vencimento</th>
        <th>total</th>
        <th>desconto</th>
        <th>pago</th>
        <th>data pagto</th>
        <th>valor pago</th>
        <th></th>";
    echo "</tr>";

    while ($row = mysql_fetch_array($result)) {
        foreach ($row AS $key => $value) {
            $row[$key] = stripslashes($value);
        }
        echo "<tr>";
        echo "<td valign='top'>" . $row['nosso_num'] . "</td>";
        echo "<td valign='top'>" . $row['sacado'] . "</td>";
        echo "<td valign='top'>" . $row['vencimento'] . "</td>";
        echo "<td valign='top' align='right'>" . $row['total'] . "</td>";
        echo "<td valign='top' align='right'>" . $row['desconto'] . "</td>";
        echo "<td valign='top'>";
        if ($row['pago'] == 1)
            echo 'sim';
        else
            echo 'nao';
        echo "</td>";
        echo "<td valign='top'>" . $row['data_pagto'] . "</td>";
        echo "<td valign='top'>" . $row['valor_pago'] . "</td>";
        echo "<td valign='top'><a href=pay.php?id=" . $row['id'] . ">Editar</a></td> ";
        echo "</tr>";
    }
    echo "</table>";
}
mysql_close($link);
?>
