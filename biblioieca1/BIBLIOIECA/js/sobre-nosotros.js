document.addEventListener("DOMContentLoaded", function () {
  const userMenu = document.querySelector(".user-menu");
  const userIcon = document.getElementById("userIcon");

  userIcon.addEventListener("click", () => {
    userMenu.classList.toggle("active");
  });

  document.addEventListener("click", (e) => {
    if (!userMenu.contains(e.target)) {
      userMenu.classList.remove("active");
    }
  });
});