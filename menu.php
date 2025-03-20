<div class="row">
    <div class="col-md-8">
        <h2 class="text-primary">Bienvenido al Panel Seguro</h2>

</div>
<div class="col-md-2">
      

<p>Usuario: <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>

</div>

<div class="col-md-2">
  
    Rol: <strong><?= htmlspecialchars($_SESSION['rol']) ?></strong></p>

    
</div>

</div>

   <div class="d-flex justify-content-center mt-4 border-1 border-primary pb-2 pt-2 border-top border-bottom">
    <a href="agregar.php" class="btn btn-primary mx-2">➕ Agregar Factura</a>
    <a href="facturas.php" class="btn btn-secondary mx-2">📄 Ver Facturas</a>
    <a href="dashboard.php" class="btn btn-secondary mx-2 ">🔙 Volver al Dashboard</a>
     <a href="logout.php" class="btn btn-danger mx-5 ">Cerrar sesión</a>

    <?php if ($_SESSION['rol'] === 'admin'): ?>
        <a href="register.php" class="btn btn-success mx-5 ">Registrar</a>
        <a href="admin.php" class="btn btn-warning ">⚙️ Admin Panel</a>
    <?php endif; ?>
</div>
