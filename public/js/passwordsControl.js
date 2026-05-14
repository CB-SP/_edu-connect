const btnHide = document.querySelector('.btn-hide-senha')

const lucideEyeOff = document.querySelector('.lucide-eye-off')
const lucideEye = document.querySelector('.lucide-eye')

btnHide.addEventListener('click', () => {
    input = btnHide.previousElementSibling
    if (lucideEyeOff.classList.contains('openEye')) {
        lucideEyeOff.classList.remove('openEye')
        input.type = "password"
    } else {
        lucideEyeOff.classList.add('openEye')
        input.type = "text"
    }

    if (lucideEye.classList.contains('closeEye')) {
        lucideEye.classList.remove('closeEye')
    } else {
        lucideEye.classList.add('closeEye')
    }
})

