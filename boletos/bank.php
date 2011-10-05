<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/locacao/resources/session.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/locacao/resources/db.php');
if (isset($_GET['imovel_id'])) {
	$imovel_id = (int) $_GET['imovel_id'];
	$result = mysql_query("SELECT endereco FROM imoveis where id = '$imovel_id'") or trigger_error(mysql_error());
	$row = mysql_fetch_row($result);
	$endereco = $row[0];
        echo "<a href=/locacao/imoveis/list.php>Voltar</a>";
        echo '<h2>Lista de Boletos</h2>';
	echo '<strong>' . $endereco . '</strong><br /><br />';
	echo "<a href=new.php?imovel_id=$imovel_id>Novo cadastro</a> | ";
	echo "<a href=list.php?imovel_id=$imovel_id>Dados do boleto</a><br /><br />";

	$imovel_id = (int) $_GET['imovel_id'];
	$result = mysql_query("SELECT * FROM `boletos` where imovel_id = '$imovel_id' order by vencimento desc limit 14") or trigger_error(mysql_error());

	if (mysql_num_rows($result) > 0) {

		echo "<table border=1 >";
		echo "<tr>";
		echo "<td><b>Vencimento</b></td>";
		echo "<td><b>Ccorrente</b></td>";
		echo "<td><b>Digito Cc</b></td>";
		echo "<td><b>Banco</b></td>";
		echo "<td><b>Agencia</b></td>";
		echo "<td><b>Cedente Codigo</b></td>";
		echo "<td><b>Cedente Nome</b></td>";
		echo "<td><b>Carteira</b></td>";
		echo "<td><b>Sacado</b></td>";

		while ($row = mysql_fetch_array($result)) {
			foreach ($row AS $key => $value) {
				$row[$key] = stripslashes($value);
			}
			echo "<tr>";
			echo "<td valign='top'>" . nl2br($row['vencimento']) . "</td>";
			echo "<td valign='top'>" . nl2br($row['ccorrente']) . "</td>";
			echo "<td valign='top'>" . nl2br($row['digito_cc']) . "</td>";
			echo "<td valign='top'>" . nl2br($row['banco']) . "</td>";
			echo "<td valign='top'>" . nl2br($row['agencia']) . "</td>";
			if ($row['cedente_codigo'] == NULL)
			echo "<td valign='top'>&nbsp</td>";
			else
			echo "<td valign='top'>" . nl2br($row['cedente_codigo']) . "</td>";
			echo "<td valign='top'>" . nl2br($row['cedente_nome']) . "</td>";
			echo "<td valign='top'>" . nl2br($row['carteira']) . "</td>";
			echo "<td valign='top'>" . nl2br($row['sacado']) . "</td>";
			echo "<td valign='top'><a href=edit.php?id={$row['id']}&imovel_id=$imovel_id>Editar</a></td><td><a href=delete.php?id={$row['id']}&imovel_id=$imovel_id>Excluir</a></td> ";
			echo "<td valign='top'><a href=boleto_real.php?id={$row['id']}>Imprimir</a></td>";
			echo "</tr>";
		}
		echo "</table>";
	}
	mysql_close($link);
}
?>
