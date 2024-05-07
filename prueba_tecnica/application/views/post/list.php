 <!DOCTYPE html>
 <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Listado de Posts</title>
        <head>
        <title>Dashboard</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" crossorigin="anonymous">

    </head>
    </head>
    <body>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Post</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item d-flex">
                        <p class="nav-link mr-3"><i class="fa fa-user-circle" aria-hidden="true"></i> <?php echo $username;?></p>
                        <a class="nav-link" href="<?= site_url('auth/logout'); ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar Sesión</a>
                    </li>
                </ul>
            </div>

        </nav>

        <div class="container mt-4">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Listado de Elementos</h2>
                </div>
                <div class="col-sm-6 text-right">
                    <button id="open-modal" class="btn btn-success" data-toggle="modal" data-target="#addElementModal"><i class="fa fa-plus" aria-hidden="true"></i> Crear Elemento</button>
                </div>
            </div>
        </div>
        <div class="container mt-4">
            <div class="row" id="item-list">
                
            </div>
        </div>

        <!-- Modal para agregar elemento -->
        <div class="modal fade" id="addElementModal" tabindex="-1" role="dialog" aria-labelledby="addElementModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addElementModalLabel">Agregar Elemento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="add-item-form">
                            <div class="form-group">
                                <label for="name">Nombre:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="author">Autor:</label>
                                <input type="text" class="form-control" id="author" name="author" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" id="save-item" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para mostrar la información del usuario y del post -->
        <div class="modal fade" id="postUserModal" tabindex="-1" role="dialog" aria-labelledby="postUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="postUserModalLabel">Usuarios Favoritos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="postUserInfo">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

       <script>
            $(document).ready(function(){
                // Función para cargar el listado al cargar la página
                loadItemList();

                //Para guardar bookmark
                $(document).on('click', '.bookmark-btn', function(){
                    var post_id = $(this).data('post-id');
                    $.ajax({
                        url: '<?= site_url('items/save_bookmark'); ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            post_id: post_id
                        },
                        success: function(response) {
                            if(response.success==0){
                                alert('¡Ya lo ha elegido como favorito!');

                            }else if (response.success) {
                                alert('Post guardado como favorito');
                            } else {
                                alert('Error al guardar el post');
                            }
                        },
                        error: function() {
                            alert('Error de conexión');
                        }
                    });
                });

                //Para ver la informacion de bookmark
                $(document).on('click', '.bookmark-btn-ver', function(){
                    var post_id = $(this).data('post-id');
                    $.ajax({
                        url: '<?= site_url('items/view_bookmark'); ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            post_id: post_id
                        },
                        success: function(response) {
                            if(response.data != false && response.data != 'false'){
                                var userInfo = '<p class="mb-2">Lista de Usuarios/Favoritos:</p><table class="table table-bordered">';
    
                                userInfo += '<thead><tr><th>Usuario</th><th>Fecha de Creación</th></tr></thead><tbody>';
                                
                                response.data.forEach(function(user) {
                                    userInfo += '<tr><td>' + user.usuario_nombre + '</td><td>' + user.fecha_creacion + '</td></tr>';
                                });

                                userInfo += '</tbody></table>';
                                
                                $('#postUserInfo').html(userInfo);
                            }else{
                                $('#postUserInfo').html('<p class="text-muted">Ningun usuario lo ha selecionado como favorito.</p>');
                            }
                            
                        },
                        error: function() {
                            alert('Error de conexión');
                        }
                    });
                });

            });

            //Para guardar post
            $('#save-item').click(function(){
                var name = $('#name').val();
                var author = $('#author').val();
                if(name == '' || author == ''){
                    alert('Debe rellenar todos los datos');
                    return false;
                }

                $.ajax({
                    url: '<?= site_url('items/save'); ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        name: name,
                        author: author
                    },
                    success: function(response) {
                        if (response.success) {
                            loadItemList();
                            $('#addElementModal').modal('hide');
                            $('#add-item-form')[0].reset();
                        } else {
                            alert('Error al guardar el elemento');
                        }
                    },
                    error: function() {
                        alert('Error de conexión');
                    }
                });
            });

            function loadItemList() {
                $.ajax({
                    url: '<?= site_url('items/get_items'); ?>',
                    type: 'GET',
                    dataType: 'html',
                    success: function(response) {
                        $('#item-list').html(response);
                        $('#postTable').DataTable();

                    },
                    error: function() {
                        alert('Error al cargar el listado de elementos');
                    }
                });
            }
          
        </script>
    </body>
    </html>
