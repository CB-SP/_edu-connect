const btnHide = document.querySelectorAll('.btn-hide-senha')

btnHide.forEach(btn => {
    btn.addEventListener('click', () => {
        input = btn.previousElementSibling
        eyeOffIcon = btn.querySelectorAll('.lucide-eye-off')
        eyeOffIcon.forEach(eyeOff => {
            if (eyeOff.classList.contains('openEye')) {
                eyeOff.classList.remove('openEye')
                input.type = "password"
            } else {
                eyeOff.classList.add('openEye')
                input.type = "text"
            }

        })

        eyeIcon = btn.querySelectorAll('.lucide-eye')
        eyeIcon.forEach(eye => {
            if (eye.classList.contains('closeEye')) {
                eye.classList.remove('closeEye')
            } else {
                eye.classList.add('closeEye')
            }

        })
    })

})

