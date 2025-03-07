$(document).ready(function() {
    $('#ubicacion').change(function() {
        var id_ubicacion = $(this).val();
        if (id_ubicacion) {
            $.ajax({
                type: 'POST',
                url: '/metro/SGF/abrir/controlador/AjaxControlador.php',
                data: { action: 'obtenerAmbientes', id_ubicacion: id_ubicacion },
                success: function(data) {
                    $('#ambiente').empty().append('<option value="">Seleccionar</option>');
                    var ambientes = JSON.parse(data);
                    $.each(ambientes, function(index, ambiente) {
                        $('#ambiente').append('<option value="' + ambiente.id_ambiente + '">' + ambiente.ambiente + '</option>');
                    });
                }
            });
        } else {
            $('#ambiente').empty().append('<option value="">Seleccionar</option>');
        }
    });

    $('#ambiente').change(function() { // Solo escuchar cambios en ambiente
        var id_ambiente = $(this).val();
        var id_servicio = $('#id_servicio').val(); // Obtener del campo oculto
    
        if (id_ambiente && id_servicio) {
            $.ajax({
                type: 'POST',
                url: '/metro/SGF/abrir/controlador/AjaxControlador.php',
                data: { 
                    action: 'obtenerSubSistemas', 
                    id_ambiente: id_ambiente, 
                    id_servicio: id_servicio // Enviar el id_servicio oculto
                },
                success: function(data) {
                    $('#sub_sistema').empty().append('<option value="">Seleccionar</option>');
                    var subsistemas = JSON.parse(data);
                    $.each(subsistemas, function(index, subsistema) {
                        $('#sub_sistema').append('<option value="' + subsistema.id_subsistema + '">' + subsistema.nombre_subsistema + '</option>');
                    });
                }
            });
        } else {
            $('#sub_sistema').empty().append('<option value="">Seleccionar</option>');
        }
    });
    $('#sub_sistema').change(function() {
        var id_subsistema = $(this).val();
        if (id_subsistema) {
            $.ajax({
                type: 'POST',
                url: '/metro/SGF/abrir/controlador/AjaxControlador.php',
                data: { action: 'obtenerEquipos', id_subsistema: id_subsistema },
                success: function(data) {
                    $('#equipo').empty().append('<option value="">Seleccionar</option>');
                    var equipos = JSON.parse(data);
                    $.each(equipos, function(index, equipo) {
                        $('#equipo').append('<option value="' + equipo.id_equipo + '">' + equipo.nombre_equipo + '</option>');
                    });
                }
            });
        } else {
            $('#equipo').empty().append('<option value="">Seleccionar</option>');
        }
    });
});



