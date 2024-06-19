function swalConfirm(action, callback) {
    Swal.fire({
        title: `Apakah yakin untuk ${action}?`,
        text: `Tindakan akan meng${action} data ini`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            Swal.fire(
                'Batal',
                'Tindakan dibatalkan',
                'info'
            )
        }
    });
}

function swal(title, desc, icon = "") {
    Swal.fire({
        title: title,
        text: desc,
        icon: icon == "" ? "success" : icon
    });
}

function toast(desc, icon = "") {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.onmouseenter = Swal.stopTimer;
          toast.onmouseleave = Swal.resumeTimer;
        }
      });
      Toast.fire({
        icon: icon == "" ? "success" : icon,
        title: desc
      });
}