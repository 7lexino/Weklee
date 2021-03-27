<?php
include('../libreria/conect.php');
include('../libreria/elementos.php');
// if the 'term' variable is not sent with the request, exit
if ( !isset($_REQUEST['term']) )
	exit;

// query the database table for zip codes that match 'term'
$rs = mysql_query('select usuario, nombre, email from usuarios where usuario like "'. mysql_real_escape_string($_REQUEST['term']) .'%" order by usuario asc limit 0,10');
// loop through each zipcode returned and format the response for jQuery
$data = array();
if ( $rs && mysql_num_rows($rs) )
{
	while( $row = mysql_fetch_array($rs, MYSQL_ASSOC) )
	{
		$data[] = array(
			'label' => $row['usuario'] .', '. $row['nombre'] .' ' ,
			'value' => $row['usuario']
		);
	}
}
// jQuery wants JSON data
echo json_encode($data);
flush();

?>