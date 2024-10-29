const blogs = document.getElementsByClassName("container blogbej my-2 py-2");

for (let i = 0; i < blogs.length; i++) {
    let place = blogs[i].childNodes[1];
    let txt_length = place.innerText.length;
    if (txt_length <= 454) {
        blogs[i].removeChild(blogs[i].lastChild);

    }
}

for (let i = 0; i < blogs.length; i++) {

    let button = blogs[i].querySelector(".more");
    button.onclick = function () {
        let isExpanded = this.getAttribute("aria-expanded") === "true";
        this.setAttribute("aria-expanded", isExpanded);

        if (!isExpanded) {
            blogs[i].appendChild(button);
            button.innerText = "Több";
        }
        else {
            blogs[i].appendChild(button);
            button.innerText = "Kevesebb";
        }
    };
}
