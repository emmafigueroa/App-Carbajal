if (document.getElementsByClassName("password").length) {
    const togglePassword = document.querySelector("#eye");
    const password = document.querySelector("#password");
  
    togglePassword.addEventListener("click", () => {
      const typePassword =
        password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", typePassword);
   
      togglePassword.classList.toggle("fa-eye");
      togglePassword.classList.toggle("fa-eye-slash");
    });
  }
  