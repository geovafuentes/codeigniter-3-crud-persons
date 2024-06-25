<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CRUD PERSONAS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <button class="btn btn-outline-danger" onclick="logout()">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1 style="margin-bottom: 20px;">Personas</h1>
        <button class="btn btn-primary" onclick="add_person()">
            <i class="fas fa-plus"></i> Personas
        </button>
        <input type="text" id="search" class="form-control" placeholder="Buscar personas..." style="margin-top: 20px; margin-bottom: 20px;">
        <table class="table" style="margin-top: 20px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="personList">
                <!-- Data will be appended here via AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Modal Form -->
    <div class="modal fade" id="personModal" tabindex="-1" role="dialog" aria-labelledby="personModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="personForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="personModalLabel">PERSONAS</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" onclick="save_person()" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        load_persons(); // Cargar los datos de las personas cuando la página se carga
        
        // Agregar evento de escucha de teclado al formulario
        $('#personForm').on('keyup', function(event) {
            if (event.keyCode === 13) { // Si se presiona la tecla Enter
                save_person(); // Guardar los datos del formulario
            }
        });

        // Agregar evento de escucha de entrada de búsqueda
        $('#search').on('keyup', function() {
            load_persons($(this).val()); // Llamar a la función load_persons con el término de búsqueda
        });
    });

    function load_persons(search = '') {
        $.ajax({
            url: "<?php echo site_url('persons/get_persons'); ?>",
            type: "GET",
            data: {search: search},
            dataType: "JSON",
            success: function(data) {
                var html = '';
                for (var i = 0; i < data.length; i++) {
                    html += '<tr>' +
                        '<td>' + data[i].id + '</td>' +
                        '<td>' + data[i].first_name + '</td>' +
                        '<td>' + data[i].last_name + '</td>' +
                        '<td>' + data[i].email + '</td>' +
                        '<td>' +
                        '<button class="btn btn-warning mr-3" onclick="edit_person(' + data[i].id + ')"><i class="fas fa-edit"></i> Editar</button> ' +
                        '<button class="btn btn-danger mr-3" onclick="delete_person(' + data[i].id + ')"><i class="fas fa-trash-alt"></i> Eliminar</button>'+
                        '</td>' +
                        '</tr>';
                }
                $('#personList').html(html);
            }
        });
    }

    function add_person() {
        $('#personForm')[0].reset();
        $('#personModal').modal('show');
        $('#personModalLabel').text('Agregar Personas');
    }

    function edit_person(id) {
        $.ajax({
            url: "<?php echo site_url('persons/edit/'); ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#id').val(data.id);
                $('#first_name').val(data.first_name);
                $('#last_name').val(data.last_name);
                $('#email').val(data.email);
                $('#personModal').modal('show');
                $('#personModalLabel').text('Editar Personas');
            }
        });
    }

    function save_person() {
        var first_name = $('#first_name').val().trim();
        var last_name = $('#last_name').val().trim();
        var email = $('#email').val().trim();

        // Validaciones en el lado del cliente
        if (first_name == '' || last_name == '' || email == '') {
            alert('Por favor no dejar espacios en blanco');
            return;
        }

        // Validar formato de email
        var email_regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email_regex.test(email)) {
            alert('Por Favor escriba un correo valido');
            return;
        }

        var url;
        if ($('#id').val() == '') {
            url = "<?php echo site_url('persons/create'); ?>";
        } else {
            url = "<?php echo site_url('persons/update'); ?>";
        }

        $.ajax({
            url: url,
            type: "POST",
            data: $('#personForm').serialize(),
            dataType: "JSON",
            success: function(data) {
                if (data.status) { // Si el servidor devuelve un estado exitoso
                    $('#personModal').modal('hide');
                    load_persons(); // Recargar la lista de personas
                } else {
                    alert(data.message || 'Error saving data');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error saving data');
            }
        });
    }

    function delete_person(id) {
        if (confirm('Estas apunto de borrar un registro, estas seguro?')) {
            $.ajax({
                url: "<?php echo site_url('persons/delete/'); ?>" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    load_persons();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error deleting data');
                }
            });
        }
    }

    function logout() {
        $.ajax({
            url: "<?php echo site_url('login/logout'); ?>",
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                window.location.replace("<?php echo site_url('login'); ?>");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error logging out');
            }
        });
    }
    </script>
</body>
</html>
