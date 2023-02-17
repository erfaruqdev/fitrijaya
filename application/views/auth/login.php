<!doctype html>
<html lang="en">

<head>
    <title><?= $title ?></title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/images/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="<?= base_url() ?>template/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="<?= base_url() ?>template/auth/css/style.css">

</head>

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">
                        <div class="img" style="background-image: url(<?= base_url() ?>assets/images/logo.jpg);">
                        </div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h4>Silahkan Login!</h4>
                                </div>
                            </div>
                            <small class="alert alert-danger py-1 px-3" style="display: none" id="alert" role="alert"></small>
                            <form class="signin-form" method="POST" id="formlogin" autocomplete="off">
                                <div class="form-group mb-3">
                                    <label class="label" for="username">Username</label>
                                    <input type="text" class="form-control" name="username" id="username">
                                    <small class="text-danger errors" id="errorusername"></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label" for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                    <small class="text-danger errors" id="errorpassword"></small>
                                </div>
                                <div class="form-group">
                                    <button type="submit" id="login" class="form-control btn btn-primary rounded submit px-3">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src=" <?= base_url() ?>template/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>template/auth/js/main.js"></script>
    <script>
        $('#login').on('click', function() {
            $.ajax({
                url: '<?= base_url() ?>auth/login',
                method: 'post',
                data: $('#formlogin').serialize(),
                dataType: 'JSON',
                beforeSend: function() {
                    $('#login').prop('disabled', true)
                },
                success: function(response) {
                    $('#login').prop('disabled', false)
                    let status = response.status
                    if (status == 400) {
                        let error = response.errors
                        if (error.username) {
                            $('#errorusername').html(error.username)
                            $('#username').addClass('is-invalid')
                        } else {
                            $('#errorusername').html('')
                            $('#username').removeClass('is-invalid')
                        }

                        if (error.password) {
                            $('#errorpassword').html(error.password)
                            $('#password').addClass('is-invalid')
                        } else {
                            $('#errorpassword').html('')
                            $('#password').removeClass('is-invalid')
                        }

                        return false
                    }

                    $('.errors').html('')
                    $('.form-control').removeClass('is-invalid')

                    if (status == 500) {
                        $('#alert').html(response.message).show()
                        return false
                    }

                    window.location.href = '<?= base_url() ?>';
                }
            })
        })
    </script>
</body>

</html>
