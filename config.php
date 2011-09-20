<?
$link = mysql_connect('localhost', 'root', '');
if (!$link) {
    die('Not connected : ' . mysql_error());
}

if (! mysql_select_db('aluguel') ) {
    die ('Can\'t use aluguel : ' . mysql_error());
}
?>