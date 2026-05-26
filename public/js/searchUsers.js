const input = document.getElementById('searchUser')
const results = document.getElementById('usersResults')
const school = document.getElementById('schoolId').value
const role = document.getElementById('userRole').value
const type = document.getElementById('type').value
const url = document.getElementById('url').value

let timeout

input.addEventListener('input', () => {

    clearTimeout(timeout)

    timeout = setTimeout(async () => {

        const term = input.value.trim()

        try {

            const response = await fetch(
                `${url}user/search_school_users/${encodeURIComponent(term)}/${encodeURIComponent(school)}/${encodeURIComponent(role)}`
            )

            const data = await response.json()

            renderUsers(data.users)

        } catch (error) {
            console.log(error)
        }

    }, 300)

});

function renderUsers(users) {
    if (!users || users.length === 0) {
        results.innerHTML = `<p>Nenhum usuário encontrado.</p>`
        return
    }

    if (type === 'generalSearch') {
        let html = `
            <table class="tbl-users">
                <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>Contacto</th>
                        <th>Estado</th>
                        <th>Acções</th>
                    </tr>
                </thead>
                <tbody>
        `

        users.forEach(user => {

            const isInactive = user.deleted_at !== null
            const role = user.coordinator_role ?? user.role
            const status = isInactive ? 'Inactivo' : 'Activo'

            html += `
                    <tr>
                        <td>${user.nome}</td>
                        <td>${user.contacto_1}</td>
                        <td>${status}</td>

                        <td class="btn-down-actions">
                            <button class="action-btn">Acções</button>

                            <div class="drop-actions">

                                ${isInactive ? `
                                    <button class="restore-action"
                                        onclick="window.location.href='/_edu-connect/admin/restore_user/${user.id}'">
                                        Restaurar
                                    </button>
                                ` : `
                                    <button class="edit-action"
                                        data-id="${user.id}"
                                        data-type="user">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-icon lucide-pencil">
                                            <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                            <path d="m15 5 4 4" />
                                        </svg>
                                        Editar
                                    </button>

                                    <button class="delete-action"
                                        onclick="window.location.href='/_edu-connect/admin/delete_user/${user.id}'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2">
                                            <path d="M10 11v6" />
                                            <path d="M14 11v6" />
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                            <path d="M3 6h18" />
                                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                        </svg>
                                        Eliminar
                                    </button>
                                `}

                            </div>
                        </td>
                    </tr>
                `
        })

        html += `
                    </tbody>
                </table>
            `

        results.innerHTML = html
    } else {
        let html = ``

        users.forEach(user => {
            html += `
                <div class="student-item" >
                    <div class="info-student">
                        <div class="student-profile">
                            ${user.foto !== "null" ?
                                    `<img src="${url}public/${user.foto}">`
                                :
                                    `<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-user-round-icon lucide-circle-user-round">
                                        <path d="M17.925 20.056a6 6 0 0 0-11.851.001" />
                                        <circle cx="12" cy="11" r="4" />
                                        <circle cx="12" cy="12" r="10" />
                                    </svg>`
                            }
                        </div>
                        <div class="student-name-email">
                            <h4>${user.nome}</h4>
                            <p>${user.email}</p>
                        </div>
                    </div>
                    <button class="student-action add">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-plus-icon lucide-user-plus">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <line x1="19" x2="19" y1="8" y2="14" />
                            <line x1="22" x2="16" y1="11" y2="11" />
                        </svg>


                        <p>Adicionar</p>
                    </button>
                </div>
            `

            results.innerHTML = html
        })
    }
}