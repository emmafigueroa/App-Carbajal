if (
    document.getElementsByClassName("cautionEmail").length &&
    document.getElementsByClassName("cautionPassword").length
  ) {
    const inputEmail = document.querySelector("#email");
    const inputPassword = document.querySelector("#password");
  
    inputEmail.style.outline = "#ff4646 1px solid";
    inputEmail.style.outlineOffset = "4px";
  
    inputPassword.style.outline = "#ff4646 1px solid";
    inputPassword.style.outlineOffset = "4px";
  } else if (document.getElementsByClassName("cautionEmail").length) {
    const inputEmail = document.querySelector("#email");
  
    inputEmail.style.outline = "#ff4646 1px solid";
    inputEmail.style.outlineOffset = "4px";
  } else if (document.getElementsByClassName("cautionPassword").length) {
    const inputPassword = document.querySelector("#password");
  
    inputPassword.style.outline = "#ff4646 1px solid";
    inputPassword.style.outlineOffset = "4px";
  } 

  if (
    document.getElementsByClassName("cautionEmail").length &&
    document.getElementsByClassName("cautionPassword").length &&
    document.getElementsByClassName("cautionUser").length
  ) {
    const inputEmail = document.querySelector("#email");
    const inputPassword = document.querySelector("#password");
    const inputUser = document.querySelector("#user");
  
    inputEmail.style.outline = "#ff4646 1px solid";
    inputEmail.style.outlineOffset = "3px";
  
    inputPassword.style.outline = "#ff4646 1px solid";
    inputPassword.style.outlineOffset = "3px";

    inputUser.style.outline = "#ff4646 1px solid";
    inputUser.style.outlineOffset = "3px";
  } else if (document.getElementsByClassName("cautionEmail").length) {
    const inputEmail = document.querySelector("#email");
  
    inputEmail.style.outline = "#ff4646 1px solid";
    inputEmail.style.outlineOffset = "3px";
  } else if (document.getElementsByClassName("cautionPassword").length) {
    const inputPassword = document.querySelector("#password");
  
    inputPassword.style.outline = "#ff4646 1px solid";
    inputPassword.style.outlineOffset = "3px";
  } else if (document.getElementsByClassName("cautionUser").length) {
    const inputUser = document.querySelector("#user");
  
    inputUser.style.outline = "#ff4646 1px solid";
    inputUser.style.outlineOffset = "3px";
  } 