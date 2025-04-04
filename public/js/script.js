window.addEventListener("scroll", function () {
    let navbar = document.querySelector(".navbar");
    if (window.scrollY > 50) {
        navbar.classList.add("scrolled");
    } else {
        navbar.classList.remove("scrolled");
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const menuIcon = document.querySelector(".menu-icon");
    const menuContainer = document.getElementById("menu-container");

    menuIcon.addEventListener("click", function () {
        menuContainer.style.display = "flex";
    });

    // Đóng menu khi nhấp ra ngoài
    menuContainer.addEventListener("click", function (event) {
        if (event.target === menuContainer) {
            menuContainer.style.display = "none";
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const submenu = document.querySelector(".submenu");
    const dropdown = submenu.querySelector(".dropdown");
    const icon = submenu.querySelector("i");

    submenu.addEventListener("click", function (event) {
        event.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ `<a>`

        dropdown.classList.toggle("active");
        icon.classList.toggle("fa-angle-up");
        icon.classList.toggle("fa-angle-down");
    });
});


const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
  container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
  container.classList.remove("active");
});



function handleAuth(action) {
    let url = '/mywebsite/public/index.php?controller=login&action=index';
    
    // Nếu là register, thêm tham số `form=register`
    if (action === 'register') {
        url += '&form=register';
    }

    window.location.href = url;
}
