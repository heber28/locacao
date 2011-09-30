<? ob_start() ?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css">
<link type="text/css"
	href="css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker-pt-BR.js"></script>
<script type="text/javascript" src="scroll.js"></script>
<script type="text/javascript">
            jQuery(function($) {
                $("#vencimento").datepicker({
                    dateFormat: 'yy-mm-dd',
                    regional: 'pt-BR'
                });
                $("#data_pagto").datepicker({
                    dateFormat: 'yy-mm-dd',
                    regional: 'pt-BR'
                });
            });
        </script>

<script type="text/javascript">
            function calcularTotal()
            {
                var total = parseFloat(document.forms["form"]["aluguel"].value)
                    + parseFloat(document.forms["form"]["copel"].value)
                    + parseFloat(document.forms["form"]["sanepar"].value)
                    + parseFloat(document.forms["form"]["material"].value)
                    + parseFloat(document.forms["form"]["iptu"].value)
                    + parseFloat(document.forms["form"]["limpeza"].value)
                    + parseFloat(document.forms["form"]["outros"].value);
                //$('#Total').html(total.toFixed(2));
                document.forms["form"]["total"].value = total.toFixed(2);
                total = total - parseFloat(document.forms["form"]["desconto"].value);
                //$('#TotalComDesconto').html(total.toFixed(2));
                document.forms["form"]["total_com_desconto"].value = total.toFixed(2);                                                
            }
        </script>

</head>
<body onload="calcularTotal()">
	<div id='wrapper'>
		<div id='header'>
		<?
		include_once($_SERVER['DOCUMENT_ROOT'] . '/locacao/resources/session.php');
		include_once($_SERVER['DOCUMENT_ROOT'] . '/locacao/resources/config.php');
		if ((isset($_GET['id']) == FALSE) or (isset($_GET['imovel_id']) == FALSE))
		exit;
		$imovel_id = (int) $_GET['imovel_id'];
		$result = mysql_query("SELECT imovel_endereco FROM boletos where imovel_id = '$imovel_id'") or trigger_error(mysql_error());
		$row = mysql_fetch_row($result);
		$endereco = $row[0];
		echo "";
		echo '<strong>' . $endereco . "</strong> | <a href='list.php?imovel_id=$imovel_id'>Voltar</a><br />";
		?>
		</div>
		<?
		$msg = '';
		$id = (int) $_GET['id'];
		if (isset($_POST['submitted'])) {
			foreach ($_POST AS $key => $value) {
				$_POST[$key] = mysql_real_escape_string(htmlentities($value));
			}
			$sql = "UPDATE `boletos` SET
            `ccorrente` =  '{$_POST['ccorrente']}' ,
            `digito_cc` =  '{$_POST['digito_cc']}' ,
            `banco` =  '{$_POST['banco']}' ,
            `agencia` =  '{$_POST['agencia']}' ,
            `cedente_codigo` =  '{$_POST['cedente_codigo']}' ,
            `cedente_nome` =  '{$_POST['cedente_nome']}' ,
            `carteira` =  '{$_POST['carteira']}' ,
            `nosso_num` =  '{$_POST['nosso_num']}' ,
            `vencimento` =  '{$_POST['vencimento']}' ,
            `num_doc` =  '{$_POST['num_doc']}' ,
            `sacado` =  '{$_POST['sacado']}' ,
            `aluguel` =  '{$_POST['aluguel']}' ,
            `iptu` =  '{$_POST['iptu']}' ,
            `sanepar` =  '{$_POST['sanepar']}' ,
            `limpeza` =  '{$_POST['limpeza']}' ,
            `material` =  '{$_POST['material']}' ,
            `copel` =  '{$_POST['copel']}' ,
            `outros` =  '{$_POST['outros']}' ,
            `pago` =  '{$_POST['pago']}' ,
            `desconto` =  '{$_POST['desconto']}'";

			if ($_POST['data_pagto'] != NULL)
			$sql = $sql . ", `data_pagto` =  '{$_POST['data_pagto']}'";

			if ($_POST['total_pago'] != NULL)
			$sql = $sql . ", `total_pago` =  '{$_POST['total_pago']}'";

			$sql = $sql . " WHERE `id` = '$id' ";
			mysql_query($sql) or die(mysql_error());
			$msg = (mysql_affected_rows()) ? "Cadastro salvo" : "Nada foi alterado";
		}
		$row = mysql_fetch_array(mysql_query("SELECT * FROM `boletos` WHERE `id` = '$id'"));
		?>

		<div id='mensagem'>
			<script type='text/javascript'>
                        var msg = "<?php echo $msg ?>";
                        if (msg != '') {
                            scroll(msg);
                        }
                    </script>
		</div>

		<form name='form' action='' method='POST'>

			<div id='container'>
				<div id='side-a'>
					Conta Corrente<br /> <input type='text' name='ccorrente'
						value='<?= stripslashes($row['ccorrente']) ?>'><br /> Digito CC<br />
					<input type='text' name='digito_cc'
						value='<?= stripslashes($row['digito_cc']) ?>'><br /> Banco<br />
					<input type='text' name='banco'
						value='<?= stripslashes($row['banco']) ?>'><br /> Agencia<br /> <input
						type='text' name='agencia'
						value='<?= stripslashes($row['agencia']) ?>'><br /> Carteira<br />
					<input type='text' name='carteira'
						value='<?= stripslashes($row['carteira']) ?>'><br /> Nosso Num<br />
					<input type='text' name='nosso_num'
						value='<?= stripslashes($row['nosso_num']) ?>'><br /> Cedente
					Codigo<br /> <input type='text' name='cedente_codigo'
						value='<?= stripslashes($row['cedente_codigo']) ?>'><br /> Cedente
					Nome<br /> <input type='text' name='cedente_nome' size=60
						value='<?= stripslashes($row['cedente_nome']) ?>'><br /> Sacado<br />
					<input type='text' name='sacado' size=60
						value='<?= stripslashes($row['sacado']) ?>'><br />
				</div>
				<div id='side-b'>
					Vencimento<br /> <input type='text' id='vencimento'
						name='vencimento' value='<?= stripslashes($row['vencimento']) ?>'><br />
						
					Num Doc<br /> <input type='text' name='num_doc'
						value='<?= stripslashes($row['num_doc']) ?>'><br /> 
						
					Aluguel<br />
					<input type='text' name='aluguel'
						value='<?= stripslashes($row['aluguel']) ?>' onBlur='calcularTotal()'><br /> 
						
					Copel<br /> <input
						type='text' name='copel'
						value='<?= stripslashes($row['copel']) ?>' onBlur='calcularTotal()'><br /> 
						
					Sanepar<br /> <input
						type='text' name='sanepar'
						value='<?= stripslashes($row['sanepar']) ?>' onBlur='calcularTotal()'><br />
				</div>
				<div id='side-c'>
					Material<br /> <input type='text' name='material'
						value='<?= stripslashes($row['material']) ?>' onBlur='calcularTotal()'><br /> 
						
					Iptu<br /> <input type='text' name='iptu' 
					    value='<?= stripslashes($row['iptu']) ?>' onBlur='calcularTotal()'><br />
												
					Limpeza<br /> <input type='text' name='limpeza'
					    value='<?= stripslashes($row['limpeza']) ?>' onBlur='calcularTotal()'><br />						
						
					Outros<br /> <input type='text' name='outros'
						value='<?= stripslashes($row['outros']) ?>' onBlur='calcularTotal()'><br /> 
						
					Desconto<br /><input type='text' name='desconto'
						value='<?= stripslashes($row['desconto']) ?>' onBlur='calcularTotal()'><br />
				</div>
				<div id='side-d'>
					Total<br />										
					<input type='text' name='total' readonly="readonly"><br />
					Total com Desconto<br />
					<input type='text' name='total_com_desconto' readonly="readonly"><br />
					
					Pago<br /> <input type='radio' name='pago' value='1'
					<?
					if (isset($row['pago']) && $row['pago'] == 1) {
						echo 'checked';
					}
					?>>Sim&nbsp;&nbsp;&nbsp; <input type='radio' name='pago' value='0'
					<?
					if (isset($row['pago']) && $row['pago'] == 0) {
						echo 'checked';
					}
					?>>Nao <br />
					
					Data do pagto<br /> <input type='text'
						id='data_pagto' name='data_pagto'
						value='<?= stripslashes($row['data_pagto']) ?> '><br /> 
						
				    Total Pago<br />
						<input type='text' name='total_pago'
						value='<?= stripslashes($row['total_pago']) ?>'><br />
					<p> 
						<input type='submit' value='Salvar' /><input type='hidden' value='1' name='submitted' />
					</p>
					<br />
				</div>
			</div>
		</form>
	</div>
</body>

</html>
					<?
					mysql_close($link);
					ob_flush()
					?>
