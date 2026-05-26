const btnHide = document.querySelectorAll('.btn-hide-senha')

btnHide.forEach(btn => {
    btn.addEventListener('click', () => {
        let input = btn.previousElementSibling
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

// ADDING FORM MASKS
const inputs = document.querySelectorAll('.contact-input')
inputs.forEach(input => {
    input.addEventListener('input', () => {
        let valor = input.value
        valor = valor.replace(/[^\d+]/g, "")
     
        valor = valor.replace(/^\+?(\d{3})(\d{3})(\d{3})(\d{0,3}).*/,
            "+$1 $2 $3 $4"
        )
        input.value = valor.trim()
        
        //console.log('VALOR INPUT', valor)
    })
})