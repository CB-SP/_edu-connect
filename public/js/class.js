const btnNewClass = document.querySelector('.btn-new-class')
const classModal = document.querySelector('.class-modal')
const overlayClass = document.querySelector('.overlay-class')
const btnClose = document.querySelector('.close-icon-btn')

if (btnNewClass) {
    btnNewClass.addEventListener('click', () => {
        classModal.classList.add('showC')
        overlayClass.classList.add('activeOverlayClass')
    })

}

if (btnClose) {
    if (classModal) {
        btnClose.addEventListener('click', () => {
            classModal.classList.remove('showC')
            overlayClass.classList.remove('activeOverlayClass')
        })
    }
}
if (overlayClass) {
    overlayClass.addEventListener('click', () => {
        classModal.classList.remove('showC')
        overlayClass.classList.remove('activeOverlayClass')
    })
}

