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
