<?php
    $cod = clear($agregar);

    $q = $mysqli->query("SELECT * FROM inventario WHERE codigo_barras = '$cod'");
    $r = mysqli_fetch_array($q);


    

    if(isset($enviar)){

    if(!isset($_SESSION['id_cliente'])){
        alert("Inicie sesion antes de comenzar compra");
        redir("?p=login");
    }
        
    if(isset($cant) && isset($talla)){
        
 		    $cant = clear($cant);
            $talla = clear($talla);
            $id_cliente = clear($_SESSION['id_cliente']);
            $qr = $mysqli->query("SELECT * FROM inventario WHERE codigo_barras = '$cod'");
            $rr = mysqli_fetch_array($qr);
            $stock = $rr[$talla];
        
    if($stock>$cant){

            $v = $mysqli->query("SELECT * FROM carrito WHERE id_cliente = '$id_cliente' AND codigo_barras = '$cod' AND talla = '$talla'");
        
	if (mysqli_num_rows($v)>0) {
        
            $s = $mysqli->query("UPDATE carrito SET cantidad = cantidad + $cant WHERE id_cliente = '$id_cliente' AND codigo_barras = '$cod' AND talla = '$talla'");
            alert("Cantidad de piezas actualizada");
            redir("?p=inicio");
        
		}else{
        
            $s = $mysqli->query("INSERT INTO carrito (id_cliente, codigo_barras, talla, cantidad) VALUES ('$id_cliente','$cod','$talla','$cant')");
            alert("Producto agregado al carrito");
            redir("?p=inicio");
        }
            
            
        }else{
            alert("No se cuenta con existencia suficiente para el pedido");
   
        }
        
    }else{
        alert("Ingrese la talla y cantidad que desea");
    }
    
    }
		$precio_total = 0;

	if ($r['oferta']>0) {
	if (strlen($r['oferta'])==1) {
			$desc = "0.0".$r['oferta'];
	}else{
			$desc = "0.".$r['oferta'];
	}
		$precio_total = $r['precio_unidad'] - ($r['precio_unidad'] * $desc);
	}else{
		$precio_total = $r['precio_unidad'];
	}

?>

<form method="post" action="">           
    <table border="0">
        <tr>
            <th rowspan="7" style="border: #553F10 10px groove;" ><img src="productos/<?=$r['imagen']?>" width="350px" height="450px"></th>
        </tr>    
        <tr style="color: #553F10">
            <td align="justify" class="desc_producto_compra"><?=$r['descripcion']?></td>
        </tr>
<?php
    if($r['oferta']>0){
?>
        <tr>    
            <th align="right" ><del>$ <?=$r['precio_unidad']?> <?=$divisa?></del><span class="precio_compra">   $ <?=$precio_total?> <?=$divisa?></span></th>
        </tr>
<?php
    }else{
?>
        <tr>    
            <th align="right" class="precio_compra">$ <?=$r['precio_unidad']?> <?=$divisa?></th>
        </tr>
        <!-- Botones de tallas -->
<?php
         }
?>
        <tr class="formulario">
            <td align="justify" class="radio">
<?php
    if($r['chica_exist']>0){
?>
                <input type="radio" id="Chica" name="talla" value="chica_exist">
                <label for="Chica">Chica</label>
<?php
    }else{
?>
                <h1 style="display: inline-block; color: #0a0a0a; font-size: 1rem; "><del>Chica</del></h1>
<?php
    }
    if($r['med_exist']>0){
?>
                <input type="radio" id="Mediana" name="talla" value="med_exist">
                <label for="Mediana">Mediana</label> 
<?php
    }else{
?>
                <h1 style="display: inline-block; color: #0a0a0a; font-size: 1rem; "><del>Mediana</del></h1>
<?php
    }
    if($r['gde_exist']>0){
?>
                <input type="radio" id="Grande" name="talla" value="gde_exist">
                <label for="Grande">Grande</label>
<?php
    }else{
?>
                <h1 style="display: inline-block; color: #0a0a0a; font-size: 1rem; "><del>Grande</del></h1>
<?php
    }
?>
            </td>
        </tr>
        <tr>
            <th align="left"> Ingrese cantidad: <input type="number" min="1" max="20" value="0" name="cant"></th>
        </tr>
        <tr>
            <td align="right">
                <button name="cancelar" type="submit" style="background: #0a0a0a; border: #553F10;" class="btn btn-secondary">Cancelar</button>
                <button name="enviar" type="submit" value="enviar" style="background: #553F10; border: #0a0a0a" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Agregar al Carrito</button>
            </td>
        </tr>
        </table>   
</form>
