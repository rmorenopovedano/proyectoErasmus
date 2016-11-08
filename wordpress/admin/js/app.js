$(document).foundation();
$('#dni').prop("readOnly",false).on('blur', function(){
    var dni=$(this).val();
//si el dni no está vacío hacemos la llamada a ajax
    if(dni.match(/^\d{8}[a-zA-Z]{1}$/)){
        $.ajax({
//tipo de dato que va a recibir
            dataType:"json",
//url a la que llamas
            url:"cargarDni.php",
//parámetros que envias a esa página
            data:{dni_enviado:dni}
//.done es el evento cuando la llamada ajax ha terminado
        }).done(function(participante) {
            if(participante.errorDni==false){
                $('#dni_error').css("display","none");
                $('#nombre').val(participante.nombre);
                $('#email').val(participante.email);
                $('#direccion').val(participante.direccion);
                $('#telefono').val(participante.telefono);
                $('#cp').val(participante.codigoPostal);
                $('#nacionalidad').val(participante.nacionalidad);
                $('#poblacion').val(participante.poblacion);
                $('#ciclo').val(participante.idCiclo);
                $('#tutor').val(participante.idTutor);
                $('#convocatoria').val(participante.idConvocatoria);
                if (participante.pais1) {
                    $('#pais1').val(participante.pais1);
                }
                if (participante.pais2) {
                    $('#pais2').val(participante.pais2).prop("disabled", false);
                }
                if (participante.pais3) {
                    $('#pais3').val(participante.pais3).prop("disabled", false);
                }
                if (participante.TIPO_CV) {
                    $('#archivoCv').html("Consulta tu curriculum");
                    $('#archivoCv').attr({
                        href: "uploads/" + participante.TIPO_CV
                    });
                }

                if (participante.TIPO_PASAPORTE) {
                    $('#archivoPass').html("Consulta tu Pasaporte");
                    $('#archivoPass').attr({
                        href: "uploads/" + participante.TIPO_PASAPORTE
                    });
                }
                if (participante.TIPO_DNI) {
                    $('#archivoDni').html("Consulta tu Fotocopia del DNI");
                    $('#archivoDni').attr({
                        href: "uploads/" + participante.TIPO_DNI
                    });
                }
                if (participante.TIPO_CARTA) {
                    $('#archivoCarta').html("Consulta tu Carta");
                    $('#archivoCarta').attr({
                        href: "uploads/" + participante.TIPO_CARTA
                    });
                }


    //mostrar el resto del formulario
                $('#formulario_oculto').css("display", "block");
                $('#aviso').css("display", "block");
                //deshabilita el input dni cuando es correcto
                $('#dni').prop('readOnly', true);
            }
            else{
                $('#dni_error').css("display","block");
            }
//en caso de que la llamada ajax falle
        }).fail(function(a,b,c){
            console.error(a);
            console.error(b);
            console.error(c);
        });
    };
});
//llamada ajax a paises
$('#pais1').on("change", function(){
    $.ajax({
//url a la que llamas
        url:"cargarPais.php",
//parámetros que envias a esa página
        data:{pais_enviado:$(this).val()}
//.done es el evento cuando la llamada ajax ha terminado
    }).done(function(pais){
        $('#pais2').html(pais).prop("disabled",false);
    });
});
//llamada ajax a paises
    $('#pais2').on("change", function(){
        $.ajax({
    //url a la que llamas
            url:"cargarPais.php",
    //parámetros que envias a esa página
            data:{pais_enviado:$(this).val(), pais_enviado2:$('#pais1').val()}
    //.done es el evento cuando la llamada ajax ha terminado
        }).done(function(pais){
            $('#pais3').html(pais).prop("disabled",false);
        });
    });

//llamada ajax para cargar el listado de alumnos
    $('#convocatoria').on('change', function(){
        var mensaje="<div class='centrar' style='width: 100%'><img style='width: 150px' src='img/cargando.gif'></div>";
        $('#listadoAlumnos').html(mensaje);
        $.ajax({
            url:"cargarConvocatoria.php",
            data:{convocatoria_enviada:$(this).val()}
        }).done(function(convocatoria){
            $('#listadoAlumnos').html(convocatoria);
        })
    });
//llamada ajax para cargar el ranking de alumnos
$('#convocatoria2').on('change', function(){
    var mensaje="<div class='centrar' style='width: 100%'><img style='width: 150px' src='img/cargando.gif'></div>";
    $('#ranking').html(mensaje);
    $.ajax({
        url:"cargarRanking.php",
        data:{convocatoria_enviada:$(this).val()}
    }).done(function(ranking){
        $('#ranking').html(ranking);
    })
});


//datepicker
$( function() {
    $( "#fechaNac" ).datepicker({
        changeMonth: true,
        changeYear: true,
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        changeMonth: true,
        changeYear: true,
        yearRange: '1985:2015',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
        weekHeader: 'Sm',
        dateFormat: 'yy-mm-dd',
        altFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''

    });
} );