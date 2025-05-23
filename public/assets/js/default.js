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

function processWithQuestion(e, form) {
    e.preventDefault();
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Data yang sudah dirubah atau hapus tidak dapat dikembalikan lagi.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batalkan',
    }).then((result) => {
        if (result.isConfirmed) {
            var btn = form.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerHTML = 'Processing...';
            form.submit();
        }
    });

    return false;
}

function indoDateTime(dateTimeString) {
    const date = new Date(dateTimeString);
    const options = {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: false,
    };
    const parts = new Intl.DateTimeFormat('id-ID', options).formatToParts(date);
    const formattedDate = `${parts.find(p => p.type === 'day').value} ${parts.find(p => p.type === 'month').value} ${parts.find(p => p.type === 'year').value}`;
    const formattedTime = `${parts.find(p => p.type === 'hour').value}:${parts.find(p => p.type === 'minute').value}`;
    return formattedDate + ', ' + formattedTime;
}