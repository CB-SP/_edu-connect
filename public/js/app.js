const sidebar = document.querySelector('.sideBar')
const overlay = document.querySelector('.overlay')
const openMenu = document.querySelector('.open-menu')
const closeMenu = document.querySelector('#close-menu')
const body = document.body


openMenu.addEventListener('click', () => {
    if (sidebar.classList.contains('open')) {
        sidebar.classList.remove('open')
        overlay, classList.remove('active')
        body.classList.remove('no-scroll')
    } else {
        sidebar.classList.add('open')
        overlay.classList.add('active')
        body.classList.add('no-scroll')
    }
})

overlay.addEventListener('click', () => {
    if (overlay.classList.contains('active')) {
        overlay.classList.remove('active')
        sidebar.classList.remove('open')
        body.classList.remove('no-scroll')
    } else {
        overlay.classList.add('active')
        sidebar.classList.add('open')
        body.classList.add('no-scroll')

    }
})

closeMenu.addEventListener('click', () => {
    if (overlay.classList.contains('active')) {
        overlay.classList.remove('active')
        sidebar.classList.remove('open')
        body.classList.remove('no-scroll')

    } else {
        overlay.classList.add('active')
        sidebar.classList.add('open')
        body.classList.add('no-scroll')

    }
})


console.log(body)