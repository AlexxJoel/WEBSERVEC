<?php
header("Content-Type","application/json");
$method = $_SERVER["REQUEST_METHOD"];
echo "----------------------\n".  $method . "\n----------------------\n";

switch($method){
    case 'GET': // tyepe of method
        echo "USTED VA A CONSULTAR UN(OS) REGISTRO \n";

        try{ //conecttion to database
            $conexion = new PDO("mysql:host=localhost;dbname=kof","root","");
        }catch(PDOException $e){
            echo $e->getMessage();
        }

        switch ($_GET['accion']){ // check database table
            case "personaje" :
                echo "-------------------\n Tipos de personajes\n---------------\n";
                if (isset($_GET['id'])){
                    echo "Registro Unico\n";

                    $rs =  id($conexion);
                    if ($rs != null){
                        echo json_encode($rs, JSON_PRETTY_PRINT); // print
                    }else{
                        echo "-----------------Personaje no encontradooo! 500";
                    }
                }else{
                    // Query
                    $pstm = $conexion->prepare('SELECT personaje.id,personaje.name,lastname,birthday,utiliza_magia,estatura ,peso ,equipo,magia.name as MAGIA , tipo_lucha.name AS lucha FROM kof.personaje inner join magia on magia_id=magia.id inner join tipo_lucha on  tipo_lucha_id = tipo_lucha.id ;');
                    $pstm->execute(); //execute to do the function
                    $rs = $pstm->fetchAll(PDO::FETCH_ASSOC); // check the dates
                    echo json_encode($rs, JSON_PRETTY_PRINT); // print
                }

                break;
            case "magia" :
                echo "-------------------\n Tipos de Magia\n---------------\n";
                // Query
                $pstm = $conexion->prepare('SELECT * FROM kof.magia;');
                $pstm->execute(); //execute to do the function
                $rs = $pstm->fetchAll(PDO::FETCH_ASSOC); // check the dates
                echo json_encode($rs, JSON_PRETTY_PRINT); // print

                break;
            case "tipo_lucha" :
                echo "-------------------\n Tipos de lucha\n---------------\n";
                // Query
                $pstm = $conexion->prepare('SELECT * FROM kof.tipo_lucha;');
                $pstm->execute(); //execute to do the function
                $rs = $pstm->fetchAll(PDO::FETCH_ASSOC); // check the dates
                echo json_encode($rs, JSON_PRETTY_PRINT); // print

                break;
            default:
                echo "Dato no encontradoo!! 500";
                break;
        }
        break;

    case 'POST':
        if($_GET['accion']=='personaje'){
            $jsonData = json_decode(file_get_contents("php://input")); // give dates in a object
            try{
                $conn = new PDO("mysql:host=localhost;dbname=kof","root","");
            }catch(PDOException $e){
                echo $e->getMessage();
            }

            if (!names($conn,$jsonData)){
                $query = $conn->prepare('INSERT INTO `kof`.`personaje` (`name`, `lastname`, `birthday`, `utiliza_magia`, `estatura`, `peso`, `equipo`, `magia_id`, `tipo_lucha_id`) VALUES (:name, :lastname, :date, :useMagic, :hight, :heigt, :haveTeam, :idMagic, :idLucha);');

                $query->bindParam(":name",$jsonData->name);
                $query->bindParam(":lastname",$jsonData->lastname);
                $query->bindParam(":date",$jsonData->birthday);
                $query->bindParam(":useMagic",$jsonData->utiliza_magia);
                $query->bindParam(":hight",$jsonData->estatura);
                $query->bindParam(":heigt",$jsonData->peso);
                $query->bindParam(":haveTeam",$jsonData->equipo);
                $query->bindParam(":idMagic",$jsonData->magia_id);
                $query->bindParam(":idLucha",$jsonData->tipo_lucha_id);
                $result = $query->execute();
                if($result){
                    $_POST["error"] = false;
                    $_POST["message"] = "Personaje registrado correctamente.";
                    $_POST["status"] = 200;
                }else{
                    $_POST["error"] = true;
                    $_POST["message"] = "Error al registrar";
                    $_POST["status"] = 400;
                }

                echo json_encode($_POST);
            }else{
                echo "-----------------Registro ya existente\n ";
            }

        }
        break;

    case 'PUT':
        echo "USTED VA A ACTUALIZAR UN REGISTRO \n";

        if($_GET['accion']=='personaje'){
            $jsonData = json_decode(file_get_contents("php://input")); // give dates in a object
            try{
                $conn = new PDO("mysql:host=localhost;dbname=kof","root","");
            }catch(PDOException $e){
                echo $e->getMessage();
            }
            $rs =  idPUT($conn,$jsonData); //Check if id is existent
            if ($rs != null){
                if (!names($conn,$jsonData)){ // check names

                    $query = $conn->prepare('UPDATE `kof`.`personaje` SET `name` = :name, `lastname` = :lastname, `birthday` = :date, `utiliza_magia` = :useMagic, `estatura` = :hight, `peso` =  :heigt, `equipo` = :haveTeam, `magia_id` = :idMagic, `tipo_lucha_id` = :idLucha WHERE (`id` = :id );');


                    $query->bindParam(":id",$jsonData->id);
                    $query->bindParam(":name",$jsonData->name);
                    $query->bindParam(":lastname",$jsonData->lastname);
                    $query->bindParam(":date",$jsonData->birthday);
                    $query->bindParam(":useMagic",$jsonData->utiliza_magia);
                    $query->bindParam(":hight",$jsonData->estatura);
                    $query->bindParam(":heigt",$jsonData->peso);
                    $query->bindParam(":haveTeam",$jsonData->equipo);
                    $query->bindParam(":idMagic",$jsonData->magia_id);
                    $query->bindParam(":idLucha",$jsonData->tipo_lucha_id);
                    $result = $query->execute();
                    if($result){
                        $_POST["error"] = false;
                        $_POST["message"] = "Personaje Actualizado  correctamente.";
                        $_POST["status"] = 200;
                    }else{
                        $_POST["error"] = true;
                        $_POST["message"] = "Error al actualizar";
                        $_POST["status"] = 400;
                    }

                    echo json_encode($_POST);
                }else{
                    echo "-----------------Registro ya existente\n ";
                }

            }else{
                echo "-----------------Personaje no encontradooo para actualizar! 500";
            }

        }

        break;


    case 'DELETE':
        echo "USTED VA A ELIMINAR UN REGISTRO \n";
        echo "-----------\nERROR 400! EN MANTENIMIENTOO\n --------------";
        break;

    default:
        echo "ACCIÓN INCORRECTA";
        break;
}

function id($conexion ){
    // Query
    $pstm = $conexion->prepare('		SELECT personaje.id,personaje.name,lastname,birthday,utiliza_magia,estatura ,peso ,equipo,magia.name as MAGIA , tipo_lucha.name AS lucha FROM kof.personaje inner join magia on magia_id=magia.id inner join tipo_lucha on  tipo_lucha_id = tipo_lucha.id where personaje.id = :num ;');
    $pstm->bindParam(":num",$_GET['id'] );
    $pstm->execute(); //execute to do the function
    $rs = $pstm->fetchAll(PDO::FETCH_ASSOC); // check the dates
    return $rs;
}


function idPUT($conexion,$json  ){
    // Query
    $pstm = $conexion->prepare('SELECT id FROM kof.personaje WHERE id  = :num;');
    $pstm->bindParam(":num",$json->id );
    $pstm->execute(); //execute to do the function
    $rs = $pstm->fetchAll(PDO::FETCH_ASSOC); // check the dates
    return $rs;
}



function names($conn, $json ){
    // Query
    $pstm = $conn->prepare('SELECT * FROM kof.personaje WHERE `name`  = :name AND `lastname` = :lastname ');
    $pstm->bindParam(":name",$json->name );
    $pstm->bindParam(":lastname",$json->lastname );
    $pstm->execute(); //execute to do the function
    $rs = $pstm->fetchAll(PDO::FETCH_ASSOC); // check the dates
    return $rs != null ;
}