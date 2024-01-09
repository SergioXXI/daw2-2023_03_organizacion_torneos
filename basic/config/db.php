<?php
//Descomenta la línea que se corresponde con tu proyecto de 
//trabajo y comenta la línea que carga "db_orig.php".
//return require( 'db_orig.php');
//return require( 'db_proyecto_01_seguimiento_ligas_deportivas.php');
//return require( 'db_proyecto_02_reservas_restaurantes.php');
//return require( 'db_proyecto_03_organizacion_torneos.php');
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=daw2_2023_03_organizacion_torneos',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
?>
<pre>
Descomenta la línea que se corresponde con tu proyecto de trabajo en el archivo de configuración de la base de datos.
<?php echo __FILE__; throw new Exception(); ?>
</pre>
