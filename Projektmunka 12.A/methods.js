const Login = () => {
    const username_login = document.querySelector("#username1");
    const email_login = document.querySelector("#email1");
    const password_login = document.querySelector("#password1");
    if (username_login.value === "" || email_login.value === "" || password_login.value === ""){
        console.error("Add meg a szükséges adatokat!");
    }
    else sessionStorage.setItem("user", username_login.value);
}

const Regist = () => {
    const username_regist = document.querySelector("#username");
    const email_regist = document.querySelector("#email");
    const password_regist = document.querySelector("#password");
    if (username_regist.value === "" || email_regist === "" || password_regist === ""){
        console.error("Add meg a szükséges adatokat!");
    }
    else sessionStorage.setItem("user", username_regist.value);
}


const SubmitContent = () => {
    const editorContent = document.getElementById("blog").textContent;
    const blogTitle = document.getElementById("bl_title").textContent;

    // Ellenőrzés a konzolon, hogy a szövegek jól be lettek olvasva
    console.log("Blog title:", blogTitle);
    console.log("Blog content:", editorContent);

    // A rejtett input mezők értékeinek beállítása
    document.getElementById("content").value = editorContent;
    document.getElementById("title_bl").value = blogTitle;

    // Ellenőrizzük, hogy a tartalom sikeresen átkerült-e a rejtett mezőbe
    if (document.getElementById('content').value.trim() !== "" && document.getElementById("title_bl").value.trim() !== "") {
        // Ha van tartalom, a form elküldhető
        return true; // Form küldése
    } else {
        // Ha nincs tartalom, ne küldje el a formot
        alert("Kérlek, adj meg valamilyen tartalmat!");
        return false; // Form küldésének megakadályozása
    }
}
