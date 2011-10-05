<? ob_start() ?>
<html>
<head>
  <link href="style.css" rel="stylesheet" type="text/css">
  <link type="text/css" href="css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
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
        document.forms["form"]["total"].value = total.toFixed(2);
        total = total - parseFloat(document.forms["form"]["desconto"].value);
        document.forms["form"]["total_com_desconto"].value = total.toFixed(2);
    }
  </script>
</head>

<body onload="calcularTotal()">
			<?
                include_once($_SERVER['DOCUMENT_ROOT'] . '/locacao/resources/session.php');
                include_once($_SERVER['DOCUMENT_ROOT'] . '/locacao/resources/db.php');
                if ((isset($_GET['id']) == FALSE) or (isset($_GET['imovel_id']) == FALSE))
                    exit;
                $imovel_id = (int) $_GET['imovel_id'];
                $result = mysql_query("SELECT imovel_endereco FROM boletos where imovel_id = '$imovel_id'") or trigger_error(mysql_error());
                $row = mysql_fetch_row($result);
                $endereco = $row[0];
                echo "<a href='list.php?imovel_id=$imovel_id'>Voltar</a><br />";
                echo "<h2>Editando o Boleto</h2>";
                echo '<strong>' . $endereco . '</strong><br />';
                				
                $msg = '';
                $id = (int) $_GET['id'];
                if (isset($_POST['submitted'])) {
                    foreach ($_POST AS $key => $value) {
                        $_POST[$key] = mysql_real_escape_string(htmlentities($value));
                    }
                    $sql = "UPDATE `boletos` SET `ccorrente` =  '{$_POST['ccorrente']}' , `digito_cc` =  '{$_POST['digito_cc']}' , `banco` =  '{$_POST['banco']}' , `agencia` =  '{$_POST['agencia']}' , `cedente_codigo` =  '{$_POST['cedente_codigo']}' , `cedente_nome` =  '{$_POST['cedente_nome']}' , `carteira` =  '{$_POST['carteira']}' , `nosso_num` =  '{$_POST['nosso_num']}' , `vencimento` =  '{$_POST['vencimento']}' , `num_doc` =  '{$_POST['num_doc']}' , `sacado` =  '{$_POST['sacado']}' , `aluguel` =  '{$_POST['aluguel']}' , `iptu` =  '{$_POST['iptu']}' , `sanepar` =  '{$_POST['sanepar']}' , `limpeza` =  '{$_POST['limpeza']}' , `material` =  '{$_POST['material']}' , `copel` =  '{$_POST['copel']}' , `outros` =  '{$_POST['outros']}' , `pago` =  '{$_POST['pago']}' , `desconto` =  '{$_POST['desconto']}'";

                    if ($_POST['data_pagto'] != NULL)
                        $sql = $sql . ", `data_pagto` =  '{$_POST['data_pagto']}'";

                    if ($_POST['total_pago'] != NULL)
                        $sql = $sql . ", `total_pago` =  '{$_POST['total_pago']}'";

                    $sql = $sql . " WHERE `id` = '$id' ";
                    mysql_query($sql) or die(mysql_error());
                    $msg = (mysql_affected_rows()) ? "Cadastro salvo" : "Nada foi alterado";
                }
                $row = mysql_fetch_array(mysql_query("SELECT * FROM `boletos` WHERE `id` = '$id'"));                
			    foreach ($row AS $key => $value) {
				  $row[$key] = stripslashes($value);
				}                                
            ?>

		<div id='mensagem'>
			<script type='text/javascript'>
             var msg = "<?php echo $msg ?>";
             if (msg != '') {
               scroll(msg);
             }                        
            </script>
		</div>
		
		<form action="" name="form" method="post">		
			<fieldset>
				<legend>Dados Bancarios</legend>
					<label for="ccorrente">Conta Corrente</label>
						<input type="text" id="ccorrente" name="ccorrente" value="<?= $row['ccorrente'] ?>"><br />
					<label for="digito_cc">Digito CC</label>	
						<input type="text" id="digito_cc" name="digito_cc" value="<?= $row['digito_cc'] ?>" maxlength="1"><br />
					<label for="banco">Banco</label>
						<input type="text" id="banco" name="banco" value="<?= $row['banco'] ?>"><br />
					<label for="agencia">Agencia</label>	
						<input type="text" id="agencia" name="agencia" value="<?= $row['agencia'] ?>"><br />
					<label for="carteira">Carteira</label>	
						<input type="text" id="carteira" name="carteira" value="<?= $row['carteira'] ?>"><br />
					<label for="nosso_num">Nosso Num</label>	 
						<input type="text" id="nosso_num" name="nosso_num" value="<?= $row['nosso_num'] ?>"><br />
					<label for="cedente_codigo">Cedente Codigo</label>	
						<input type="text" id="cedente_codigo" name="cedente_codigo" value="<?= $row['cedente_codigo'] ?>"><br />
					<label for="cedente_nome">Cedente Nome</label>
						<input type="text" id="cedente_nome" name="cedente_nome" size=60 value="<?= $row['cedente_nome'] ?>"><br />
					<label for="sacado">Sacado</label>
						<input type="text" id="sacado" name="sacado" size=60 value="<?= $row['sacado'] ?>"><br />
			</fieldset>
			<fieldset>
				<legend>Dados do Boleto</legend>
					<label for="vencimento">Vencimento</label>
						<input type="text" id="vencimento" name="vencimento" value="<?= $row['vencimento'] ?>"><br />
					<label for="num_doc">Num Doc</label>
						<input type="text" id="num_doc" name="num_doc" value="<?= $row['num_doc'] ?>"><br />
					<label for="aluguel">Aluguel</label>	
						<input type="text" id="aluguel" name="aluguel" value="<?= $row['aluguel'] ?>" onChange='calcularTotal()'><br />
					<label for="copel">Copel</label>
						<input type="text" id="copel" name="copel" value="<?= $row['copel'] ?>" onChange='calcularTotal()'><br />
					<label for="sanepar">Sanepar</label>
						<input type="text" id="sanepar" name="sanepar" value="<?= $row['sanepar'] ?>" onChange='calcularTotal()'><br />
					<label for="material">Material</label>							
						<input type="text" id="material" name="material" value="<?= $row['material'] ?>" onChange='calcularTotal()'><br />
					<label for="iptu">Iptu</label>	
						<input type="text" id="iptu" name="iptu" value="<?= $row['iptu'] ?>" onChange='calcularTotal()'><br />
					<label for="limpeza">Limpeza</label>	 
						<input type="text" id="limpeza" name="limpeza" value="<?= $row['limpeza'] ?>" onChange='calcularTotal()'><br />
					<label for="outros">Outros</label>
						<input type="text" id="outros" name="outros" value="<?= $row['outros'] ?>" onChange='calcularTotal()'><br />
					<label for="desconto">Desconto</label>	 
						<input type="text" id="desconto" name="desconto" value="<?= $row['desconto'] ?>" onChange='calcularTotal()'><br />
			</fieldset>					
			<fieldset>
				<legend>Pagamento</legend>
					<label for="total">Total</label>
						<input type="text" id="total" name="total" readonly="readonly"><br />
					<label for="total_com_desconto">Total com Desconto</label>
						<input type="text" id="total_com_desconto" name="total_com_desconto" readonly="readonly"><br />					
					<label for="pago">Pago</label>
						<? if ($row['pago'] == 1) { ?>
				  			<input type="radio" name="pago" value="1" checked> Sim 
				  			<input type="radio" name="pago" value="0"> Nao <br />
						<? } else { ?>
							<input type="radio" name="pago" value="1"> Sim 
							<input type="radio" name="pago" value="0" checked> Nao <br />
						<? } ?>
					<label for="data_pagto">Data do pagto</label>	
						<input type="text" id='data_pagto' name='data_pagto' value='<?= $row['data_pagto'] ?> '><br />
					<label for="total_pago">Total pago</label>	
						<input type="text" id="total_pago" name="total_pago" value='<?= $row['total_pago'] ?>'><br />							
			</fieldset>
			<p><input type='submit' value='Salvar' /><input type='hidden' value='1' name='submitted' /></p>						
		</form>			
</body>
</html>
<?
  mysql_close($link);
  ob_flush()
?>
