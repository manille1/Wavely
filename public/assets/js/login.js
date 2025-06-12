document.addEventListener("DOMContentLoaded", () => {
    choiceBtn = document.querySelector('#choice_auth_btn')
    logBtn = document.querySelector('.log_btn')
    regiBtn = document.querySelector('.register_btn')

    loginForm = document.querySelector('.login_form_div')
    registerForm = document.querySelector('.register_form_div')


    loginForm.style.display = "none"
    registerForm.style.display = "none"

    logBtn.addEventListener('click', () => {
        choiceBtn.style.display = "none"
        registerForm.style.display = "none"
        loginForm.style.display = "flex"
    })

    regiBtn.addEventListener('click', () => {
        choiceBtn.style.display = "none"
        loginForm.style.display = "none"
        registerForm.style.display = "flex"
    })
});