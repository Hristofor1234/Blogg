document.querySelector("#switch_to_register").addEventListener("click", () => {
    document.querySelector(".login").classList.remove("active");
    document.querySelector(".register").classList.add("active");
});

document.querySelector("#switch_to_login").addEventListener("click", () => {
    document.querySelector(".register").classList.remove("active");
    document.querySelector(".login").classList.add("active");
});

