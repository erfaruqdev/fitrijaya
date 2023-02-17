<script type="text/javascript" src="<?= base_url() ?>template/plugins/bootstrap-strength/password-score/password-score.js"></script>
<script type="text/javascript" src="<?= base_url() ?>template/plugins/bootstrap-strength/password-score/password-score-options.js"></script>
<script type="text/javascript" src="<?= base_url() ?>template/plugins/bootstrap-strength/dist/js/bootstrap-strength-meter.js"></script>
<script>
    toastr.options = {
        "positionClass": "toast-top-center",
        "timeOut": "2000"
    }

    const changeUsername = () => {
        $('#wrap-change-username').removeClass('d-none').addClass('d-flex')
        $('#username').focus()
    }

    const cancelChangeUsername = () => {
        $('#wrap-change-username').removeClass('d-flex').addClass('d-none')
        $('#username').val('')
    }

    const saveUsername = username => {
        let credential = /^[a-z]*$/
        let newUsername = $('#username').val()

        if (newUsername == '') {
            $('#errorusername').removeClass('d-none').addClass('d-block')
            $('#is-error').html('Username tidak boleh kosong')
            $('#username').focus().select()
        } else if (newUsername.length < 6) {
            $('#errorusername').removeClass('d-none').addClass('d-block')
            $('#is-error').html('Username minimal harus 6 karakter')
            $('#username').focus().select()
        } else if (username == newUsername.toLowerCase()) {
            $('#errorusername').removeClass('d-none').addClass('d-block')
            $('#is-error').html('Username baru tidak boleh sama')
            $('#username').focus().select()
        } else if (newUsername.match(credential) == null) {
            $('#errorusername').removeClass('d-none').addClass('d-block')
            $('#is-error').html('Username harus huruf alfabet kecil tanpa spasi')
            $('#username').focus().select()
        } else {
            checkUsername(newUsername)
        }
    }

    const checkUsername = username => {
        $.ajax({
            url: '<?= base_url() ?>profile/checkusername',
            method: 'POST',
            data: {
                username
            },
            dataType: 'JSON',
            success: function(response) {
                let status = response.status
                if (status == 400) {
                    $('#errorusername').removeClass('d-none').addClass('d-block')
                    $('#is-error').html('Username sudah ada yang menggunakan')
                    $('#username').focus().select()
                    return false
                }
                $('#errorusername').removeClass('d-block').addClass('d-none')
                $('#is-error').html('')
                $('#new_username').val(username)
                $('#modal-username').modal('show')
            }
        })
    }

    $('#showPassword').on('click', function() {
        $(this).removeClass('d-flex')
        $(this).addClass('d-none')

        $('#hidePassword').removeClass('d-none')
        $('#hidePassword').addClass('d-flex')

        $('#current_password_change_username').attr('type', 'text')
    })

    $('#hidePassword').on('click', function() {
        $(this).removeClass('d-flex')
        $(this).addClass('d-none')

        $('#showPassword').removeClass('d-none')
        $('#showPassword').addClass('d-flex')

        $('#current_password_change_username').attr('type', 'password')
    })

    $('#modal-username').on('shown.bs.modal', () => {
        $('#current_password_change_username').focus().val()
    })

    $('#modal-username').on('hidden.bs.modal', () => {
        $('#current_password_change_username').val('')
        $('#new_username').val('')
    })

    $('#savechangeuser').on('click', function() {
        $.ajax({
            url: '<?= base_url() ?>profile/savechangeuser',
            method: 'POST',
            data: $('#formshangeusername').serialize(),
            dataType: 'JSON',
            beforeSend: function() {
                $('#savechangeuser').prop('disabled', true)
            },
            success: function(response) {
                $('#savechangeuser').prop('disabled', false)
                let status = response.status
                if (status == 400) {
                    let error = response.errors
                    if (error.current_password_change_username) {
                        $('#errorcurrent_password_change_username').html(error.current_password_change_username)
                        $('#current_password_change_username').addClass('is-invalid')
                    } else {
                        $('#errorcurrent_password_change_username').html('')
                        $('#current_password_change_username').removeClass('is-invalid')
                    }
                    return false
                }

                if (status == 500) {
                    $('#errorcurrent_password_change_username').html('Password anda salah')
                    $('#current_password_change_username').removeClass('is-invalid')
                    return false
                }

                Swal.fire({
                    title: 'Username berhasil diubah',
                    icon: 'success',
                    html: 'Halaman akan dimuat ulang dalam <strong>2</strong> detik.<br/><br/>',
                    timer: 2000,
                    timerProgressBar: true
                })
                setTimeout(function() {
                    location.reload()
                }, 2000)
            }
        })
    })

    const showChangePasword = () => {
        $('#wrap-change-password').removeClass('d-none').addClass('d-block')
        $('#password').focus()
    }

    const cancelChangePasword = () => {
        $('#wrap-change-password').removeClass('d-block').addClass('d-none')
        $('#formchangepassword')[0].reset();
        $('.errors').html('')
        $('.form-control-border').removeClass('is-invalid')

        $(this).removeClass('d-flex')
        $(this).addClass('d-none')

        $('#showTogglePassword').removeClass('d-none')
        $('#showTogglePassword').addClass('d-flex')
        $('#hideTogglePassword').removeClass('d-flex')
        $('#hideTogglePassword').addClass('d-none')

        $('#current_password_change_username').attr('type', 'password')
        $('#password').attr('type', 'password')
        $('#password_confirmation').attr('type', 'password')
        $('#current_password').attr('type', 'password')
    }

    $('#password').on('keypress', function() {
        $('#password').strengthMeter('text', {
            container: $('#text-strength'),
            hierarchy: {
                '0': ['text-success', ''],
                '1': ['text-success', 'Sangat lemah'],
                '25': ['text-success', 'Lemah'],
                '50': ['text-success', 'Bagus'],
                '75': ['text-success', 'Kuat'],
                '100': ['text-success', 'Sangat kuat']
            }
        });
        $('#errorpassword').html('')
    })

    const saveNewPassword = () => {
        $.ajax({
            url: '<?= base_url() ?>profile/savenewpassword',
            method: 'POST',
            data: $('#formchangepassword').serialize(),
            dataType: 'JSON',
            beforeSend: function() {
                $('#buttonsavenewpassword').prop('disabled', true)
            },
            success: function(response) {
                $('#buttonsavenewpassword').prop('disabled', false)
                let status = response.status
                if (status == 400) {
                    let error = response.errors
                    if (error.password) {
                        $('#errorpassword').html(error.password)
                        $('#password').addClass('is-invalid')
                        $('#text-strength').html('')
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

                    if (error.current_password) {
                        $('#errorcurrent_password').html(error.current_password)
                        $('#current_password').addClass('is-invalid')
                    } else {
                        $('#errorcurrent_password').html('')
                        $('#current_password').removeClass('is-invalid')
                    }

                    return false
                }

                if (status == 500) {
                    $('.errors').html('')
                    toastr.error('Opsss..! Password saat ini salah')
                    return false
                }

                $('.errors').html('')
                Swal.fire({
                    title: 'Password berhasil diubah',
                    icon: 'success',
                    html: 'Halaman akan dimuat ulang dalam <strong>2</strong> detik.<br/><br/>',
                    timer: 2000,
                    timerProgressBar: true
                })
                setTimeout(function() {
                    location.reload()
                }, 2000)
            }
        })
    }

    $('#showTogglePassword').on('click', function() {
        $(this).removeClass('d-flex')
        $(this).addClass('d-none')

        $('#hideTogglePassword').removeClass('d-none')
        $('#hideTogglePassword').addClass('d-flex')

        $('#password').attr('type', 'text')
        $('#password_confirmation').attr('type', 'text')
        $('#current_password').attr('type', 'text')
    })

    $('#hideTogglePassword').on('click', function() {
        $(this).removeClass('d-flex')
        $(this).addClass('d-none')

        $('#showTogglePassword').removeClass('d-none')
        $('#showTogglePassword').addClass('d-flex')

        $('#password').attr('type', 'password')
        $('#password_confirmation').attr('type', 'password')
        $('#current_password').attr('type', 'password')
    })

    $(document).ready(function() {
        $image_crop = $('#image_demo').croppie({
            enableExif: true,
            viewport: {
                width: 200,
                height: 200,
                type: 'square' //circle
            },
            boundary: {
                width: 400,
                height: 400
            },
            enableOrientation: true
        });

        $('#upload_image').on('change', function() {
            var reader = new FileReader();
            reader.onload = function(event) {
                $image_crop.croppie('bind', {
                    url: event.target.result,
                    orientation: 4,
                    zoom: 0
                }).then(function() {
                    //console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(this.files[0]);
            $('#modal-change-image').modal('show');
        });

        $('.vanilla-rotate').on('click', function(ev) {
            $image_crop.croppie('rotate', parseInt($(this).data('deg')));
        });
    })

    $('#upload-image').click(function(event) {
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function(response) {
            $.ajax({
                url: '<?= base_url() ?>profile/upload',
                type: 'POST',
                data: {
                    image: response
                },
                success: function(data) {
                    $('#modal-change-image').modal('hide');
                    Swal.fire({
                        title: 'Foto berhasil diupload',
                        icon: 'success',
                        html: 'Halaman akan dimuat ulang dalam <strong>2</strong> detik.<br/><br/>',
                        timer: 2000,
                        timerProgressBar: true
                    })
                    setTimeout(function() {
                        location.reload()
                    }, 2000)
                }
            });
        })
    });
</script>
</body>

</html>