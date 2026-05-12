const input = document.getElementById('searchUser')
const results = document.getElementById('usersResults')
const school = document.getElementById('schoolId').value
const role = document.getElementById('userRole').value
const type = document.getElementById('type').value ?? ''

let timeout

input.addEventListener('input', () => {

    clearTimeout(timeout)

    timeout = setTimeout(async () => {

        const term = input.value.trim()

        try {

            const response = await fetch(
                `http://localhost/_edu-connect/user/search_school_users/${encodeURIComponent(term)}/${encodeURIComponent(school)}/${encodeURIComponent(role)}`
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

    if (type === '') {
        let html = `
            <table class="tbl-users">
                <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>Escola</th>
                        <th>Função</th>
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
                        <td>${user.escola}</td>
                        <td>${role}</td>
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
                                        Editar
                                    </button>

                                    <button class="delete-action"
                                        onclick="window.location.href='/_edu-connect/admin/delete_user/${user.id}'">
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
                            <img src="" alt=" ">
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