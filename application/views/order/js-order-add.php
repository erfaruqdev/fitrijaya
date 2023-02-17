<script>
    let url = $('#url').val()
    $('[data-mask]').inputmask();

    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    toastr.options = {
        "positionClass": "toast-top-center",
        "timeOut": "2000"
    }

    const errorAlert = message => {
        toastr.error(`Opss.! ${ message }`)
    }

    const alertAction = (message, url) => {
        Swal.fire({
            title: message,
            icon: 'success',
            html: 'Anda akan diarahkan dalam <strong>2</strong> detik.<br/><br/>',
            timer: 2000,
            timerProgressBar: true
        })
        setTimeout(function() {
			if (url !== 0) {
				window.open(url, '_blank');
			}
			location.reload()
        }, 2000)
    }

    $(function() {
        loadData()
    })

    $('#add-invoice').on('click', function() {
        let customer = $('#changeCustomer').val()
        if (customer == '') {
            errorAlert('Toko belum dipilih')
            return false
        }

        setInvoice(customer, 'ADD', 0, $(this))
    })

    $('#done-invoice').on('click', function() {
        Swal.fire({
            title: 'Yakin, nih?',
            text: 'Pastikan satu faktur sudah diinput semua',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin, dong!',
            cancelButtonText: 'Nggak jadi',
        }).then((result) => {
            if (result.isConfirmed) {
                setInvoice(0, 'DONE', $('#invoice').val(), $(this))
            }
        })
    })

    const setInvoice = (customer, invoiceStatus, invoice, el) => {
        $.ajax({
            url: `${url}order/setinvoice`,
            method: 'POST',
            data: {
                customer,
                status: invoiceStatus,
                invoice
            },
            dataType: 'JSON',
            beforeSend: function() {
                el.prop('disabled', true)
                el.text('Permintaan dikirim...')
            },
            success: function(res) {
                if (res.status == 400) {
                    errorAlert(res.message)
                    return false
                }

                location.reload()
            }
        })
    }

    $('#product-name').on('focus', function() {
        $(this).select()
        $('#product-info').hide()
    })

    $(document).ready(function() {
        // Initialize 
        $('#product-name').autocomplete({
            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: `${url}order/getproduct`,
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        keyword: request.term
                    },
                    beforeSend: function() {
                        $('.wrap-loading__').show()
                    },
                    success: function(data) {
                        response(data);
                    },
                    complete: function() {
                        $('.wrap-loading__').hide()
                    }
                });
            },
            select: function(event, ui) {
                // Set selection
                $('#product-name').val(ui.item.label); // display the selected text
                $('#product-id').val(ui.item.id); // save selected id to input
				getDetailProduct(ui.item.id)
                return false;
            }
        });
    });

	const beforeGetProduct = () => {
	  	let id = $('#product-id').val()
		if (id == 0) {
			return false
		}

		getDetailProduct(id)
	}

    const getDetailProduct = id => {
        $.ajax({
            url: `${url}order/getdetailproduct`,
            method: 'POST',
            data: {
                id,
				price: $('#change-price').val()
            },
            dataType: 'JSON',
            beforeSend: function() {
                $('.skeleton_loading_product__').show()
            },
            success: function(res) {
                if (res.status == 400) {
                    errorAlert(res.message)
                    return false
                }

                $('#show-stock').text(res.stock)
                $('#show-price').text(res.price_display)
				$('#price').val(res.price)
                $('#product-info').show()
            },
            complete: function() {
                $('.skeleton_loading_product__').hide()
                $('#qty').focus().select()
            }
        })
    }

    $('#nominal').autoNumeric('init', {
        aSep: '.',
        aDec: ',',
        aForm: true,
        vMax: '999999999',
        vMin: '-999999999'
    });

    $('#qty').on('keyup', function(e) {
        let key = e.which
        if (key != 13) {
            return false
        }

        if (key == 13 && $(this).val() == '') {
            return false
        }

        save()
    })

    $('#save-order').on('click', function() {
        save()
    })

    const save = () => {
		$.ajax({
			url: `${url}order/save`,
			method: 'POST',
			data: $('#form-order').serialize(),
			dataType: 'JSON',
			beforeSend: function() {
				$('#save-order').prop('disabled', true).text('Permintaan sedang dikirim')
				$('.wrap-loading__').show()
			},
			success: function(res) {
				$('#save-order').prop('disabled', false).html('<i class="fa fa-save"></i> Simpan')
				$('.wrap-loading__').hide()
				if (res.status == 400) {
					errorAlert(res.message)
					return false
				}
				toastr.success('Yeaahh..! Satu barang berhasil ditambahkan')
				$('#qty').val('')
				$('#product-id').val(0)
				$('#product-name').focus().val('')
				loadData()
			}
		})
    }

    const loadData = () => {
        let invoice = $('#invoice').val()
        $.ajax({
            url: `${url}order/loadadd`,
            method: 'POST',
            data: {
                invoice
            },
            beforeSend: function() {
                $('#skeleton_loadadd').show()
                $('#show-data').hide()
            },
            success: function(res) {
                $('#skeleton_loadadd').hide()
                $('#show-data').html(res)
                $('#show-data').show()
            }
        })
    }

    const deleteDetail = id => {
        Swal.fire({
            title: 'Yakin, nih?',
            text: 'Data akan dihapus permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin, dong!',
            cancelButtonText: 'Nggak jadi',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${url}order/deletedetail`,
                    method: 'POST',
                    data: {
                        id
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('.wrap-loading__').show()
                    },
                    success: function(res) {
                        $('.wrap-loading__').hide()
                        if (res.status == 400) {
                            errorAlert(res.message)
                            return false
                        }
                        toastr.success('Yeaahh..! Satu barang berhasil dihapus')
                        loadData()
                    }
                })
            }
        })
    }

    const cancelOrder = () => {
        Swal.fire({
            title: 'Yakin, nih?',
            text: 'Semua data dalam invoice ini akan dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin, dong!',
            cancelButtonText: 'Nggak jadi',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${url}order/deleteorder`,
                    method: 'POST',
                    data: {
                        id: $('#invoice').val()
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('.wrap-loading__').show()
                    },
                    success: function(res) {
                        $('.wrap-loading__').hide()
                        if (res.status == 400) {
                            errorAlert(res.message)
                            return false
                        }
                        alertAction('Transaksi berhasil dibatalkan', 0)
                    }
                })
            }
        })
    }

    const saveOrder = () => {
        Swal.fire({
            title: 'Yakin, nih?',
            text: 'Semua data akan disimpan',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin, dong!',
            cancelButtonText: 'Nggak jadi',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${url}order/saveorder`,
                    method: 'POST',
                    data: {
                        id: $('#invoice').val()
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('.wrap-loading__').show()
                    },
                    success: function(res) {
                        $('.wrap-loading__').hide()
                        if (res.status == 400) {
                            errorAlert(res.message)
                            return false
                        }
                        alertAction('Yeaahh..!', res.url)
                    }
                })
            }
        })
    }
</script>
</body>

</html>
