<div class="profile-section">
    <div class="user-image">
        <h2><?php echo '<span class="profile-picture">'.getProfilePicture($user['username']) .'</span>'?></h2>
    </div>
    <div class="user">
        <?php echo '<a href="profile.php?user='.$user['username'].'">'.$user['username'].'</a>' ?>
    </div>

    <div class="nav">
        <a href="index.php">Feed</a>
        
        <a href="index.php?page=explore">Explore</a>
        <?php 
            if($user['role'] == 'ADMIN'){
                echo '<a href="index.php?page=administrationPanel">Panel de administración</a>';
            }
        ?>
        <a href="logout.php">Cerrar sesión</a>
    </div>
</div>