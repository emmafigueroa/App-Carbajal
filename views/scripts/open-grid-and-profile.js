window.addEventListener("click", (e) => {
  const grid = document.querySelector("#bxs-grid-alt");
  const menu = document.querySelector("#menu");

  if (grid.contains(e.target)) {
    menu.classList.toggle("open");
  } else {
    if (menu.contains(e.target)) {
    } else {
      menu.classList.remove("open");
      
    }
  }
});
