// Función para mostrar la sección de Posts y ocultar Explore
function showPosts() {
    document.getElementById('posts-section').style.display = 'block';
    document.getElementById('explore-section').style.display = 'none';
}

// Función para mostrar la sección de Explore y ocultar Posts
function showExplore() {
    document.getElementById('posts-section').style.display = 'none';
    document.getElementById('explore-section').style.display = 'block';
}

//Función para seguir a un usuario
function followUser(){
    document.getElementById('follow-section').style.display = 'none';
    document.getElementById('unfollow-section').style.display = 'block';
}

function unfollowUser(){
    document.getElementById('follow-section').style.display = 'block';
    document.getElementById('unfollow-section').style.display = 'none';
}

//Funcion para banear a un usuario
function banUser(){
    
}

//Función para hacer administrador a un usuario
function doAdmin(){
    
}
