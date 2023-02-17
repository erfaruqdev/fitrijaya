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
        const role = $('#changeRole').val()
        $.ajax({
            url: '<?= base_url() ?>user/getdata',
            method: 'POST',
            data: {
                status,
                role
            },
            success: function(response) {
                $('#showuser').html(response)
            }
        })
    }

    $('#modal-user').on('hidden.bs.modal', () => {
        $('#formuser')[0].reset();
        $('.errors').html('')
    })

    $('#modal-user').on('shown.bs.modal', () => {
        $('#name').focus().select()
    })

    $('#showPassword').on('click', function() {
        $(this).removeClass('d-flex')
        $(this).addClass('d-none')

        $('#hidePassword').removeClass('d-none')
        $('#hidePassword').addClass('d-flex')

        $('#password').attr('type', 'text')
        $('#password_confirmation').attr('type', 'text')
    })

    $('#hidePassword').on('click', function() {
        $(this).removeClass('d-flex')
        $(this).addClass('d-none')

        $('#showPassword').removeClass('d-none')
        $('#showPassword').addClass('d-flex')

        $('#password').attr('type', 'password')
        $('#password_confirmation').attr('type', 'password')
    })

    $('#saveuser').on('click', function() {
        $.ajax({
            url: '<?= base_url() ?>user/save',
            method: 'post',
            data: $('#formuser').serialize(),
            dataType: 'JSON',
            beforeSend: function() {
                $('#saveuser').prop('disabled', true)
            },
            success: function(response) {
                $('#saveuser').prop('disabled', false)
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

                    if (error.password) {
                        $('#errorpassword').html(error.password)
                        $('#password').addClass('is-invalid')
                    } else {
                        $('#errorpassword').html('')
                        $('#password').removeClass('is-invalid')
                    }

                    if (error.password_confirmation) {
                        $('#errorpassword_confirmation').html(error.password_confirmation)
                        $('#password_confirmation').addClass('is-invalid')
                    } else {
                        $('#errorpassword_confirmation').html('')
                        $('#password_confirmation').removeClass('is-invalid')
                    }

                    if (error.role) {
                        $('#errorrole').html(error.role)
                        $('#role').addClass('is-invalid')
                    } else {
                        $('#errorrole').html('')
                        $('#role').removeClass('is-invalid')
                    }
                    return false
                }

                if (status == 500) {
                    toastr.error('Opsss.! Kesalahan server nih. Coba Refresh page')
                    return false
                }

                $('.errors').html('')
                $('.form-control-border').removeClass('is-invalid')
                $('#formuser')[0].reset();
                getdata()

                Swal.fire({
                    title: 'User Berhasil Ditambahkan',
                    text: 'Tekan Salin untuk copy username ke clipboard',
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Salin Username'
                }).then((result) => {
                    if (result.isConfirmed) {
                        copyToClipboard(response.username)
                    }
                })
            }
        })
    })

    function copyToClipboard(text) {
        var sampleTextarea = document.createElement("textarea");
        document.body.appendChild(sampleTextarea);
        sampleTextarea.value = text; //save main text in it
        sampleTextarea.select(); //select textarea contenrs
        document.execCommand("copy");
        document.body.removeChild(sampleTextarea);
        toastr.success('ID berhasil disalin ke clipboard')
    }

    const updateStatus = (id, status) => {
        Swal.fire({
            title: 'Yakin, nih?',
            text: 'Tindakan ini sangat berpengaruh proses lainnya',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin dong',
            cancelButtonText: 'Nggak Jadi'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url() ?>user/changestatus',
                    method: 'POST',
                    data: {
                        id,
                        status
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        let status = response.status
                        if (status == 400) {
                            toastr.error('Opppss..! Permintaan ke server gagal')
                            return false
                        }

                        toastr.success('Yeaah...! Satu pengguna berhasil diperbarui')
                        getdata()
                    }
                })
            }
        })
    }
</script>