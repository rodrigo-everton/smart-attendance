// Modal Logic
const modal = document.getElementById('info-modal');
const modalBody = document.getElementById('modal-body');
const modalTitle = document.getElementById('modal-title');
const modalContent = document.getElementById('modal-content-container');

// Security: Prevent XSS
function escapeHtml(unsafe) {
    if (unsafe === null || unsafe === undefined) return '';
    return String(unsafe)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function openModal(type, data) {
    let content = '';
    let title = '';

    const renderMaterias = (materias) => {
        if (!materias || materias.length === 0) {
            return '<p class="text-gray-400 italic">Nenhuma matéria vinculada.</p>';
        }
        return `
            <div class="mt-4">
                <p class="text-sm text-gray-500 uppercase font-semibold mb-2">Matérias Matriculadas</p>
                <div class="flex flex-wrap gap-2">
                ${materias.map(m => `
                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-blue-400">
                        ${escapeHtml(m.nome)}
                    </span>
                `).join('')}
                </div>
            </div>
        `;
    };

    const renderProfessores = (professores) => {
        if (!professores || professores.length === 0) {
            return '<p class="text-gray-400 italic text-xs">Sem professores vinculados.</p>';
        }
        return `
            <div class="mt-4">
                <p class="text-sm text-gray-500 uppercase font-semibold mb-2">Professores</p>
                <div class="flex flex-wrap gap-2">
                ${professores.map(p => `
                    <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-indigo-400">
                        ${escapeHtml(p.nome)}
                    </span>
                `).join('')}
                </div>
            </div>
        `;
    };

    if (type === 'professor') {
        title = '👨‍🏫 Detalhes do Professor';
        content = `
            <div class="grid grid-cols-1 gap-4">
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-sm text-gray-500 uppercase font-semibold">Nome</p>
                    <p class="text-lg font-medium text-gray-900">${escapeHtml(data.nome)}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-sm text-gray-500 uppercase font-semibold">Email</p>
                    <p class="text-lg font-medium text-gray-900">${escapeHtml(data.email)}</p>
                </div>
                 <div class="bg-gray-50 p-4 rounded-xl border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500 uppercase font-semibold">CPF</p>
                    <p class="text-lg font-medium text-gray-900 font-mono tracking-wide">${escapeHtml(data.cpf)}</p>
                </div>
                ${renderMaterias(data.materias)}
            </div>
        `;
    } else if (type === 'aluno') {
        title = '🧑‍🎓 Detalhes do Aluno';
        content = `
            <div class="grid grid-cols-1 gap-4">
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-sm text-gray-500 uppercase font-semibold">Nome</p>
                    <p class="text-lg font-medium text-gray-900">${escapeHtml(data.nome)}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-sm text-gray-500 uppercase font-semibold">Email</p>
                    <p class="text-lg font-medium text-gray-900">${escapeHtml(data.email)}</p>
                </div>
                <div class="flex gap-4">
                    <div class="bg-gray-50 p-4 rounded-xl w-1/2 border-l-4 border-purple-500">
                        <p class="text-sm text-gray-500 uppercase font-semibold">RA</p>
                        <p class="text-lg font-medium text-gray-900 font-mono">${escapeHtml(data.ra)}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl w-1/2">
                        <p class="text-sm text-gray-500 uppercase font-semibold">CPF</p>
                        <p class="text-lg font-medium text-gray-900 font-mono">${escapeHtml(data.cpf)}</p>
                    </div>
                </div>
                ${renderMaterias(data.materias)}
            </div>
        `;
    } else if (type === 'materia') {
        title = '📚 Detalhes da Matéria';
        content = `
            <div class="grid grid-cols-1 gap-4">
                <div class="bg-gray-50 p-4 rounded-xl border-l-4 border-teal-500">
                    <p class="text-sm text-gray-500 uppercase font-semibold">Matéria</p>
                    <p class="text-xl font-bold text-gray-900">${escapeHtml(data.nome)}</p>
                </div>
                 <div class="flex gap-4">
                     <div class="bg-gray-50 p-4 rounded-xl w-1/2">
                        <p class="text-sm text-gray-500 uppercase font-semibold">Carga Horária</p>
                        <p class="text-lg font-medium text-gray-900">${escapeHtml(data.carga_horaria)}h</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl w-1/2">
                        <p class="text-sm text-gray-500 uppercase font-semibold">Sala</p>
                        <p class="text-lg font-medium text-gray-900">${escapeHtml(data.sala)}</p>
                    </div>
                </div>
                
                <p class="text-sm text-gray-500 uppercase font-semibold mt-2">Disponibilidade de Horários</p>
                <div class="grid grid-cols-3 gap-2 text-center">
                    <div class="p-3 rounded-xl border ${data.horario_matutino ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200 opacity-50'}">
                        <p class="text-xs ${data.horario_matutino ? 'text-green-700' : 'text-red-700'} uppercase font-bold">Matutino</p>
                        <p class="font-mono text-gray-800 text-sm mt-1">${escapeHtml(data.horario_matutino || 'Inativo')}</p>
                    </div>
                     <div class="p-3 rounded-xl border ${data.horario_vespertino ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200 opacity-50'}">
                        <p class="text-xs ${data.horario_vespertino ? 'text-green-700' : 'text-red-700'} uppercase font-bold">Vespertino</p>
                        <p class="font-mono text-gray-800 text-sm mt-1">${escapeHtml(data.horario_vespertino || 'Inativo')}</p>
                    </div>
                     <div class="p-3 rounded-xl border ${data.horario_noturno ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200 opacity-50'}">
                        <p class="text-xs ${data.horario_noturno ? 'text-green-700' : 'text-red-700'} uppercase font-bold">Noturno</p>
                        <p class="font-mono text-gray-800 text-sm mt-1">${escapeHtml(data.horario_noturno || 'Inativo')}</p>
                    </div>
                </div>
                ${renderProfessores(data.professores)}
            </div>
        `;
    }

    modalTitle.innerHTML = title;
    // ... rest of logic remains same
    modalBody.innerHTML = content;
    modal.classList.remove('hidden');
    setTimeout(() => {
        modalContent.classList.remove('scale-95');
        modalContent.classList.add('scale-100');
    }, 10);
}

function closeModal() {
    modalContent.classList.remove('scale-100');
    modalContent.classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 200);
}

// Close on backdrop click
modal.addEventListener('click', (e) => {
    if (e.target === modal) closeModal();
});
