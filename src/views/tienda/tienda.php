<!DOCTYPE html>
<html>
	<head>		
		<meta charset="utf-8" />
		<title>RapiExpress </title>
		<link rel="icon" href="assets\img\logo-rapi.ico" type="image/x-icon">		
		<meta name="viewport"content="width=device-width, initial-scale=1, maximum-scale=1"/>		
		
	
	</head>
	<body>		 

		<?php include 'src\views\layout\barras.php'; ?>
		
		<div class="mobile-menu-overlay"></div>

		<div class="main-container">
			<div class="xs-pd-20-10 pd-ltr-20">
				<div class="title pb-20">
					<div class="page-header">
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="title">
									<h4>Tiendas</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="index.php?c=dashboard&a=index">RapiExpress</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
											Tiendas
										</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
					<h2 class="h3 mb-0">Tiendas</h2>
				</div>
				
		


<div class="card-box mb-30">
    <div class="pd-30">
        <h4 class="text-blue h4">Lista de Tiendas</h4>
         <?php if (isset($_SESSION['mensaje']) && isset($_SESSION['tipo_mensaje'])): ?>
    <div class="alert alert-<?php echo $_SESSION['tipo_mensaje'] === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['mensaje']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>
<?php endif; ?>
        <div class="pull-right">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tiendaModal">
                <i class="fa fa-store"></i> Agregar Tienda
            </button>
        </div>
    </div>
    <div class="pb-30">
        <table class="data-table table stripe hover nowrap" id="tiendasTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tracking</th>
                    <th>Nombre</th>                    
                    <th class="datatable-nosort">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tiendas as $tienda): ?>
                <tr>
                    <td><?= htmlspecialchars($tienda['id_tienda']) ?></td>
                    <td><?= htmlspecialchars($tienda['tracking']) ?></td>
                    <td class="table-plus"><?= htmlspecialchars($tienda['nombre_tienda']) ?></td>                   
                       
                    
                    <td>
                        <div class="dropdown">
                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" data-toggle="dropdown">
                                <i class="dw dw-more"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#view-tienda-modal-<?= $tienda['id_tienda'] ?>">
                                    <i class="dw dw-eye"></i> Ver Detalles
                                </a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-tienda-modal-<?= $tienda['id_tienda'] ?>">
                                    <i class="dw dw-edit2"></i> Editar
                                </a>
									<a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete-tienda-modal" 
  								 onclick="setDeleteId(<?= $tienda['id_tienda'] ?>)">
  				 					<i class="dw dw-delete-3"></i> Eliminar
								</a>

                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Agregar Tienda -->
<div class="modal fade" id="tiendaModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="index.php?c=tienda&a=registrar">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Nueva Tienda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nombre de la Tienda</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nombre_tienda" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tracking</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="tracking" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrar Tienda</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($tiendas as $ti): ?>
<!-- Modal Ver Detalles -->
<div class="modal fade" id="view-tienda-modal-<?= $ti['id_tienda'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detalles de la Tienda</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">ID</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="<?= $ti['id_tienda'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tracking</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="<?= $ti['tracking'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nombre</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="<?= $ti['nombre_tienda'] ?>" readonly>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="edit-tienda-modal-<?= $ti['id_tienda'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="index.php?c=tienda&a=editar">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Tienda</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_tienda" value="<?= $ti['id_tienda'] ?>">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nombre</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nombre_tienda" value="<?= $ti['nombre_tienda'] ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tracking</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="tracking" value="<?= $ti['tracking'] ?>" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>


<div class="modal fade" id="delete-tienda-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="index.php?c=tienda&a=eliminar" id="delete-tienda-form">
                <div class="modal-body text-center font-18">
                    <h4 class="padding-top-30 mb-30 weight-500">¿Está seguro que desea eliminar esta tienda?</h4>
                    <p class="text-danger">Esta acción no se puede deshacer y eliminará todos los datos asociados.</p>
                    <input type="hidden" name="id_tienda" id="delete_tienda_id">
                    <div id="delete-error-message" class="alert alert-danger d-none mb-3"></div>
                    <div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto">
                        <div class="col-6">
                            <button type="button" class="btn btn-secondary border-radius-100 btn-block" data-dismiss="modal">
                                <i class="fa fa-times"></i> NO
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-danger border-radius-100 btn-block" id="confirm-delete">
                                <i class="fa fa-check"></i> SI
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

 <script>
function setDeleteId(id) {
    document.getElementById('delete_tienda_id').value = id;
}
</script>





				
				<div class="footer-wrap pd-20 mb-20 card-box">
					RapiExpress © 2025 - Sistema de Gestión de Paquetes				
				</div>
			</div>
		</div>
	 
	 
		 
	</body>
</html>
