function showSwal(status, message, isReload = false) {
    const swalOptions = {
        title: '',
        text: message,
        icon: '',
        timer: isReload ? 3000 : undefined,
        allowOutsideClick: false, // Prevent closing by clicking outside
    };

    switch (status) {
        case 'error':
            swalOptions.title = 'Upps!, Ada yang salah';
            swalOptions.icon = 'error';
            break;
        case 'success':
            swalOptions.title = 'Berhasil';
            swalOptions.icon = 'success';
            break;
        case 'warning':
            swalOptions.title = 'Peringatan';
            swalOptions.icon = 'warning';
            break;
        case 'info':
            swalOptions.title = 'Info';
            swalOptions.icon = 'info';
            break;
    }

    if (isReload) {
        swalOptions.timer = 2000;
        swalOptions.html = '<div>Tunggu Sebentar...</div>'; // Add custom text above loading icon
        swalOptions.didOpen = () => {
            Swal.showLoading(); // Show loading indicator
        };
        swalOptions.willClose = () => {
            location.reload(); // Reload the page
        };
    }

    Swal.fire(swalOptions); // Use Swal.fire instead of swal
}


function processDataWithLoading(form) {
    $.LoadingOverlay('show');
    var btn = form.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = 'Processing...';
    return true;
}

function processData(form) {
    var btn = form.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = 'Processing...';
    return true;
}