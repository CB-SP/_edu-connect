const input = document.getElementById('searcClasses')
const results = document.getElementById('classResults')
const user = document.getElementById('userId').value
const role = document.getElementById('userRole').value
const url = document.getElementById('url').value

let timeout

input.addEventListener('input', () => {

    clearTimeout(timeout)

    timeout = setTimeout(async () => {

        const term = input.value.trim()

        try {

            if (role === 'professor') {
                const response = await fetch(
                    `${url}class/search_teachers_classes/${encodeURIComponent(term)}/${encodeURIComponent(user)}`
                )

                const data = await response.json();

                renderClasses(data.classes)
            } else {
                const response = await fetch(
                    `${url}class/search_students_classes/${encodeURIComponent(term)}/${encodeURIComponent(user)}`
                );

                const data = await response.json()

                renderClasses(data.classes)
            }

        } catch (error) {
            console.log(error)
        }

    }, 300)

})

function renderClasses(classes) {
    if (!classes || classes.length === 0) {
        results.innerHTML = `<p>Nenhuma turma encontrada.</p>`
        return
    }

    let html = ``

    classes.forEach(classs => {

        html += `
            <a href="${url}teacher/class/${classs.id}" class="class-card">
                <h3>${classs.class}</h3>

                <div class="prof-info">
                    <div class="prof-profile-img">

                        ${
                            classs.teacher_photo !== "null" ?
                                    `<img src="${url}public/${classs.teacher_photo}">`
                                :
                                    `<svg xmlns="http://www.w3.org/2000/svg"
                                        width="48"
                                        height="48"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.25"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-circle-user-round-icon lucide-circle-user-round">

                                        <path d="M17.925 20.056a6 6 0 0 0-11.851.001" />
                                        <circle cx="12" cy="11" r="4" />
                                        <circle cx="12" cy="12" r="10" />
                                    </svg>`
                        }

                    </div>

                    <h4>${classs.teacher}</h4>
                </div>

                <div class="students-info">

                    <div class="icon-students">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-users-icon lucide-users">

                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <path d="M16 3.128a4 4 0 0 1 0 7.744"/>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                            <circle cx="9" cy="7" r="4"/>

                        </svg>

                    </div>

                    <h4>
                        ${classs.students === 1
                            ? `${classs.students} aluno`
                            : `${classs.students} alunos`
                        }
                    </h4>

                </div>
            </a>
        `
    })

    results.innerHTML = html
}