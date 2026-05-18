const sidebar = document.querySelector('.sideBar')
const overlay = document.querySelector('.overlay')
const openMenu = document.querySelector('.open-menu')
const closeMenu = document.querySelector('#close-menu')
const body = document.body


openMenu.addEventListener('click', () => {
    if (sidebar.classList.contains('open')) {
        sidebar.classList.remove('open')
        overlay.classList.remove('active')
        body.classList.remove('noScroll')
    } else {
        sidebar.classList.add('open')
        overlay.classList.add('active')
        body.classList.add('noScroll')
    }
})

overlay.addEventListener('click', () => {
    if (overlay.classList.contains('active')) {
        overlay.classList.remove('active')
        sidebar.classList.remove('open')
        body.classList.remove('noScroll')
    } else {
        overlay.classList.add('active')
        sidebar.classList.add('open')
        body.classList.add('noScroll')

    }
})

closeMenu.addEventListener('click', () => {
    if (overlay.classList.contains('active')) {
        overlay.classList.remove('active')
        sidebar.classList.remove('open')
        body.classList.remove('noScroll')

    } else {
        overlay.classList.add('active')
        sidebar.classList.add('open')
        body.classList.add('noScroll')

    }
})

