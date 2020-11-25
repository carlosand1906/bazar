<?php
	include "configs/config.php";
	include "configs/funciones.php";

	if(!isset($p)){
		$p="inicio";
	}else{
		$p=$p;
	}
?>
<!DOCTYPE html>
<html>
<head>
    <neta charset="utf-8">
    <neta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Bazar</title>
    <neta name="viewport" content="width=device-width, user-scalable=no, inital-scale=1">
	<link rel="stylesheet" href="css/estilo.css">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css"/>
	<link rel="stylesheet" href="fontawesome/css/all.css"/>
	<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript" src="fontawesome/js/all.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/app.js"></script>
	<script type="text/javascript" src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>
    <nav>
       <div class="header"><img class="img_logo" src="imagenes/bazar-logo.png"></div>
        <ul>
            <li><a href="?p=inicio"><i class="fa fa-home"></i> Inicio</a></li>
            <li><a href="?p=ofertas"><i class="fa fa-tags"></i> Ofertas</a></li>
            <li><a href="?p=catalogo"><i class="fa fa-book"></i> Catalogo</a>
            <ul>
                <li><a href="?p=hombre"><i class="fa fa-male"></i> Hombre</a></li>
                <li><a href="?p=mujer"><i class="fa fa-female"></i> Mujer</a></li>
            </ul>
            </li>
<?php
if (isset($_SESSION['id_cliente'])) {
?>

            <li><a href="?p=carrito"><i class="fa fa-shopping-cart"></i> Carrito</a></li>
            <li><a href="?p=mis_compras"><i class="fa fa-tasks"></i> Mis compras</a></li>
            <li><a href="/admin/"></a></li>
<?php
}else{
?>
            <li><a href="?p=login"><i class="fa fa-user"></i> Iniciar Sesión</a></li>
<?php
}
?>
<?php
if (isset($_SESSION['id_cliente'])) {
		$s = $mysqli->query("SELECT * FROM clientes WHERE id_cliente = '".$_SESSION['id_cliente']."'");
		$r = mysqli_fetch_array($s);
?>
            <li><a class="pull-right" href="#"><i class="fa fa-smile"></i> <?=$r['nombre']?></a></li>
            <li><a class="pull-right" href="?p=salir"><i class="fa fa-power-off"></i> Salir</a></li>
<?php
}
?>
        </ul>
    </nav>
    
    	<div class="cuerpo">
<?php
if (file_exists("modulos/".$p.".php")){
        include "modulos/".$p.".php";
}else{
        echo "<i>Pagina no encontrada <b>".$p."</b> <a href='./'>Regresar</a></i>";
}
?>
	</div> 
      
    <div class="carrito_titulo" onclick="minimizer()">
        <i class="fa fa-shopping-cart"></i> Carrito de compras
        <input type="hidden" id="minimized" value="0" />
    </div>
    
    
    
    
    <div class="carrito_lista">
        <table class="table table-striped">
	<tr>
		<th><i class="fa fa-image"></i></th>
		<th>Cantidad</th>
		<th>Subtotal</th>
	</tr>
<?php
	$id_cliente = clear($_SESSION['id_cliente']);
	$q = $mysqli->query("SELECT * FROM carrito WHERE id_cliente = $id_cliente");
	$monto_total = 0;

while ($r = mysqli_fetch_array($q)) {
	$q2 = $mysqli->query("SELECT * FROM inventario WHERE codigo_barras = '".$r['codigo_barras']."'");
	$r2 = mysqli_fetch_array($q2);

	$precio_total = 0;

	if ($r2['oferta']>0) {
		if (strlen($r2['oferta'])==1) {
			$desc = "0.0".$r2['oferta'];
		}else{
			$desc = "0.".$r2['oferta'];
		}
		$precio_total = $r2['precio_unidad'] - ($r2['precio_unidad'] * $desc);
	}else{
		$precio_total = $r2['precio_unidad'];
	}

	$descripcion = $r2['descripcion'];
    $talla = $r['talla'];
    if($talla == "chica_exist"){
        $talladesc = "Chica";
    }
    if($talla == "med_exist"){
        $talladesc = "Mediana";
    }
    if($talla == "gde_exist"){
        $talladesc = "Grande";
    }
	$cantidad = $r['cantidad'];
	$p_unitario = $precio_total;
	$subtotal = $cantidad*$precio_total;
	$imagen_producto = $r2['imagen'];

	$monto_total = $monto_total + $subtotal;

	?>
		<tr>
			<td><img src="productos/<?=$imagen_producto?>" class="imagen_carro"/></td>
			<td><?=$cantidad?> </td>
			<td style="font-weight: bold; ">$ <?=$subtotal?> <?=$divisa?></td>
		</tr>
	<?php
	}

	?>	

</table>

<span>Monto Total: <b class="text_cafe">$ <?=$monto_total?> <?=$divisa?></b></span>


<br>
	<form method="post" action="?p=carrito">

<?php
  if($monto_total>0){
?>
		<input type="hidden" name="monto_total" value="<?=$monto_total?>" />
		<button class="btn btn-primary" style="background: #553F10; border: #0a0a0a;" type="submit" name="finalizar"><i class="fa fa-check"></i> Finalizar compra</button>
	</form>

<?php
    }else{
?>
    </form>
<?php
    }
?>
    
    
    </div>
   	<div class="footer">
		Derechos reservados &copy; <?=date("Y")?>
	</div>
</body>
</html>

<script type="text/javascript">
    
        function minimizer(){
            
            var minimized = $("#minimized").val();
            
            if(minimized == 0){
               //mostrar
                $(".carrito_titulo").css("bottom","350px");
                $(".carrito_lista").css("bottom","0px");
                $("#minimized").val('1');
            }else{
               //minimizar
                $(".carrito_titulo").css("bottom","0px");
                $(".carrito_lista").css("bottom","-350px");
                $("#minimized").val('0');
           }
        }
        
        
</script>