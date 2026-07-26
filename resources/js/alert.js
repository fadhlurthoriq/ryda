import Swal from 'sweetalert2';

// Toast kecil di tengah atas — buat notifikasi sukses/gagal biasa
export function showToast(message, icon = 'success') {
    Swal.fire({
        toast: true,
        position: 'top',
        icon: icon,
        title: message,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: false,
        width: '300px',
        padding: '0.75em',
        customClass: {
            popup: 'text-sm',
        },
    });
}

// Modal konfirmasi — dipakai sebelum aksi berbahaya (delete, cancel, dll)
// Return: Promise<boolean> — true kalau user klik "Ya"
export function confirmAction({
    title = 'Anda yakin?',
    text = 'Aksi ini tidak bisa dibatalkan.',
    confirmButtonText = 'Ya, lanjutkan',
    icon = 'warning',
} = {}) {
    return Swal.fire({
        title,
        text,
        icon,
        showCancelButton: true,
        confirmButtonText,
        cancelButtonText: 'Batal',
        confirmButtonColor: '#4f46e5',
        cancelButtonColor: '#6b7280',
        reverseButtons: true,
    }).then((result) => result.isConfirmed);
}

// Hubungkan ke elemen global biar bisa dipanggil langsung dari atribut HTML (x-on, onclick, dll)
window.showToast = showToast;
window.confirmAction = confirmAction;