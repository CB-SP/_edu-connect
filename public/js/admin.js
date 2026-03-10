const dropButtons = document.querySelectorAll('.action-btn')
const dropActions = document.querySelectorAll('.drop-actions')

const usersAlternate = document.querySelector('#user-nav-link')
const schoolAlternate = document.querySelector('#school-nav-link')
const usersSection = document.querySelector('.users-section')
const schoolsSection = document.querySelector('.schools-section')

dropButtons.forEach(dropBtn => {
    dropBtn.addEventListener('click', (e) => {
        e.stopPropagation()

        dropActions.forEach(dropAction => {
            dropAction.classList.remove('drop')
        })

        const dropdown = dropBtn.nextElementSibling
        dropdown.classList.add('drop')
    })
})


document.addEventListener('click', (e) => {
    dropActions.forEach(dropAction => {
        dropAction.classList.remove('drop')
    })
})


/*ALTERNATE BETWEEN USERS AND SCHOOLS SECTIONS EFFECT*/

const tabs = document.querySelectorAll('.tab')
const contents = document.querySelectorAll('.tab-content')

tabs.forEach(tab => {
    tab.addEventListener('click', (e) => {
        tabs.forEach(tab => tab.classList.remove('active'))

        contents.forEach(content => content.classList.remove('active'))

        tab.classList.add('active')

        const target = document.getElementById(tab.dataset.target)
        target.classList.add('active')
    })
})

/*ACTIVED LINK EFFECT*/

const navItens = document.querySelectorAll('.nav-item')
navItens.forEach(navItem => {

    navItem.addEventListener('click', () => {

        navItens.forEach(n => n.classList.remove('visited'))

        navItem.classList.add('visited')
    })
})

/*INPUT FILE SHOW NAME*/

const fileNames = document.querySelectorAll('.fileName')
const logoFiles = document.querySelectorAll('.logoFile')
const fotoFiles = document.querySelectorAll('.fotoFile')
const fotoAdmins = document.querySelectorAll('.fotoAdmin')
const fotoUsers = document.querySelectorAll('.fotoUser')

logoFiles.forEach(logoFile => {
    logoFile.addEventListener('change', () => {
        fileNames.forEach(fileName => {
            fileName.textContent = logoFile.files[0]?.name || 'Nenhum ficheiro escolhido'
        })
    })
})

fotoFiles.forEach(fotoFile=>{
    fotoFile.addEventListener('change', ()=>{
        fileNames.forEach(fileName=>{
            fileName.textContent = fotoFile.files[0]?.name || 'Nenhum ficheiro escolhido'
        })
    })
})

/*OPEN & CLOSE ADD MODAL*/

const addBtns = document.querySelectorAll('.add-button')
const closeModalIcons = document.querySelectorAll('.close-modal-icon')
const addModais = document.querySelectorAll('.add-modal')

const overlayModal = document.querySelector('.overlay-modal')


/*ADD CLICKING ON THE BUTTON*/
addBtns.forEach(addBtn => {
    addBtn.addEventListener('click', (e) => {
        e.stopPropagation()
        addModais.forEach(addModal => {
            addModal.classList.add('show')
            document.body.classList.add('no-scroll')
            addModal.classList.remove('no-scroll')
            overlayModal.classList.add('active')
        })
    })

})

/*REMOVE CLICKING ON THE CLOSE ICON*/
closeModalIcons.forEach(closeModalIcon => {
    closeModalIcon.addEventListener('click', (e) => {
        e.stopPropagation()
        addModais.forEach(addModal => {

            addModal.classList.remove('show')
            document.body.classList.remove('no-scroll')
            overlayModal.classList.remove('active')

        })
    })
})

/*REMOVE CLICKING ON ENTIRE SCREEN*/
document.addEventListener('click', () => {
    addModais.forEach(addModal => {

        addModal.classList.remove('show')
        document.body.classList.remove('no-scroll')
        overlayModal.classList.remove('active')
    })
})
/*PREVENT PROPAGATION ON MODAL*/
addModais.forEach(m => {
    m.addEventListener('click', (e) => {
        e.stopPropagation()
    })
})


/*OPEN & CLOSE EDIT MODAL*/
const editBtns = document.querySelectorAll('.edit-action')
editModais = document.querySelectorAll('.edit-modal')

editBtns.forEach(editBtn => {
    editBtn.addEventListener('click', async (e) => {
        e.stopPropagation()

        const id = e.currentTarget.dataset.id

        //document.getElementById('id').value = id
        //document.getElementById('schoolName').value = id

        const result = await fetch(`http://localhost/_edu-connect/admin/fetch_school/${id}`)
        //const data = await result.json()

        //console.log(data)
        const text = await result.text()
        console.log(text)

        editModais.forEach(editModal => {
            editModal.classList.add('show')
            document.body.classList.add('no-scroll')
            overlayModal.classList.add('active')

            dropActions.forEach(dropAction => {
                dropAction.classList.remove('drop')
            })
        })
    })
})

closeModalIcons.forEach(closeModalIcon => {
    closeModalIcon.addEventListener('click', (e) => {
        e.stopPropagation()

        editModais.forEach(editModal => {
            editModal.classList.remove('show')
            document.body.classList.remove('no-scroll')
            overlayModal.classList.remove('active')
        })
    })
})

document.body.addEventListener('click', () => {
    editModais.forEach(editModal => {
        editModal.classList.remove('show')
    })
})

editModais.forEach(editModal => {
    editModal.addEventListener('click', (e) => {
        e.stopPropagation()
    })
})