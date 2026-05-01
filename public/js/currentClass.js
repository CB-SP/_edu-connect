const tabsClass = document.querySelectorAll('.tab-class')

if (tabsClass) {
    tabsClass.forEach(tabClass => {
        tabClass.addEventListener('click', () => {
            tabsClass.forEach(t => t.classList.remove('activeClass'))
            tabClass.classList.add('activeClass')
        })
    })
}

const contentClass = document.querySelectorAll('.class-content')

contentClass.forEach(content => {
    tabsClass.forEach(tab => {
        tab.addEventListener('click', () => {
            contentClass.forEach(c => c.classList.remove('active'))
            const a = document.querySelector('.' + tab.dataset.currentClass)
            a.classList.add('active')

        })

    })
})


//MODAL MANAGE STUDENTS*/
const btn = document.querySelector('#btn-show-modal')
const iconClose = document.querySelector('#close-menu-m')
const btnCloseModal = document.querySelector('.btn-close-student-modal')
const modal = document.querySelector('.modal-students-list')
const overlayCurrentClas = document.querySelector('.overlay-current-class')

btn.addEventListener('click', () => {
    modal.classList.add('show')
    overlayCurrentClas.classList.add('activeOver')
})

iconClose.addEventListener('click', () => {
    modal.classList.remove('show')
    overlayCurrentClas.classList.remove('activeOver')
})

overlayCurrentClas.addEventListener('click', ()=> {
    modal.classList.remove('show')
    overlayCurrentClas.classList.remove('activeOver')
})

btnCloseModal.addEventListener('click', () => {
    modal.classList.remove('show')
    overlayCurrentClas.classList.remove('activeOver')
})
