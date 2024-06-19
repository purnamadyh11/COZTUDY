$(function () {
    CKEDITOR.replace('ckeditor');
    let id = "";
    let flag_type = "";
    const table = $('.table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/admin/place',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'name', name: 'name' },
            { data: 'latitude', name: 'latitude' },
            { data: 'longitude', name: 'longitude' },
            { data: 'description_place', name: 'description_place' },
            { data: 'harga', name: 'harga' },
            { data: 'type_status', name: 'type_status' },
            { data: 'action', name: 'action' },
        ]
    });

    $('body').on('click', '.delete', function () {
        const id = $(this).data('id');
        swalConfirm("hapus", function () {
            $.ajax({
                url: `/admin/place/delete/${id}`,
                type: 'GET',
                success: function (res) {
                    if (res.code == 200) {
                        toast("Berhasil dihapus!");
                        table.draw();
                    } else {
                        swal("Oops", res.message, "error");
                    }
                }
            })
        });
    });

    $('body').on('click', '.add-detail', function () {
        let html = `<div class="mt-2 list-detail">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-1" style="width:40px">
                                    <button type="button" class="delete-detail btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="file" name="image[]" class="form-control image-input">
                                    </div>
                                    <div class="preview-container">
                                        <img class="preview-image" src="/back-office/img/blank.jpg" alt="Preview Image">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <textarea name="image_description[]" id="" class="form-control" placeholder="Masukkan keterangan..." rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
        $('.detail').append(html);
        $('.alert-cover').show();
    });

    $('body').on('click', '.edit', function () {
        $('.alert-cover').hide();
        $('.detail').html('');
        id = $(this).data('id');
        flag_type = "update";
        const name = $(this).data('name');
        const latitude = $(this).data('latitude');
        const longitude = $(this).data('longitude');
        const description = $(this).data('description');
        const status = $(this).data('status');
        const price = $(this).data('price');

        $('.name').val(name);
        $('.latitude').val(latitude);
        $('.longitude').val(longitude);
        $('.description').html(description);
        $('.status').val(status);
        $('.price').val(price);
        $('.price').trigger('keyup');

        $('.title-modal').html('Edit Tempat');
        $('.action').html('Update');
        $('.action').attr('data-type', 'update');

        CKEDITOR.instances.ckeditor.setData(description);

        $('.bootstrap-wysihtml5-insert-link-modal').remove();
        $('.bootstrap-wysihtml5-insert-image-modal').remove();

        $('.modal').show();

        getImage(id);
    });

    $('body').on('click', '.add', function () {
        flag_type = "store";
        $('.alert-cover').hide();
        $('.detail').html('');
        $('.title-modal').html('Tambah Tempat');
        $('.action').html('Tambah');
        $('.action').attr('data-type', 'store');

        $('.name').val('');
        $('.latitude').val('');
        $('.longitude').val('');
        $('.description').val('');
        $('.status').val('');

        CKEDITOR.instances.ckeditor.setData('');

        $('.bootstrap-wysihtml5-insert-link-modal').remove();
        $('.bootstrap-wysihtml5-insert-image-modal').remove();

        $('.modal').show();
    });

    $('body').on('click', '.delete-detail', function () {
        $(this).closest('.list-detail').remove();
    });

    $('body').on('click', '.action', function () {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

        const form = $('#form-place')[0]; // Get the first element of the jQuery object
        let formData = new FormData(form);

        if (flag_type == "update") {
            action(`/admin/place/update/${id}`, formData);
        }else{
            action(`/admin/place/store`, formData);
        }
    });

    function action(url, data)
    {
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.code == 200) {
                    toast("Berhasil");
                    table.draw();
                    $('.modal').hide();
                } else {
                    swal("Oops", res.message, "error");
                }
            },
            error: function(xhr, status, error) {
                swal("Error", "Error occurred while updating data: " + error, "error");
            }
        });
    }

    function getImage(id)
    {
        $.ajax({
            url: `/admin/place/get-image/${id}`,
            type: 'GET',
            success: function (res) {
                let html = "";
                $.each(res, function(k, v){
                    html += `<div class="mt-2 list-detail">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-1" style="width:40px">
                                            <button type="button" class="delete-detail btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <input type="hidden" name="old_image[]" class="form-control old_image" value="${v.images}">
                                                <input type="file" name="image[]" class="form-control image-input">
                                            </div>
                                            <div class="preview-container">
                                                <img class="preview-image" src="/${v.images}" alt="Preview Image">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <textarea name="image_description[]" id="" class="form-control" placeholder="Masukkan keterangan..." rows="10">${v.description}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                });

                if (res.length > 0) {
                    $('.alert-cover').show();
                }

                $('.detail').html(html);
            },
            error: function(xhr, status, error) {
                swal("Error", "Oops: " + error, "error");
            }
        });
    }

    $('body').on('change', '.image-input', function(){
        let elem = $(this);
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                elem.closest('.col-md-5').find('.preview-container').html('<img class="preview-image" src="' + e.target.result + '" alt="Preview Image">');
                elem.closest('.col-md-5').find('.old_image').remove();
            }
            reader.readAsDataURL(this.files[0]); // convert to base64 string
        }
    });
});