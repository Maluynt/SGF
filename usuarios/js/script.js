$(document).ready(function() {
    // Tu función para actualizar la hora y la fecha
    function updateTime() {
        const currentDate = new Date();
        const currentTime = currentDate.toLocaleTimeString();
        const currentDateStr = currentDate.toLocaleDateString(); // Obtiene la fecha actual

        const timeElement = document.getElementById('time'); // Asegúrate de que este ID exista
        if (timeElement) { // Verifica que el elemento exista
            timeElement.textContent = `${currentDateStr} ${currentTime}`; // Muestra la fecha y la hora
        } else {
            console.error('Elemento con ID "time" no encontrado.');
        }
    }

    // Llama a la función updateTime cada segundo
    setInterval(updateTime, 1000);
});



$(document).ready(function() {
    $('#id_personal').on('input', function() {
        const termino = $(this).val();
        console.log(termino);
        if (termino.length > 0) {
            $.ajax({
                url: '../controlador/controlador_registrar_usuario.php', // Cambia la ruta si es necesario
                method: 'GET',
                data: { termino: termino },
                success: function(data) {
                    console.log(data);
                    $('#sugerencias-personal').empty(); // Limpiar sugerencias anteriores

                    // Asegúrate de que data sea un array de objetos
                    data.forEach(function(personal) {
                        $('#sugerencias-personal').append(
                            `<a href="#" class="list-group-item list-group-item-action" data-id="${personal.id_personal}" data-nombre="${personal.nombre_personal}">${personal.id_personal} - ${personal.nombre_personal}</a>`
                        );
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
                }
            });
        } else {
            $('#sugerencias-personal').empty(); // Limpiar sugerencias si el campo está vacío
        }
    });

    // Evento para seleccionar una sugerencia
    $(document).on('click', '#sugerencias-personal .list-group-item', function() {
        const idPersonal = $(this).data('id'); // Obtener el ID del personal seleccionado (cambia 'id_personal' a 'id')
        const nombreCompleto = $(this).data('nombre'); // Obtener el nombre completo
        $('#id_personal').val(`${idPersonal} - ${nombreCompleto}`); // Mostrar el ID y nombre en el campo de búsqueda
        $('#id_personal_hidden').val(idPersonal); // Guardar solo el ID en el campo oculto
        $('#sugerencias-personal').empty(); // Limpiar las sugerencias
    });
});




$(document).ready(function() {
    // Funcionalidad para mostrar/ocultar contraseña
    $('#togglePassword').on('click', function() {
        const passwordInput = $('#password');
        const eyeIcon = $('#eyeIcon');

        // Cambia el tipo de input entre 'password' y 'text'
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            eyeIcon.removeClass('fa-eye').addClass('fa-eye-slash'); // Cambia el ícono
        } else {
            passwordInput.attr('type', 'password');
            eyeIcon.removeClass('fa-eye-slash').addClass('fa-eye'); // Cambia el ícono
        }
    });
});
