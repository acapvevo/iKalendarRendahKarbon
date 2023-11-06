
function closeModal(modalElId) {
    const modal = document.getElementById(modalElId);

    modal.addEventListener('hide.bs.modal', event => {
        Livewire.emit('closeModal');
    })
}
