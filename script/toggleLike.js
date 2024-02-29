function toggleLike(postId, user) {
    //Ajax request
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
            //Update the like count
            document.getElementById('likeCount_' + postId).innerHTML = xhr.responseText;

            //Ccurrent like button element
            var likeButton = document.querySelector('#likeButton_' + postId);

            likeButton.innerText = (likeButton.innerText === '💖') ? '💔' : '💖';
        }
    };
    xhr.open('POST', 'like_handler.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    //Send both the meow and the user
    var data = 'postId=' + postId + '&user=' + user;
    xhr.send(data);
}