$(document).ready(function() {
    // Definir función para obtener ambientes
    function cargarAmbientes() {
        var id_ubicacion = $('#ubicacion').val();
        if (id_ubicacion) {
            $.ajax({
                type: 'POST',
                url: '/metro/SGF/abrir/controlador/AjaxControlador.php',
                data: { 
                    action: 'obtenerAmbientes', 
                    id_ubicacion: id_ubicacion 
                },
                dataType: 'json', // Añadir para parseo automático
                success: function(ambientes) {
                    actualizarSelect('#ambiente', ambientes, 'id_ambiente', 'ambiente');
                },
                error: function(xhr) {
                    console.error('Error cargando ambientes:', xhr.responseText);
                }
            });
        } else {
            resetSelect('#ambiente');
        }
    }

    // Definir función para obtener subsistemas
    function cargarSubsistemas() {
        var id_ambiente = $('#ambiente').val();
        var id_servicio = $('#servicio').length ? $('#servicio').val() : $('#id_servicio').val();

        if (id_ambiente && id_servicio) {
            $.ajax({
                type: 'POST',
                url: '/metro/SGF/abrir/controlador/AjaxControlador.php',
                data: { 
                    action: 'obtenerSubSistemas',
                    id_ambiente: id_ambiente,
                    id_servicio: id_servicio
                },
                dataType: 'json',
                success: function(subsistemas) {
                    actualizarSelect('#sub_sistema', subsistemas, 'id_subsistema', 'nombre_subsistema');
                },
                error: function(xhr) {
                    console.error('Error cargando subsistemas:', xhr.responseText);
                }
            });
        } else {
            resetSelect('#sub_sistema');
        }
    }

    // Definir función para obtener equipos
    function cargarEquipos() {
        var id_subsistema = $('#sub_sistema').val();
        if (id_subsistema) {
            $.ajax({
                type: 'POST',
                url: '/metro/SGF/abrir/controlador/AjaxControlador.php',
                data: { 
                    action: 'obtenerEquipos', 
                    id_subsistema: id_subsistema 
                },
                dataType: 'json',
                success: function(equipos) {
                    actualizarSelect('#equipo', equipos, 'id_equipo', 'nombre_equipo');
                },
                error: function(xhr) {
                    console.error('Error cargando equipos:', xhr.responseText);
                }
            });
        } else {
            resetSelect('#equipo');
        }
    }

    // Función genérica para actualizar selects
    function actualizarSelect(selector, datos, valor, texto) {
        $(selector).empty().append('<option value="">Seleccionar</option>');
        $.each(datos, function(index, item) {
            $(selector).append($('<option>', {
                value: item[valor],
                text: item[texto]
            }));
        });
    }

    // Función para resetear selects
    function resetSelect(selector) {
        $(selector).empty().append('<option value="">Seleccionar</option>');
    }

    // Eventos
    $('#ubicacion').on('change', cargarAmbientes);
    $('#ambiente, #servicio').on('change', cargarSubsistemas);
    $('#sub_sistema').on('change', cargarEquipos);

    // Cargar inicialmente si hay valores
    if ($('#ubicacion').val()) cargarAmbientes();
    if ($('#ambiente').val() || $('#servicio').val()) cargarSubsistemas();
    if ($('#sub_sistema').val()) cargarEquipos();
});