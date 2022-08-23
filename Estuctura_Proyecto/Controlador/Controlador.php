<?php
class Controlador {
    public function verPagina($ruta){
        require_once $ruta;
    }
    public function agregarCita($doc,$med,$fec,$hor,$con){
        $cita       = new Cita(null, $fec, $hor, $doc, $med, $con, "Solicitada","Ninguna");
        $gestorCita = new GestorCita();
        $id         = $gestorCita->agregarCita($cita);
        $result     = $gestorCita->consultarCitaPorId($id);
        require_once '../Vista/html/confirmarCita.php';
    }
    
    public function consultarCitas($doc){
        $gestorCita     = new GestorCita();
        $result         = $gestorCita->consultarCitasPorDocumento($doc);
        require_once '../Vista/html/consultarCitas.php';
    }

    public function cancelarCitas($doc){
        $gestorCita     = new GestorCita();
        $result         = $gestorCita->consultarCitasPorDocumento($doc);
        require_once '../Vista/html/cancelarCitas.php';
    }

    public function consultarPaciente($doc){

        $gestorCita = new GestorCita();
        $result = $gestorCita->consultarPaciente($doc);
        require_once "../Vista/html/consultarPaciente.php";

    }

    public function agregarPaciente($doc,$nom,$ape,$fec,$sex){

        $paciente = new Paciente($doc,$nom,$ape,$fec,$sex);
        $gestorCita = new GestorCita();
        $registros = $gestorCita->agregarPaciente($paciente);

        if ($registros>0) {
            echo "Paciente insertado con exito";
        }
        else{
            echo "Error al insertar el paciente, intente de nuevo";
        }

    }

    public function cargarAsignar(){
        $gestorCita = new GestorCita();
        $result = $gestorCita->consultarMedicos();
        $result2 = $gestorCita->consultarConsultorios();
        require_once "../Vista/html/asignar.php";
    }

    public function consultarHorasDisponibles($medico,$fecha){
        $gestorCita = new GestorCita();
        $result = $gestorCita->consultarHorasDisponibles($medico,$fecha);
        require_once "../Vista/html/consultarHoras.php";
    }

    public function verCita($cita){
        $gestorCita = new GestorCita();
        $result = $gestorCita->consultarCitaPorId($cita);
        require_once "../Vista/html/confirmarCita.php";
    }

    public function confirmarCancelarCita($cita){
        $gestorCita = new GestorCita();
        $registros = $gestorCita->cancelarCita($cita);
        if ($registros>0) {
            ?>

            <script>
            alert('Cancelacion Exitosa');
            window.location = 'index.php?accion=cancelar';
            </script>
            <?php

        }

        else{
            echo "Error al cancelar cita, intente de nuevo";
        }
    }

    public function generarReporte($cita){
      
        require_once '../pdf/fpdf.php'; 
        require_once '../Vista/html/reporteCita.php';
          

        $gestorCita = new GestorCita();
        $resul = $gestorCita->consultarCitaPorId($cita);
        
        ob_start();     
        $content = ob_get_clean(); 
        /*$html2pdf = new FPDF('P','mm','A4');
        $html2pdf ->SetDisplayMode('fullpage');
        $html2pdf ->write($content,0,0);
        $html2pdf ->Output('Informacion de la cita.pdf');*/
        $html2pdf->Addpage();
        $html2pdf->Setfont('arial','B','16');
        $html2pdf ->write('Hola');
        $html2pdf ->Output('Informacion de la cita.pdf');

    }

}

?>