<script>
    toastr.options = {
        "positionClass": "toast-top-center",
        "timeOut": "2000"
    }

    $(function() {
        getdata()
    })

    const getdata = () => {
        const status = $('#changeStatus').val()
        $.ajax({
            url: '<?= base_url() ?>menu/getdata',
            method: 'POST',
            data: {
                status
            },
            success: function(response) {
                $('#showmenu').html(response)
            }
        })
    }

    $('#modal-menu').on('hidden.bs.modal', () => {
        $('#formmenu')[0].reset();
        $('.errors').html('')
    })

    $('#modal-menu').on('shown.bs.modal', () => {
        $('#name').focus().select()
    })

    $('#savemenu').on('click', function() {
        $.ajax({
            url: '<?= base_url() ?>menu/save',
            method: 'post',
            data: $('#formmenu').serialize(),
            dataType: 'JSON',
            beforeSend: function() {
                $('#savemenu').prop('disabled', true)
            },
            success: function(response) {
                $('#savemenu').prop('disabled', false)
                let status = response.status
                if (status == 400) {
                    let error = response.errors
                    if (error.name) {
                        $('#errorname').html(error.name)
                        $('#name').addClass('is-invalid')
                    } else {
                        $('#errorname').html('')
                        $('#name').removeClass('is-invalid')
                    }

                    if (error.icon) {
                        $('#erroricon').html(error.icon)
                        $('#icon').addClass('is-invalid')
                    } else {
                        $('#erroricon').html('')
                        $('#icon').removeClass('is-invalid')
                    }

                    if (error.url) {
                        $('#errorurl').html(error.url)
                        $('#url').addClass('is-invalid')
                    } else {
                        $('#errorurl').html('')
                        $('#url').removeClass('is-invalid')
                    }

                    return false
                }

                if (status == 500) {
                    toastr.error('Opsss.! Kesalahan server nih. Coba Refresh page')
                    return false
                }

                $('.errors').html('')
                $('.form-control-border').removeClass('is-invalid')
                $('#formmenu')[0].reset();
                getdata()

                toastr.success('Yeaahh..! Satu menu berhasil ditambah')
            }
        })
    })

    const updateStatus = (id, status) => {
        Swal.fire({
            title: 'Yakin, nih?',
            text: 'Tindakan ini sangat berpengaruh',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin dong!',
            cancelButtonText: 'Nggak jadi'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url() ?>menu/updatestatus',
                    method: 'POST',
                    data: {
                        id,
                        status
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        let status = response.status
                        if (status == 400) {
                            toastr.error('Oppsss..! Ada kesalahan server nih')
                            return false
                        }

                        toastr.success('Yeaahh..! Satu menu berhasil diupdate')
                        getdata()
                    }
                })
            }
        })
    }

    const addUserMenu = (id, role) => {
        Swal.fire({
            title: 'Yakin, nih?',
            text: 'Tindakan ini sangat berpengaruh',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin dong!',
            cancelButtonText: 'Nggak jadi'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url() ?>menu/addusermenu',
                    method: 'POST',
                    data: {
                        id,
                        role
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        let status = response.status
                        if (status == 400) {
                            toastr.error('Oppsss..! Ada kesalahan server nih')
                            return false
                        }

                        if (status == 500) {
                            toastr.error('Oppsss..! Akses sudah ditambahkan sebelumnya')
                            return false
                        }

                        toastr.success('Yeaahh..! Satu akses berhasil ditambahkan')
                        getdata()
                    }
                })
            }
        })
    }

    const deleteUserMenu = (id) => {
        Swal.fire({
            title: 'Yakin, nih?',
            text: 'Tindakan ini sangat berpengaruh',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin dong!',
            cancelButtonText: 'Nggak jadi'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url() ?>menu/deleteusermenu',
                    method: 'POST',
                    data: {
                        id
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        let status = response.status
                        if (status == 400) {
                            toastr.error('Oppsss..! Ada kesalahan server nih')
                            return false
                        }

                        toastr.success('Yeaahh..! Satu akses berhasil dihentikan')
                        getdata()
                    }
                })
            }
        })
    }
</script>
</body>

</html>