<script src="<?= base_url('template') ?>/plugins/autoNumeric.js"></script>
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

    $('.price').autoNumeric('init', {
        aSep: '.',
        aDec: ',',
        aForm: true,
        vMax: '999999999',
        vMin: '-999999999'
    });

    $('body').on('keyup', e => {
        if (e.keyCode == 113) {
            $('#changeName').focus().val('')
        }
    })

    $(function() {
        loadData()
    })

    const loadData = () => {
        $('.skeleton_loading__').show()
        $('#show-product').html('')

        let name = $('#changeName').val()
        let category = $('#changeCategory').val()
        $.ajax({
            url: `${url}product/loaddata`,
            method: 'POST',
            data: {
                name,
                category
            },
            success: function(response) {
                $('#show-product').html(response)
            },
            complete: function() {
                $('.skeleton_loading__').hide()
            }
        })
    }

    function copyToClipboard(text) {
        var sampleTextarea = document.createElement("textarea");
        document.body.appendChild(sampleTextarea);
        sampleTextarea.value = text; //save main text in it
        sampleTextarea.select(); //select textarea contenrs
        document.execCommand("copy");
        document.body.removeChild(sampleTextarea);
        toastr.success('ID berhasil disalin ke clipboard')
    }

    $('#modal-product').on('shown.bs.modal', () => {
        $('#name').focus()
    })

    $('#modal-product').on('hidden.bs.modal', () => {
        $('#form-product')[0].reset()
        $('#id').val(0)
        let validator = $('#form-product').validate();
        validator.resetForm();
        $('.form-feedback').find('.is-invalid').removeClass('is-invalid')
    })

	const selectValue = (el) => {
		$(el).select().val()
	}


    $('#form-product').validate({
        rules: {
            name: {
                required: true
            },
            category: {
                required: true
            },
            package: {
                required: true
            },
            unit: {
                required: true
            },
            amount: {
                required: true,
                number: true
            },
            color: {
                required: true
            },
            size: {
                required: true
            },
            price: {
                required: true
            },
			price_two: {
				required: true
			},
			price_three: {
				required: true
			}
        },
        messages: {
            name: {
                required: 'Isi dulu nama barang'
            },
            category: {
                required: 'Pilih dulu kategori barang'
            },
            package: {
                required: 'Pilih dulu paket barang'
            },
            unit: {
                required: 'Pilih dulu satuan barang'
            },
            amount: {
                required: 'Isi kuantitas satuan',
                number: 'Harus angka'
            },
            color: {
                required: 'Pilih dulu warna barang'
            },
            size: {
                required: 'Pilih dulu ukuran barang'
            },
            price: {
                required: 'Harga harus diisi'
            },
			price_two: {
				required: 'Harga grosir I harus diisi'
			},
			price_three: {
				required: 'Harga grosir II harus diisi'
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
            url: `${url}product/save`,
            method: 'POST',
            data: $('#form-product').serialize(),
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
                $('#modal-product').modal('hide')
                toastr.success(`Yeaah..! ${res.message}`)
                loadData()
            }
        })
    }

    const editProduct = (id, type) => {
        $('.wrap-loading__').show()
        $.post(`${url}product/edit`, {
                id
            }, function(res) {
                $('.wrap-loading__').hide()

                if (res.status == 400) {
                    errorAlert(res.message)
                    return false
                }
                if (type == 'COPY') {
                    $('#id').val(0)
                    // $('#color').val('')
                    // $('#size').val('')
                    // $('#price').val('')
                    // $('#price-two').val('')
                    // $('#price-three').val('')
                }else{
                    $('#id').val(id)
                    // $('#color').val(res.data.color)
                    // $('#size').val(res.data.size)
                    // $('#price').val(res.data.price)
                    // $('#price-two').val(res.data.price_two)
                    // $('#price-three').val(res.data.price_three)
                }
                $('#name').val(res.data.name)
                $('#category').val(res.data.category)
                $('#package').val(res.data.package)
                $('#unit').val(res.data.unit)
                $('#amount').val(res.data.amount)
				$('#color').val(res.data.color)
				$('#size').val(res.data.size)
				$('#price').val(res.data.price)
				$('#price-two').val(res.data.price_two)
				$('#price-three').val(res.data.price_three)
                $('#modal-product').modal('show')
            }, 'JSON')
            .fail(function(jqXHR, textStatus, errorThrown) {
                $('.wrap-loading__').hide()
                errorAlert(formatErrorMessage(jqXHR, errorThrown))
            })
    }
</script>
</body>

</html>
