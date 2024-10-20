const username_place = document.querySelector(".username");
const tipus = Object.prototype.toString.call(sessionStorage.getItem("user"));
if (tipus === "[object Null]"){
    location.replace("login.php");
}else {
username_place.innerHTML = `Üdvözöljük <i>${sessionStorage.getItem("user")}</i>!`;
}
/*
document.getElementById('imageUpload').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'image';
            img.style.width = '100px'; // Állítsd be a kívánt méretet
            img.style.top = '50px'; // Kezdeti pozíció
            img.style.left = '50px'; // Kezdeti pozíció
            img.draggable = true;

            img.addEventListener('dragstart', function(e) {
                const offsetX = e.clientX - img.getBoundingClientRect().left;
                const offsetY = e.clientY - img.getBoundingClientRect().top;
                e.dataTransfer.setData('text/plain', `${offsetX},${offsetY}`);
            });

            document.getElementById('imageContainer').appendChild(img);
        };
        reader.readAsDataURL(file);
    }
});

// Kép mozgatása
document.addEventListener('dragover', function(e) {
    e.preventDefault();
});

document.addEventListener('drop', function(e) {
    e.preventDefault();
    const img = e.target;
    if (img.classList.contains('image')) {
        const coords = e.dataTransfer.getData('text/plain').split(',');
        const offsetX = parseInt(coords[0], 10);
        const offsetY = parseInt(coords[1], 10);
        img.style.left = `${e.clientX - offsetX}px`;
        img.style.top = `${e.clientY - offsetY}px`;
    }
});
*/

