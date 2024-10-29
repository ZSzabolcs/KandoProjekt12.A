const blogok = document.getElementsByClassName("container blogbej my-2 py-2");
let i = 0;
while (i < blogok.length) {
    let place = blogok[i].children[1];
    let txt_length = place.innerText.length;
    if (txt_length <= 454) {
        blogok[i].removeChild(blogok[i].lastChild);

    }
    i++;
}

document.getElementsByTagName("button").addEventListener("click", function() {
    let i = 0;
    let van = false;
    const blog = document.getElementsByClassName("container blogbej my-2 py-2");
    const button = document.getElementsByTagName("button");
    const container = document.getElementsByClassName("bevezeto");
    console.log(blog)
    console.log(button)
    console.log(container)
    console.log(container[i].lastChild)
    let hely = 0;
    while (!van && i < blog.length) {
        if (container[i].lastChild.id === `more${i}`) {
            hely = i;
            van = true;
        }
        i++;
    }
    console.log(hely)
    // A gomb áthelyezése a szülő elem végére
    blog[hely].appendChild(button[hely]);
    button[hely].innerText = "Kevesebb";
});
