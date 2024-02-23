<div class="profile-section">
    <h2><?= $user['username'] ?></h2>

    <div class="nav">
        <a href="index.php">Feed</a>
        <a href="index.php?page=explore">Explore</a>
        <?php 
            if($user['role'] == 'ADMIN'){
                echo '<a href="index.php?page=administrationPanel">Panel de administración</a>';
            }
        ?>
    </div>

    <a href="logout.php">Cerrar sesión</a>
</div>
