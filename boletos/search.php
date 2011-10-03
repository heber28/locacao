<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/locacao/resources/session.php');
?>

<html>
<head>
<style type="text/css">
#feedback {
	line-height: 0px;
}
</style>
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script type="text/javascript">
            $(document).ready(
            function() {
                $('#nosso_num_input').keyup(
                function() {
                    $.post('search_result.php', { nosso_num: form.nosso_num.value },
                    function(result) {
                        $('#feedback').html(result).show();
                    });
                });
            });

        </script>

</head>


<h2>Quitar Pagamentos</h2>
<a href=/locacao/imoveis/list.php>Voltar</a><br /><br />
<form name="form" action="">
	Nosso N&uacute;mero <input type='text' id='nosso_num_input'
		name='nosso_num'>
</form>
<div id="feedback"></div>

</html>
