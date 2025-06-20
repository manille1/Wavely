document.addEventListener("DOMContentLoaded", () => {
    const choiceBtn = document.querySelector('#choice_auth_btn')
    const logBtn = document.querySelector('.log_btn')
    const regiBtn = document.querySelector('.register_btn')

    const loginForm = document.querySelector('.login_form_div')
    const registerForm = document.querySelector('.register_form_div')

    const form = document.querySelector('form')
    const imageInput = document.querySelector('input[type="file"][name="photo"]')
    const maxSize = 2 * 1024 * 1024 //2 Mo


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

    form.addEventListener('submit', (e) => {
        const image = imageInput.files[0]
        if (image && image.size > maxSize){
            e.preventDefault()
            alert('Votre photo est trop lourde ! Le serveur n\'a pas d\'assez gros bras !')
        }
    })
});