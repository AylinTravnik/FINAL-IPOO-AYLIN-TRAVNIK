<?php
include '../datos/Viaje.php';
include '../datos/Pasajero.php';
include '../datos/Responsable.php';
include '../datos/Empresa.php';
include '../datos/BaseDatos.php';

precarga();
menu();

function validaNumero($cartel)
{
    $bien = false;
    $numero=0;
    while (!$bien) {
        $numero=readline($cartel);
        if (is_numeric($numero)) {
            $bien=true;
        } else {
            echo "Error.. ingrese un número \n";
        }
    }
    return $numero;
}


function vardumptostring($arreglo){
    $largo=count($arreglo);
    for ($i=0; $i<$largo; $i++){
      $obj=$arreglo[$i];
      echo $obj;
    }
    }

function precarga()
{
    $obj_Responsable = new ResponsableV();
    $obj_Empresa = new Empresa();
    $obj_Viaje = new Viaje();
    $obj_Responsable->cargar(1, "Roberto", "Suares", 813932);
    $obj_Empresa->cargar(1, "Via", "av argentina 100");
    $obj_Viaje->cargar(0, "Neuquen", 6, $obj_Responsable, $obj_Empresa, 10000, "primera clase semicama", "si");
    $obj_Pasajero1 = new Pasajero();
    $obj_Pasajero2 = new Pasajero();
    $obj_Pasajero3 = new Pasajero();
    $obj_Pasajero4 = new Pasajero();
    $obj_Pasajero5 = new Pasajero();
    $obj_Pasajero1->cargar(11234234, "Martina", "Gomez", 4435678, $obj_Viaje);
    $obj_Pasajero2->cargar(22234234, "Bonachon", "Perez", 4412345, $obj_Viaje);
    $obj_Pasajero3->cargar(33234234, "Luciana", "Dominguez", 4478987, $obj_Viaje);
    $obj_Pasajero4->cargar(44234234, "Carlos", "Bies", 4456787, $obj_Viaje);
    $obj_Pasajero5->cargar(55234234, "Maria", "Suzzete", 4456567, $obj_Viaje);
    $obj_Responsable->insertar();
    $obj_Empresa->insertar();
    if ($obj_Viaje->insertar()) {
        $obj_Pasajero1->insertar();
        $obj_Pasajero2->insertar();
        $obj_Pasajero3->insertar();
        $obj_Pasajero4->insertar();
        $obj_Pasajero5->insertar();
    }
    $obj_Empresa->cargar(1, "Empresa1", "av 123");
}
 
function textoMenu()
{
    echo "
------------------------------------------
0-Salir
1-Funciones empresa
2-Funciones responsable
3-Funciones viaje
4-Funciones pasajero
------------------------------------------
        \n";
}
function abmEmpresa()
{
    $opcion=1;
    while ($opcion!=0) {
        echo "------------------------------------------
    0-Salir
    1-Alta empresa
    2-Baja empresa
    3-Modificacion empresa
    4-Listar todas las empresas
    ------------------------------------------
            \n";
        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case 0:  break;
            case 1 :
                echo "Ingresar número del responsable: \n";
                $r = new ResponsableV();
                $arre = $r->listar("");
                if (count($arre)>0) {
                    echo "-------------------------------------------------------------------------------------------\n";
                    echo "Ingrese el numero de empleado\n";
                    $rdocumento = trim(fgets(STDIN));
                    $r->Buscar($rdocumento);
                    if ($r->getnumEmpleado()!="") {
                        agregarEmpresa($r);
                    } else {
                        echo "No existe el empleado con numero ".$rdocumento."\n";
                    }
                } else {
                    echo "No hay responsables cargado\n";
                }
              
                 break;
            case 2 :
                $empresa = new Empresa();
                $aux = $empresa->listar("");
                if (count($aux)>0) {
                    for ($i=0; $i<count($aux);$i++) {
                        echo $aux[$i];
                    }
                } else {
                        echo "No hay empresas.\n";
                    }
                echo "Ingrese el ID de la empresa: \n";
                    $id = trim(fgets(STDIN));
                    $empresa->Buscar($id);
                    if ($empresa->getIdEmpresa() != "") {
                        $empresa->eliminar();
                        if ($empresa->eliminar() == false){
                        echo "No se puede eliminar; está asociado a un viaje
                        .\n";
                        }else {
                        echo "Empresa eliminada satisfactoriamente.";
                        }
                    } else {
                        echo "No existe la empresa con el identificador ingresado.\n";
                    }

                break;
            case 3 :
                $empresa = new Empresa();
                $aux = $empresa->listar("");
                if (count($aux)>0) {
                    for ($i=0; $i<count($aux);$i++) {
                        echo $aux[$i];
                    }
                } else {
                        echo "No hay empresas.\n";
                    }
                echo "Ingrese el ID de la empresa: \n";
                $e = trim(fgets(STDIN));
                $em = new Empresa();
               
                $em->Buscar($e);
                if ($em->getIdEmpresa()!="") {
                    modificarEmpresa($em);
                } else {
                    echo "No existe la empresa con el identificador ".$e;
                }
                break;
            case 4 :
                $empresa = new Empresa();
                $aux = $empresa->listar("");
                if (count($aux)>0) {
                    for ($i=0; $i<count($aux);$i++) {
                        echo $aux[$i];
                    }
                } else {
                        echo "No hay empresas.\n";
                    }
             break;
            default: echo "Inténtelo de nuevo.";
        }
    }
}
function abmResponsable()
{
    $opcion=1;
    while ($opcion!=0) {
        echo "
    0-Salir
    1-Alta Responsable
    2-Baja Responsable
    3-Modificacion Responsable
    4-Listar todos los Responsables
        \n";
        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case 0:  break;
            case 1 :
                agregarResponsable();
                break;
            case 2 :
                echo "Ingrese el ID del responsable: \n";
                $e = trim(fgets(STDIN));
                $em = new ResponsableV();
                $em->Buscar($e);
                if ($em->getnumEmpleado()!="") {
                    borrarResponsable($em);
                } else {
                    echo "Nombre de responsable incorrecto, o inexistente.";
                }
                break;
            case 3 :
                $responsable = new ResponsableV();
                $aux = $responsable->listar("");
                if (count($aux)>0) {
                    for ($i=0; $i<count($aux);$i++) {
                        echo $aux[$i];
                    }
                } else {
                        echo "No hay responsables.\n";
                    }
                echo "Ingrese el ID del responsable: \n";
                $id = trim(fgets(STDIN));
                $responsable->Buscar($id);
                if ($responsable->getnumEmpleado()!="") {
                    modificarResponsable($responsable);
                } else {
                    echo "No existe el responsable con ese número.\n";
                }
               
                break;
            case 4 :
                $responsable = new ResponsableV();
                $aux = $responsable->listar("");
                if (count($aux)>0) {
                    for ($i=0; $i<count($aux);$i++) {
                        echo $aux[$i];
                    }
                } else {
                        echo "No hay responsables.\n";
                    }
             break;
            default: echo "Inténtelo de nuevo.";
        }
    }
}
function abmViaje()
{
    $opcion=1;
    while ($opcion!=0) {
        echo "
0-Salir
1-Alta Viaje
2-Baja Viaje
3-Modificacion Viaje
4-ABM pasajeros
5-Listar todos los Viaje
        \n";
        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case 0:  break;
            case 1 :
                echo "Ingrese el número de empleado: \n";
                $r = trim(fgets(STDIN));
                $responsable = new ResponsableV();
                $responsable->Buscar($r);
                if ($responsable->getnumEmpleado()!="") {
                    echo "Ingrese el identificador de la empresa: \n";
                    $e = trim(fgets(STDIN));
                    $Empresa = new Empresa();
                    $Empresa->Buscar($e);
                    if ($Empresa->getIdEmpresa()!="") {
                        agregarViaje($responsable, $Empresa);
                    } else {
                        echo "No existe una empresa con ese número. \n ";
                    }
                } else {
                        echo "No existe un responsable con ese número de empleado. \n ";
                    }
                
                 break;
            case 2 :
                $viaje = new Viaje();
                $aux = $viaje->listar("");
                if (count($aux)>0) {
                    for ($i=0; $i<count($aux);$i++) {
                        echo $aux[$i];
                    }
                } else {
                        echo "No hay viajes.\n";
                    }
                echo "Ingrese el ID del viaje: \n";
                    $id = trim(fgets(STDIN));
                    $viaje->Buscar($id);
                    if ($viaje->getidviaje() != "") {
                        $viaje->eliminar();
                        if ($viaje->eliminar() == false){
                        echo "No se puede eliminar; está asociado a pasajeros.\n";
                        }else {
                        echo "Viaje eliminado satisfactoriamente.";
                        }
                    } else {
                        echo "No existe el viaje con el identificador ingresado.\n";
                    }
                break;
            case 3:
                $viaje = new Viaje();
                $aux = $viaje->listar("");
                if (count($aux)>0) {
                    for ($i=0; $i<count($aux);$i++) {
                        echo $aux[$i];
                    }
                } else {
                        echo "No hay viajes cargados\n";
                    }
                echo "*A continuacion ingrese el identificador\n";
                $id = trim(fgets(STDIN));
                $viaje->Buscar($id);
                if ($viaje->getidviaje()!="") {
                    modificarViaje($viaje);
                } else {
                    echo "No existe un viaje con ese identificador\n";
                }
                break;
            case 4:
               abmPasajero();
                break;
            case 5:
                $viaje = new Viaje();
                $aux = $viaje->listar("");
                if (count($aux)>0) {
                    for ($i=0; $i<count($aux);$i++) {
                        echo $aux[$i];
                    }
                } else {
                        echo "No hay viajes cargados\n";
                    }
             break;
            default: echo "Inténtelo de nuevo.";
        }
    }
}
function abmPasajero()
{
    $opcion=1;
    while ($opcion!=0) {
        echo "
0-Salir
1-Alta pasajero
2-Baja pasajero
3-Modificacion pasajero
4-Listar todas las pasajeros de un viaje
    \n";
        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
        case 0:  break;
        case 1 :
            agregarPasajero();
             break;
        case 2 :
            borrarPasajero();
            break;
        case 3 :
             modificarPasajero();
            break;
        case 4 :
            echo "Ingrese ID del viaje: ";
            $id = trim(fgets(STDIN));
            $viaje = new Viaje();
            $DatosViaje = $viaje->listar("idviaje =".$id);

            if (count($DatosViaje)==1) {
                $pasajero = new Pasajero();
                vardumptostring($pasajero->listar("idviaje=".$DatosViaje[0]->getidviaje()));
            } else {
                echo "No hay un viaje con ese destino ".$destino."\n";
            }
         break;
        default: echo "Inténtelo de nuevo.";
    }
    }
}
function menu()
{
    $opcion = 1;
    while ($opcion != 0) {
        textoMenu();
        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case 0: echo "Finalizo programa"; break;
            case 1 : abmEmpresa(); break;
            case 2 : abmResponsable(); break;
            case 3 : abmViaje(); break;
            case 4 : abmPasajero(); break;
            default: echo "Inténtelo de nuevo.";break;
        }
    }
}

/**Funciones empresa */
function agregarEmpresa($numeroEmpleado)
{
    $IdEmpresa="";
    echo "Ingrese Nombre de la Empresa: ";
    $nombreEmpresa = trim(fgets(STDIN));
    echo "La direccion De la empresa: ";
    $direccionEmpresa =  trim(fgets(STDIN));
    $nuevaEmpresa= new Empresa();
    $nuevaEmpresa->cargar($IdEmpresa, $nombreEmpresa, $direccionEmpresa, $numeroEmpleado);
    $nuevaEmpresa->insertar();
}

function modificarEmpresa($soyEmpresa)
{
    echo "Ingrese Nombre de la Empresa: ";
    $nombreEmpresa = trim(fgets(STDIN));
    echo "La direccion De la empresa: ";
    $direccionEmpresa = trim(fgets(STDIN));
    $soyEmpresa->setEnombre($nombreEmpresa);
    $soyEmpresa->setEdireccion($direccionEmpresa);
    $soyEmpresa->modificar();
}
function borrarEmpresa($soyEmpresa)
{
    $soyEmpresa->eliminar();
}
/**Funciones responable */
function agregarResponsable()
{
    echo "Ingrese Nombre del Responsable: ";
    $nombreResponsable = trim(fgets(STDIN));
    echo "Ingrese Apellido del Responsable: ";
    $apellidoResponsable =trim(fgets(STDIN));
    echo "Ingrese numero de licencia del responsable: ";
    $numeroLicencia= trim(fgets(STDIN));
    $nuevoResponsable= new ResponsableV();
    $nuevoResponsable->cargar(0, $nombreResponsable, $apellidoResponsable, $numeroLicencia);
    $nuevoResponsable->insertar();
}
function modificarResponsable($responsable)
{
    echo "Ingrese Nombre del Responsable: ";
    $nombreResponsable =trim(fgets(STDIN));
    echo "Ingrese Apellido del Responsable: ";
    $apellidoResponsable =trim(fgets(STDIN));
    echo "Ingrese numero de licencia del responsable: ";
    $numeroLicencia= trim(fgets(STDIN));
    $responsable->setNombre($nombreResponsable);
    $responsable->setApellido($apellidoResponsable);
    $responsable->setnumLicencia($numeroLicencia);
    $responsable->modificar();
}
function borrarResponsable($responsable)
{
    $responsable->eliminar();
    if ($responsable->eliminar() == false){
        echo "No se pudo eliminar el responsable, está asociado a empresa.";
    }else{
        echo "Responsable eliminado.";
    };
}

 function agregarViaje($responsable, $Empresa)
 {
     $nuevoViaje = new Viaje();
     echo "Ingrese el destino: ";
     $destino = trim(fgets(STDIN));
     $ID= $Empresa->getIdEmpresa();
   
     $listaDestino = $nuevoViaje->listar("vdestino='".$destino."'");

     $totalViajes=count($listaDestino);
     if ($totalViajes>0) {
         for ($i = 0; $i <$totalViajes; $i++) {
         }
         $empViaje= $listaDestino[$i]->getEmpresa(); //PORQUE ES CELESTE

         if ($empViaje==$ID) {
             echo "Ya existe un viaje de esta empresa con ese destino\n";
         }
     } else {
         echo "Ingrese la capacidad del viaje: ";
         $capacidad = trim(fgets(STDIN));
         echo "Ingrese el precio del viaje: ";
         $importe=trim(fgets(STDIN));
         echo "Ingrese si el viaje es  ida y vuelta: SI/NO ";
         $idayvuelta =  trim(fgets(STDIN));
         echo "Ingrese categoria de Asientos del viaje: ";
         $tipoAsiento =trim(fgets(STDIN));
        
         $nuevoViaje->cargar(0, $destino, $capacidad, $responsable, $Empresa, $importe, $tipoAsiento, $idayvuelta);
         $nuevoViaje->insertar();
     }
 }

 function modificarViaje($viaje)
 {
     $id = $viaje->getidviaje();
     $pas= new pasajero();
     $a = $pas->listar(("idviaje='".$id."'"));
     $totalPasajeros= count($a);
     $viaje = new Viaje;
     echo "Ingrese el destino: ";
     $destino = trim(fgets(STDIN));
     $lista = $viaje->listar("vdestino='".$destino."'");
     $viajeAMod = $viaje->Buscar("vdestino='".$destino."'");



     echo "Ingrese la capacidad del viaje: ";
     $capacidad = trim(fgets(STDIN));
     if ($capacidad<$totalPasajeros) {
         echo "la cantidad de pasajeros ya en el viaje, supera a la cantidad ingresada";
     } else {
         echo "Ingrese el precio del viaje: ";
         $importe=trim(fgets(STDIN));
         echo "Ingrese si el viaje es  ida y vuelta: SI/NO ";
         $idayvuelta =  trim(fgets(STDIN));
         echo "Ingrese categoria de Asientos del viaje: ";
         $tipoAsiento =trim(fgets(STDIN));
         $empresa = $viaje->getEmpresa();
         $responsable = $viaje->getResponsable();
    
         $viaje->cargar($id, $destino, $capacidad, $responsable, $empresa, $importe, $tipoAsiento, $idayvuelta);
         $viaje->modificar();
     }
 }
function borrarViaje($viaje)
{
    $viaje->eliminar();
}

/**Funciones Pasajero */
function agregarPasajero()
{
    $destino = readline("Ingrese Destino del pasajero:\n");
    $viaje = new Viaje();
    $consulta = "vdestino ='".$destino."'";

    $DatosViaje = $viaje->listar($consulta);
    if (count($DatosViaje) == 1) {
        $nuevoPasajero= new Pasajero();
        $viaje = $DatosViaje[0];
        $idViaje = $viaje->getidviaje();
        $cantAsientosTotal = $viaje->getCantMaxima();
        $condicion = "idviaje=".$idViaje;
        $asientos = $nuevoPasajero->listar($condicion);
        $cantAsientosOcupados = count($asientos);
        if (($cantAsientosTotal - $cantAsientosOcupados) > 0) {
            $nombrePasajero = readline("Ingrese Nombre del Pasajero: \n");
            $apellidoPasajero = readline("Ingrese Apellido del pasajero: \n");
            $dniPasajero= readline("Ingrese Dni del pasajero: \n");
            $telefonoPasajero=validaNumero("Ingrese el telefono del pasajero:\n");

            $nuevoPasajero->cargar($dniPasajero, $nombrePasajero, $apellidoPasajero, $telefonoPasajero, $viaje);
            if ($nuevoPasajero->insertar()) {
                echo "Se inserto correctamente el pasajero en la BD\n";
            } else {
                echo "Error no se inserto el pasajero en la BD. \n";
            }
        } else {
            echo "No hay lugar en el viaje (Total Asientos:".$cantAsientosTotal.", Asientos Vendidos:".$cantAsientosOcupados.")\n";
        }
    } else {
        echo "No existe el viaje con destino ".$destino." revise el ABM de viaje para verificar que lo escribio correctamente\n";
    }
}

function modificarPasajero()
{
    echo "Ingrese ID del viaje: ";
    $id = trim(fgets(STDIN));
    $viaje = new Viaje();
    $DatosViaje = $viaje->listar("idviaje =".$id);
    $pasajero = new Pasajero();

    if (count($DatosViaje)==1) {
        vardumptostring($pasajero->listar("idviaje=".$DatosViaje[0]->getidviaje()));
    } else {
        echo "No hay un viaje con ese destino ".$destino."\n";
    }

    $pasajero = new Pasajero();
    echo "Ingrese Dni del pasajero: ";
    $dni = trim(fgets(STDIN));
    $pasajero->Buscar($dni);
    $aux = $pasajero;

    if ($pasajero->getNumDoc()!= "") {
        echo "Ingrese Nombre del Pasajero: ";
        $nombrePasajero = trim(fgets(STDIN));
        echo "Ingrese Apellido del pasajero: ";
        $apellidoPasajero = trim(fgets(STDIN));
        echo "Ingrese el telefono del pasajero:";
        $telefonoPasajero=trim(fgets(STDIN));
        $pasajero->setNumDoc($aux->getNumDoc());
        $pasajero->setNombre($nombrePasajero);
        $pasajero->setApellido($apellidoPasajero);
        $pasajero->setTelefono($telefonoPasajero);
        $pasajero->setViaje($aux->getViaje());

        echo "Desea tambien cambiarlo de viaje? Pulse S para SI sino otra tecla.";
        $r = trim(fgets(STDIN));
        if ($r=='S' or $r=='s') {
            echo "Ingrese nuevo destino: ";
            $destino = trim(fgets(STDIN));
            $viaje = new Viaje();
            $DatosViaje = $viaje->listar("destino =".$destino);
            if (count($DatosViaje) == 1) {
                $idviaje = $DatosViaje[0]['idviaje'];
                $viaje->Buscar($idviaje);
                $pasajero->setViaje($viaje);
                $pasajero->modificar();
            }
        }
    } else {
        echo "No existe ese dni:".$dni;
    }
}

function borrarPasajero()
{
    $pasajero = new Pasajero();
    echo "Ingrese Dni del pasajero a eliminar ";
    $dni = trim(fgets(STDIN));
    $pasajero->Buscar($dni);
    if ($pasajero->getNumDoc() != "") {
        $pasajero->eliminar();
    } else {
        echo "No existe ese pasajero dni:".$dni."\n";
    }
}
