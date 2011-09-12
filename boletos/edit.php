<?
include('config.php');
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    if (isset($_POST['submitted'])) {
        foreach ($_POST AS $key => $value) {
            $_POST[$key] = mysql_real_escape_string($value);
        }
        $sql = "UPDATE `boletos` SET  `imovel_endereco` =  '{$_POST['imovel_endereco']}' ,  `ccorrente` =  '{$_POST['ccorrente']}' ,  `digito_cc` =  '{$_POST['digito_cc']}' ,  `banco` =  '{$_POST['banco']}' ,  `agencia` =  '{$_POST['agencia']}' ,  `cedente_codigo` =  '{$_POST['cedente_codigo']}' ,  `cedente_nome` =  '{$_POST['cedente_nome']}' ,  `carteira` =  '{$_POST['carteira']}' ,  `nosso_num` =  '{$_POST['nosso_num']}' ,  `vencimento` =  '{$_POST['vencimento']}' ,  `num_doc` =  '{$_POST['num_doc']}' ,  `data_doc` =  '{$_POST['data_doc']}' ,  `sacado` =  '{$_POST['sacado']}' ,  `aluguel` =  '{$_POST['aluguel']}' ,  `iptu` =  '{$_POST['iptu']}' ,  `sanepar` =  '{$_POST['sanepar']}' ,  `limpeza` =  '{$_POST['limpeza']}' ,  `material` =  '{$_POST['material']}' ,  `copel` =  '{$_POST['copel']}' ,  `outros` =  '{$_POST['outros']}' ,  `pago` =  '{$_POST['pago']}' ,  `data_pagto` =  '{$_POST['data_pagto']}' ,  `desconto` =  '{$_POST['desconto']}' ,  `valor_pago` =  '{$_POST['valor_pago']}'   WHERE `id` = '$id' ";
        mysql_query($sql) or die(mysql_error());
        echo (mysql_affected_rows()) ? "Edited row.<br />" : "Nothing changed. <br />";
        echo "<a href='list.php'>Back To Listing</a>";
    }
    $row = mysql_fetch_array(mysql_query("SELECT * FROM `boletos` WHERE `id` = '$id' "));
?>

    <form action='' method='POST'>
        <p><b>Imovel Endereco:</b><input type='text' name='imovel_endereco' value='<?= stripslashes($row['imovel_endereco']) ?>' />
        <p><b>Ccorrente:</b><input type='text' name='ccorrente' value='<?= stripslashes($row['ccorrente']) ?>' />
        <p><b>Digito Cc:</b><input type='text' name='digito_cc' value='<?= stripslashes($row['digito_cc']) ?>' />
        <p><b>Banco:</b><input type='text' name='banco' value='<?= stripslashes($row['banco']) ?>' />
        <p><b>Agencia:</b><input type='text' name='agencia' value='<?= stripslashes($row['agencia']) ?>' />
        <p><b>Cedente Codigo:</b><input type='text' name='cedente_codigo' value='<?= stripslashes($row['cedente_codigo']) ?>' />
        <p><b>Cedente Nome:</b><input type='text' name='cedente_nome' value='<?= stripslashes($row['cedente_nome']) ?>' />
        <p><b>Carteira:</b><input type='text' name='carteira' value='<?= stripslashes($row['carteira']) ?>' />
        <p><b>Nosso Num:</b><input type='text' name='nosso_num' value='<?= stripslashes($row['nosso_num']) ?>' />
        <p><b>Vencimento:</b><input type='text' name='vencimento' value='<?= stripslashes($row['vencimento']) ?>' />
        <p><b>Num Doc:</b><input type='text' name='num_doc' value='<?= stripslashes($row['num_doc']) ?>' />
        <p><b>Data Doc:</b><input type='text' name='data_doc' value='<?= stripslashes($row['data_doc']) ?>' />
        <p><b>Sacado:</b><input type='text' name='sacado' value='<?= stripslashes($row['sacado']) ?>' />
        <p><b>Aluguel:</b><input type='text' name='aluguel' value='<?= stripslashes($row['aluguel']) ?>' />
        <p><b>Iptu:</b><input type='text' name='iptu' value='<?= stripslashes($row['iptu']) ?>' />
        <p><b>Sanepar:</b><input type='text' name='sanepar' value='<?= stripslashes($row['sanepar']) ?>' />
        <p><b>Limpeza:</b><input type='text' name='limpeza' value='<?= stripslashes($row['limpeza']) ?>' />
        <p><b>Material:</b><input type='text' name='material' value='<?= stripslashes($row['material']) ?>' />
        <p><b>Copel:</b><input type='text' name='copel' value='<?= stripslashes($row['copel']) ?>' />
        <p><b>Outros:</b><input type='text' name='outros' value='<?= stripslashes($row['outros']) ?>' />
        <p><b>Pago:</b><input type='text' name='pago' value='<?= stripslashes($row['pago']) ?>' />
        <p><b>Data Pagto:</b><input type='text' name='data_pagto' value='<?= stripslashes($row['data_pagto']) ?>' />
        <p><b>Desconto:</b><input type='text' name='desconto' value='<?= stripslashes($row['desconto']) ?>' />
        <p><b>Valor Pago:</b><input type='text' name='valor_pago' value='<?= stripslashes($row['valor_pago']) ?>' />
        <p><input type='submit' value='Edit Row' /><input type='hidden' value='1' name='submitted' />
    </form>
<? } ?>