const loadingModal = new bootstrap.Modal('#loadingModal');
window.addEventListener('openLoading', () => {
    loadingModal.show();
});

window.addEventListener('closeLoading', () => {
    loadingModal.hide();
});
