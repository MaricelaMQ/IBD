<?php
  require('./conector.php');

  $con = new ConectorBD(); //Iniciar un nuevo objeto ConectorDB

  $response['conexion']=$con->initConexion($con->database); //Iniciar la conexion con la base de datos

  if ($response['conexion']=='OK') { //Si la conexión es exitosa

  	$conexion = $con->getConexion(); //Obtener la conexión

  	$insert = $conexion->prepare('INSERT INTO usuarios (email, nombre, password, fecha_nacimiento) VALUES (?,?,?,?)'); //Insertar usuarios a travéz de de la interfaz de objetos de datos PDO

    $insert->bind_param("ssss", $email, $nombre, $password, $fecha_nacimiento); //Dedinir el tipo de variable como string, seguido de los valores de las variables

    //Definir los valores de las variables a insertar en la base de datos
    $defaultPassword = '123456';
    $email = "demo@mail.com";
	  $nombre = "usuario";
    $password = password_hash($defaultPassword, PASSWORD_DEFAULT); //Encriptar la contraseña
    $fecha_nacimiento = "1998-09-08";

    //Ejecutar la sentencia
    $insert->execute();

    //Para ejecutar otra sentencia solo se deben definir nuevamente los parametros y ejecutar la funcion execute()
    $email = "Maricela@mail.com";
	  $nombre = "Maricela Mendez";
    $password = password_hash($defaultPassword, PASSWORD_DEFAULT); //Encriptar la contraseña
    $fecha_nacimiento = "1990-01-01";

    

    $insert->execute();
    $response['resultado']="1"; //Devolver resultado positivo
    $response['msg']= 'Información de inicio de sesion:</br>email:</br>'; //Mostrar mensaje con la información de los usuarios guardados
      $getUsers = $con->consultar(['usuarios'], ['*'], $condicion = ""); //Obtener los usuarios generados anteriormente
      while ($fila = $getUsers->fetch_assoc()){
        $response['msg'].= $fila['email'].'</br>';
      }
      $response['msg'] .='contraseña: '.$defaultPassword; //Mostrar la contraseña por defecto*/


  }else{
    $response['resultado']="0"; //Resultado de error
    $response['msg']= "No se pudo conectar a la base de datos"; //Mosrtar mensaje de error
  }

  echo json_encode($response);



?>
