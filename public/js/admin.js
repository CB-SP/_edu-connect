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

/*login & register forms*/
const fileNomes = document.querySelectorAll('.fileNome')
const fotoAdmins = document.querySelectorAll('.fotoAdmin')
const fotoUsers = document.querySelectorAll('.fotoUser')

fotoAdmins.forEach(fotoAdmin => {
    fotoAdmin.addEventListener('change', () => {
        fileNomes.forEach(fileNome => {
            fileNome.textContent = fotoAdmin.files[0]?.name || 'Nenhu ficheiro selecionado'
        })
    })
})

fotoUsers.forEach(fotoUser => {
    fotoUser.addEventListener('change', () => {
        fileNomes.forEach(fileNome => {
            fileNome.textContent = fotoUser.files[0]?.name || 'Nenhum ficheiro selecionado'
        })
    })
})


/*logoFile & register forms through adminPage*/
const fileNames = document.querySelectorAll('.fileName')
const logoFiles = document.querySelectorAll('.logoFile')
const fotoFiles = document.querySelectorAll('.fotoFile')

logoFiles.forEach(logoFile => {
    logoFile.addEventListener('change', () => {
        fileNames.forEach(fileName => {
            fileName.textContent = logoFile.files[0]?.name || 'Nenhum ficheiro escolhido'
        })
    })
})

fotoFiles.forEach(fotoFile => {
    fotoFile.addEventListener('change', () => {
        fileNames.forEach(fileName => {
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
        const type = e.currentTarget.dataset.type

        if (type == "user") {
            const response = await fetch(`http://localhost/_edu-connect/admin/fetch_user/${id}`)
            const user = await response.json()

            document.querySelector('#userId').value = id
            document.querySelector('#userName').value = user.nome
            document.querySelector('#userPrimaryContact').value = user.contacto_1
            document.querySelector('#userSecundaryContact').value = user.contacto_2
            document.querySelector('#nifUser').value = user.nif
            document.querySelector('#emailUser').value = user.email
            document.querySelector('#current_photo').value = user.foto || ''
        } else {
            const response = await fetch(`http://localhost/_edu-connect/admin/fetch_school/${id}`)
            const school = await response.json()

            document.querySelector('#schoolName').value = school.nome
            document.querySelector('#schoolAddress').value = school.endereco
            document.querySelector('#primaryContact').value = school.contacto_1
            document.querySelector('#secundaryContact').value = school.contacto_2
            document.querySelector('#schoolId').value = id
        }

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
        overlayModal.classList.remove('active')
        document.body.classList.remove('no-scroll')
    })
})

editModais.forEach(editModal => {
    editModal.addEventListener('click', (e) => {
        e.stopPropagation()
    })
})



/*EDIT ADMIN MODAL*/
const editAdminBtn = document.querySelector('#btn-edit-info-admin')
const editAdminModal = document.querySelector('#edit-admin-modal')

editAdminBtn.addEventListener('click', (e) => {
    e.stopPropagation()
    editAdminModal.classList.add('show')
    document.body.classList.add('no-scroll')
    overlayModal.classList.add('active')

    dropActions.forEach(dropAction => {
        dropAction.classList.remove('drop')
    })
})