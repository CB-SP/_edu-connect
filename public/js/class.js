const btnNewClass = document.querySelector('.btn-new-class')
const classModal = document.querySelector('.class-modal')
const overlayClass = document.querySelector('.overlay-class')
const btnClose = document.querySelector('.close-icon-btn')

btnNewClass.addEventListener('click', ()=>{
    classModal.classList.add('showC')
    overlayClass.classList.add('activeOverlayClass')
})

btnClose.addEventListener('click', ()=>{
    classModal.classList.remove('showC')
    overlayClass.classList.remove('activeOverlayClass')
})

overlayClass.addEventListener('click', ()=>{
    classModal.classList.remove('showC')
    overlayClass.classList.remove('activeOverlayClass')
})


