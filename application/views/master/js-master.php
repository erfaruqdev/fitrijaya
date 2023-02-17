<script>
    let url = $('#url').val()
    $('[data-mask]').inputmask();

    toastr.options = {
        "positionClass": "toast-top-center",
        "timeOut": "2000"
    }

    const errorAlert = message => {
        toastr.error(`Opss.! ${ message }`)
    }

    $('body').on('keyup', e => {
        if (e.keyCode == 113) {
            $('#changeName').focus().val('')
        }
    })

    $(function() {
        loadCategory()
        loadColor()
        loadPackage()
        loadUnit()
        loadMarket()
        loadCustomer()
    })

    const loadCategory = () => {
        $('#show-category').html('')
        
        $.ajax({
            url: `${url}master/loadCategory`,
            method: 'POST',
            beforeSend: function(){
                $('.skeleton_loading_category__').show()
            },
            success: function(response) {
                $('#show-category').html(response)
            },
            complete: function() {
                $('.skeleton_loading_category__').hide()
            }
        })
    }

    const loadColor = () => {
        $('#show-color').html('')
        
        $.ajax({
            url: `${url}master/loadcolor`,
            method: 'POST',
            beforeSend: function(){
                $('.skeleton_loading_color__').show()
            },
            success: function(response) {
                $('#show-color').html(response)
            },
            complete: function() {
                $('.skeleton_loading_color__').hide()
            }
        })
    }

    const loadPackage = () => {
        $('#show-package').html('')
        
        $.ajax({
            url: `${url}master/loadpackage`,
            method: 'POST',
            beforeSend: function(){
                $('.skeleton_loading_package__').show()
            },
            success: function(response) {
                $('#show-package').html(response)
            },
            complete: function() {
                $('.skeleton_loading_package__').hide()
            }
        })
    }

    const loadUnit = () => {
        $('#show-unit').html('')
        
        $.ajax({
            url: `${url}master/loadunit`,
            method: 'POST',
            beforeSend: function(){
                $('.skeleton_loading_unit__').show()
            },
            success: function(response) {
                $('#show-unit').html(response)
            },
            complete: function() {
                $('.skeleton_loading_unit__').hide()
            }
        })
    }

    const loadCustomer = () => {
        $('#show-customer').html('')
        
        $.ajax({
            url: `${url}master/loadcustomer`,
            method: 'POST',
            beforeSend: function(){
                $('.skeleton_loading_customer__').show()
            },
            success: function(response) {
                $('#show-customer').html(response)
            },
            complete: function() {
                $('.skeleton_loading_customer__').hide()
            }
        })
    }

    const loadMarket = () => {
        $('#show-market').html('')
        
        $.ajax({
            url: `${url}master/loadmarket`,
            method: 'POST',
            beforeSend: function(){
                $('.skeleton_loading_market__').show()
            },
            success: function(response) {
                $('#show-market').html(response)
            },
            complete: function() {
                $('.skeleton_loading_market__').hide()
            }
        })
    }

    $('#add-button').on('click', function() {
        $('#modal-master').modal('show')
    })

    $('#modal-master').on('hidden.bs.modal', () => {
        $('#form-master')[0].reset()
        $('#id').val(0)
        let validator = $('#form-master').validate();
        validator.resetForm();
        $('.form-feedback').find('.is-invalid').removeClass('is-invalid')
    })


    $('#form-master').validate({
        rules: {
            table: {
                required: true
            },
            name: {
                required: true
            },
            address: {
                required: true
            },
            phone: {
                required: true
            }
        },
        messages: {
            table: {
                required: 'Pilih dulu jenis'
            },
            name: {
                required: 'Isi dulu nama'
            },
            address: {
                required: 'Isi dulu alamat'
            },
            phone: {
                required: 'Isi dulu nomor HP'
            }
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-feedback').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function() {
            save()
        }
    });

    const save = () => {
        $.ajax({
            url: `${url}master/save`,
            method: 'POST',
            data: $('#form-master').serialize(),
            dataType: 'JSON',
            beforeSend: function() {
                $('.wrap-loading__').show()
                $('#submit-button').prop('disabled', true).text('Data sedang dikirm')
            },
            success: function(res) {
                $('.wrap-loading__').hide()
                $('#submit-button').prop('disabled', false).text('Simpan')
                if (res.status == 400) {
                    errorAlert(res.message)
                    return false
                }
                $('#modal-master').modal('hide')
                toastr.success(`Yeaah..! ${res.message}`)
                let table = res.table
                if (table == 'markets') {
                    loadMarket()
                } else {
                    loadCustomer()
                }
            }
        })
    }

    const editMaster = (id, table) => {
        $('.wrap-loading__').show()
        $.post(`${url}master/edit`, {
                id,
                table
            }, function(res) {
                $('.wrap-loading__').hide()

                if (res.status == 400) {
                    errorAlert(res.message)
                    return false
                }
                $('#id').val(id)
                $('#table').val(table)
                $('#name').val(res.data.name)
                $('#address').val(res.data.address)
                $('#phone').val(res.data.phone)
                $('#modal-master').modal('show')
            }, 'JSON')
            .fail(function(jqXHR, textStatus, errorThrown) {
                $('.wrap-loading__').hide()
                errorAlert(formatErrorMessage(jqXHR, errorThrown))
            })
    }

    const editOther = (id, table) => {
        $('.wrap-loading__').show()
        $.post(`${url}master/editother`, {
                id,
                table
            }, function(res) {
                $('.wrap-loading__').hide()

                if (res.status == 400) {
                    errorAlert(res.message)
                    return false
                }
                $('#id-other').val(id)
                $('#table-other').val(table)
                $('#name-other').val(res.name)
                $('#modal-other').modal('show')
            }, 'JSON')
            .fail(function(jqXHR, textStatus, errorThrown) {
                $('.wrap-loading__').hide()
                errorAlert(formatErrorMessage(jqXHR, errorThrown))
            })
    }

    $('#add-other').on('click', function() {
        $('#modal-other').modal('show')
    })

    $('#modal-other').on('hidden.bs.modal', () => {
        $('#form-other')[0].reset()
        $('#id').val(0)
        let validator = $('#form-other').validate();
        validator.resetForm();
        $('.form-feedback').find('.is-invalid').removeClass('is-invalid')
    })

    $('#form-other').validate({
        rules: {
            table: {
                required: true
            },
            name: {
                required: true
            }
        },
        messages: {
            table: {
                required: 'Pilih dulu jenis'
            },
            name: {
                required: 'Isi dulu nama'
            }
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-feedback').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function() {
            saveOther()
        }
    });

    const saveOther = () => {
        $.ajax({
            url: `${url}master/saveother`,
            method: 'POST',
            data: $('#form-other').serialize(),
            dataType: 'JSON',
            beforeSend: function() {
                $('.wrap-loading__').show()
                $('#submit-other').prop('disabled', true).text('Data sedang dikirm')
            },
			success: function (res) {
				$('.wrap-loading__').hide()
				$('#submit-other').prop('disabled', false).text('Simpan')
				if (res.status == 400) {
					errorAlert(res.message)
					return false
				}
				// $('#modal-other').modal('hide')
				$('#name-other').val('').focus()
				toastr.success(`Yeaah..! ${res.message}`)

				let table = res.table
				if (table == 'categories') {
					loadCategory()
				} else if (table == 'colors') {
					loadColor()
				} else if (table == 'packages') {
					loadPackage()
				} else {
					loadUnit()
				}
			}
        })
    }
</script>
</body>

</html>
