<html>
    <head>
        <link rel="stylesheet" href="new.css">
    </head>
    <body>
        <form action='' method='POST'>
            <div id="wrapper">
                <div id="header">
                    <?
                    include('config.php');
                    if (isset($_GET['imovel_id']) == FALSE)
                        exit;
                    $imovel_id = (int) $_GET['imovel_id'];
                    $result = mysql_query("SELECT endereco FROM imoveis where id = '$imovel_id'") or trigger_error(mysql_error());
                    $row = mysql_fetch_row($result);
                    $endereco = $row[0];
                        echo "";

                    echo '<strong>' . $endereco . "</strong> | <a href='list.php?imovel_id=$imovel_id'>Voltar</a>";
                    if (isset($_POST['submitted'])) {
                        foreach ($_POST AS $key => $value) {
                            $_POST[$key] = mysql_real_escape_string($value);
                        }
                        $sql = "INSERT INTO `boletos` ( `imovel_id` ,  `imovel_endereco` ,  `ccorrente` ,  `digito_cc` ,  `banco` ,  `agencia` ,  `cedente_codigo` ,  `cedente_nome` ,  `carteira` ,  `nosso_num` ,  `vencimento` ,  `num_doc` ,  `data_doc` ,  `sacado` ,  `aluguel` ,  `iptu` ,  `sanepar` ,  `limpeza` ,  `material` ,  `copel` ,  `outros` ,  `pago` ,  `data_pagto` ,  `desconto` ,  `valor_pago`  ) VALUES(  '{$_GET['imovel_id']}' ,  '{$_POST['imovel_endereco']}' ,  '{$_POST['ccorrente']}' ,  '{$_POST['digito_cc']}' ,  '{$_POST['banco']}' ,  '{$_POST['agencia']}' ,  '{$_POST['cedente_codigo']}' ,  '{$_POST['cedente_nome']}' ,  '{$_POST['carteira']}' ,  '{$_POST['nosso_num']}' ,  '{$_POST['vencimento']}' ,  '{$_POST['num_doc']}' ,  '{$_POST['data_doc']}' ,  '{$_POST['sacado']}' ,  '{$_POST['aluguel']}' ,  '{$_POST['iptu']}' ,  '{$_POST['sanepar']}' ,  '{$_POST['limpeza']}' ,  '{$_POST['material']}' ,  '{$_POST['copel']}' ,  '{$_POST['outros']}' ,  '{$_POST['pago']}' ,  '{$_POST['data_pagto']}' ,  '{$_POST['desconto']}' ,  '{$_POST['valor_pago']}'  ) ";
                        mysql_query($sql) or die(mysql_error());
                        echo "Added row.<br />";
                        echo "<a href='list.php'>Back To Listing</a>";
                    }
                    ?>
                </div>
                <div id="container">
                    <div id="side-a">
                        <?
                        echo "<p><b>Ccorrente:</b><br /><input type='text' name='ccorrente'/>";
                        echo "<p><b>Digito Cc:</b><br /><input type='text' name='digito_cc'/>";
                        echo "<p><b>Banco:</b><br /><input type='text' name='banco'/>";
                        echo "<p><b>Agencia:</b><br /><input type='text' name='agencia'/>";
                        echo "<p><b>Carteira:</b><br /><input type='text' name='carteira'/>";
                        echo "<p><b>Nosso Num:</b><br /><input type='text' name='nosso_num' disabled='disabled'/>";
                        echo "<p><b>Cedente Codigo:</b><br /><input type='text' name='cedente_codigo'/>";
                        echo "<p><b>Cedente Nome:</b><br /><input type='text' name='cedente_nome' size=60/>";
                        echo "<p><b>Sacado:</b><br /><input type='text' name='sacado' size=60/>";
                        ?>
                    </div>
                    <div id="content">
                        <?
                        echo "<p><b>Vencimento:</b><br /><input type='text' name='vencimento'/>";
                        echo "<p><b>Num Doc:</b><br /><input type='text' name='num_doc'/>";
                        echo "<p><b>Aluguel:</b><br /><input type='text' name='aluguel'/>";
                        echo "<p><b>Copel:</b><br /><input type='text' name='copel'/>";
                        echo "<p><b>Sanepar:</b><br /><input type='text' name='sanepar'/>";
                        echo "<p><b>Material:</b><br /><input type='text' name='material'/>";
                        echo "<p><b>Iptu:</b><br /><input type='text' name='iptu'/>";
                        echo "<p><b>Limpeza:</b><br /><input type='text' name='limpeza'/>";
                        echo "<p><b>Outros:</b><br /><input type='text' name='outros'/>";
                        ?>
                    </div>
                    <div id="side-b">
                        <?
                        echo "<p><b>Desconto:</b><br /><input type='text' name='desconto'/>";
                        echo "<p><b>Pago:</b><br /><input type='text' name='pago'/>";
                        echo "<p><b>Data Pagto:</b><br /><input type='text' name='data_pagto'/>";
                        echo "<p><b>Valor Pago:</b><br /><input type='text' name='valor_pago'/>";
                        echo "<p><input type='submit' value='Add Row' /><input type='hidden' value='1' name='submitted' />";
                        echo "<br /><br />";
                        ?>
                    </div>
                </div>
                <div id="footer">
                </div>
            </div>
        </form>
    </body>
</html>
