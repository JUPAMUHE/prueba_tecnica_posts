<div class="container">
    <table class="table table-bordered" id="postTable">
        <thead>
            <tr style="text-align: center;">
                <th>Nombre</th>
                <th>Autor</th>
                <th>Fecha de Creación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($posts) && !empty($posts)){
                    foreach ($posts as $post): ?>
                        <tr>
                            <td><?php echo html_escape($post['nombre']); ?></td>
                            <td><?php echo html_escape($post['autor']); ?></td>
                            <td><?php echo html_escape($post['fecha_creacion']); ?></td>
                            <td style="text-align: center;">
                                <button class="btn <?php echo $post['post_bookmark'] == 1 ? 'btn-warning' : 'btn-primary'; ?> bookmark-btn" data-post-id="<?php echo html_escape($post['id']); ?>">
                                    <i class="fas fa-bookmark"></i> Bookmark
                                </button>
                                <button class="btn btn-success bookmark-btn-ver" data-post-id="<?php echo html_escape($post['id']); ?>" data-toggle="modal" data-target="#postUserModal"><i class="fa fa-eye" aria-hidden="true"></i> Ver</button>
                                <button class="btn btn-danger post-btn-eliminar" data-post-id="<?php echo html_escape($post['id']); ?>" ><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach;
                } else { ?>
                    <tr>
                        <td colspan="4">Sin datos cargados</td>
                    </tr>
            <?php }?>
        </tbody>
    </table>
</div>

