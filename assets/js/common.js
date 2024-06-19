document.querySelector(".toggle_menu").addEventListener("click", () => {
    document.querySelector("header nav").classList.add("active");
});

document.querySelector("header nav").addEventListener("click", () => {
    document.querySelector("header nav").classList.remove("active");
});

document.querySelector("header nav ul").addEventListener("click", (event) => {
    event.stopPropagation();
});

document.querySelector("#popup_message").addEventListener("click", function (){
    this.classList.remove("active");
})