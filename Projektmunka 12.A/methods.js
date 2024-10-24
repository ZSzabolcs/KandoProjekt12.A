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
    const editorContent = document.getElementById("blog").innerHTML;
    document.getElementById("content").value = editorContent;

    //Ellenőrizzük, hogy a tartalom sikeresen átkerült-e a rejtett mezőbe
    if (document.getElementById('content').value) {
        // Ha van tartalom, a form elküldhető
        return true; // Form küldése
    } else {
        // Ha nincs tartalom, ne küldje el a formot
        alert("Kérlek, adj meg valamilyen tartalmat!");
        return false; // Form küldésének megakadályozása
    }
}