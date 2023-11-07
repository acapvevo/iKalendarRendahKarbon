
function closeModal(modalElId) {
    const modal = document.getElementById(modalElId);

    modal.addEventListener('hide.bs.modal', event => {
        Livewire.emit('closeModal');
    })
}

function initEventModal(modalElId, openFunc, closeFunc){
    const modal = document.getElementById(modalElId);

    modal.addEventListener('show.bs.modal', openFunc)

    modal.addEventListener('hide.bs.modal', closeFunc)
}
