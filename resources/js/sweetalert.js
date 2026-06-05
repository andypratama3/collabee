import Swal from 'sweetalert2';

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
});

window.Swal = Swal;

document.addEventListener('livewire:init', () => {
    Livewire.on('swal:toast', (data) => {
        Toast.fire({
            icon: data.type || 'success',
            title: data.title || '',
        });
    });

    Livewire.on('swal:confirm', (data) => {
        Swal.fire({
            title: data.title || 'Are you sure?',
            text: data.text || '',
            icon: data.icon || 'warning',
            showCancelButton: true,
            confirmButtonColor: data.confirmButtonColor || '#6366f1',
            cancelButtonColor: data.cancelButtonColor || '#6b7280',
            confirmButtonText: data.confirmButtonText || 'Yes',
            cancelButtonText: data.cancelButtonText || 'Cancel',
        }).then((result) => {
            if (result.isConfirmed && data.callbackEvent) {
                Livewire.dispatch(data.callbackEvent, data.callbackData || {});
            }
        });
    });

    Livewire.on('swal:success', (data) => {
        Toast.fire({ icon: 'success', title: data.title || 'Berhasil!' });
    });

    Livewire.on('swal:error', (data) => {
        Toast.fire({ icon: 'error', title: data.title || 'Gagal!' });
    });

    Livewire.on('swal:info', (data) => {
        Toast.fire({ icon: 'info', title: data.title || '' });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const flashSuccess = document.body.dataset.flashSuccess;
    const flashError = document.body.dataset.flashError;
    const flashWarning = document.body.dataset.flashWarning;

    if (flashSuccess) Toast.fire({ icon: 'success', title: flashSuccess });
    if (flashError) Toast.fire({ icon: 'error', title: flashError });
    if (flashWarning) Toast.fire({ icon: 'warning', title: flashWarning });
});
