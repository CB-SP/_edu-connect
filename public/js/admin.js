

document.addEventListener('click', (e) => {

    const btn = e.target.closest('.action-btn');

    if (!btn) {
        document.querySelectorAll('.drop-actions')
            .forEach(el => el.classList.remove('drop'));
        return;
    }

    const parent = btn.closest('.btn-down-actions');
    const dropdown = parent?.querySelector('.drop-actions');

    if (!dropdown) return;

    document.querySelectorAll('.drop-actions.drop')
        .forEach(el => {
            if (el !== dropdown) el.classList.remove('drop');
        });

    dropdown.classList.toggle('drop');
});


const tabs = document.querySelectorAll('.tab');
const contents = document.querySelectorAll('.tab-content');

if (tabs.length) {
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {

            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));

            tab.classList.add('active');

            const target = document.getElementById(tab.dataset.target);
            if (target) target.classList.add('active');
        });
    });
}


const fileNomes = document.querySelectorAll('.fileNome');
const fileNames = document.querySelectorAll('.fileName');

const fotoAdmins = document.querySelectorAll('.fotoAdmin');
const fotoUsers = document.querySelectorAll('.fotoUser');
const logoFiles = document.querySelectorAll('.logoFile');
const fotoFiles = document.querySelectorAll('.fotoFile');

function updateFileName(input, targets, fallback) {
    input.addEventListener('change', () => {
        const name = input.files[0]?.name || fallback;
        targets.forEach(t => t.textContent = name);
    });
}

fotoAdmins.forEach(i => updateFileName(i, fileNomes, 'Nenhum ficheiro selecionado'));
fotoUsers.forEach(i => updateFileName(i, fileNomes, 'Nenhum ficheiro selecionado'));
logoFiles.forEach(i => updateFileName(i, fileNames, 'Nenhum ficheiro escolhido'));
fotoFiles.forEach(i => updateFileName(i, fileNames, 'Nenhum ficheiro escolhido'));


const addBtns = document.querySelectorAll('.add-button');
const closeModalIcons = document.querySelectorAll('.close-modal-icon');
const addModais = document.querySelectorAll('.add-modal');
const btnCancel = document.querySelectorAll('#btn-cancel');
const overlayModal = document.querySelector('.overlay-modal');

function closeAllAddModals() {
    addModais.forEach(m => {
        m.classList.remove('show');
    });

    document.body.classList.remove('no-scroll');
    overlayModal?.classList.remove('active');
}

if (addBtns.length) {
    addBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();

            addModais.forEach(m => m.classList.add('show'));

            document.body.classList.add('no-scroll');
            overlayModal?.classList.add('active');
        });
    });
}

if (closeModalIcons.length) {
    closeModalIcons.forEach(icon => {
        icon.addEventListener('click', closeAllAddModals);
    });
}

if (btnCancel.length) {
    btnCancel.forEach(btn => {
        btn.addEventListener('click', closeAllAddModals);
    });
}

document.addEventListener('click', closeAllAddModals);

addModais.forEach(m => {
    m.addEventListener('click', (e) => e.stopPropagation());
});


const editBtns = document.querySelectorAll('.edit-action');
const editModais = document.querySelectorAll('.edit-modal');

function closeEditModals() {
    editModais.forEach(m => m.classList.remove('show'));

    document.body.classList.remove('no-scroll');
    overlayModal?.classList.remove('active');
}


document.addEventListener('click', async (e) => {

    const btn = e.target.closest('.edit-action');

    if (!btn) return;

    e.stopPropagation();

    const id = btn.dataset.id;
    const type = btn.dataset.type;

    try {

        if (type === "user") {

            const response = await fetch(`${url}admin/fetch_user/${id}`);
            const user = await response.json();

            document.querySelector('#userId').value = id;
            document.querySelector('#userName').value = user.nome;
            document.querySelector('#userPrimaryContact').value = user.contacto_1;
            document.querySelector('#userSecundaryContact').value = user.contacto_2;
            document.querySelector('#nifUser').value = user.nif;
            document.querySelector('#emailUser').value = user.email;
            document.querySelector('#current_photo').value = user.foto || '';

        } else {

            const response = await fetch(`${url}admin/fetch_school/${id}`);
            const school = await response.json();

            document.querySelector('#schoolId').value = id;
            document.querySelector('#schoolName').value = school.nome;
            document.querySelector('#schoolAddress').value = school.endereco;
            document.querySelector('#primaryContact').value = school.contacto_1;
            document.querySelector('#secundaryContact').value = school.contacto_2;
            document.querySelector('#current_logo').value = school.logo || '';
        }

        editModais.forEach(m => m.classList.add('show'));

        document.body.classList.add('no-scroll');
        overlayModal?.classList.add('active');

    } catch (err) {
        console.log(err);
    }
});

if (closeModalIcons.length) {
    closeModalIcons.forEach(icon => {
        icon.addEventListener('click', closeEditModals);
    });
}

if (btnCancel.length) {
    btnCancel.forEach(btn => {
        btn.addEventListener('click', closeEditModals);
    });
}

document.body.addEventListener('click', closeEditModals);

editModais.forEach(m => {
    m.addEventListener('click', (e) => e.stopPropagation());
});


const editAdminBtn = document.querySelector('#btn-edit-info-admin');
const editAdminModal = document.querySelector('#edit-admin-modal');

if (editAdminBtn && editAdminModal) {
    editAdminBtn.addEventListener('click', (e) => {
        e.stopPropagation();

        editAdminModal.classList.add('show');
        document.body.classList.add('no-scroll');
        overlayModal?.classList.add('active');
    });
}