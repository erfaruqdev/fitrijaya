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

    const alertAction = message => {
        Swal.fire({
            title: message,
            icon: 'success',
            html: 'Anda akan diarahkan dalam <strong>2</strong> detik.<br/><br/>',
            timer: 2000,
            timerProgressBar: true
        })
        setTimeout(function() {
            location.reload()
        }, 2000)
    }

    $(function() {
        loadData()
    })

    $('#add-invoice').on('click', function() {
        let market = $('#changeMarket').val()
        if (market == '') {
            errorAlert('Toko belum dipilih')
            return false
        }

        setInvoice(market, 'ADD', 0, $(this))
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

    const setInvoice = (market, invoiceStatus, invoice, el) => {
        $.ajax({
            url: `${url}purchase/setinvoice`,
            method: 'POST',
            data: {
                market,
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

    $(document).ready(function() {
        // Initialize 
        $('#product-name').autocomplete({
            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: `${url}purchase/getproduct`,
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        keyword: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                // Set selection
                $('#product-name').val(ui.item.label); // display the selected text
                $('#product-id').val(ui.item.id); // save selected id to input
                $('#nominal').val(ui.item.price); // save selected id to input
                $('#qty').focus().val('')
                return false;
            }
        });
    });

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

        $('#nominal').focus().select()
    })

    $('#nominal').on('keyup', function(e) {
        let key = e.which
        if (key != 13) {
            return false
        }

        if (key == 13 && $(this).val() == '') {
            return false
        }

        save()
    })

    $('#save-transaction').on('click', function() {
        save()
    })

    const save = () => {
        $.ajax({
            url: `${url}purchase/save`,
            method: 'POST',
            data: $('#form-transaction').serialize(),
            dataType: 'JSON',
            beforeSend: function() {
                $('#save-transaction').prop('disabled', true).text('Permintaan sedang dikirim')
                $('.wrap-loading__').show()
            },
            success: function(res) {
                $('#save-transaction').prop('disabled', false).html('<i class="fa fa-save"></i> Simpan')
                $('.wrap-loading__').hide()
                if (res.status == 400) {
                    errorAlert(res.message)
                    return false
                }
                toastr.success('Yeaahh..! Satu barang berhasil ditambahkan')
                $('#form-transaction')[0].reset()
                $('#product-id').val(0)
                $('#product-name').focus().val('')
                loadData()
            }
        })
    }

    const loadData = () => {
        let invoice = $('#invoice').val()
        $.ajax({
            url: `${url}purchase/loadadd`,
            method: 'POST',
            data: {
                invoice
            },
            beforeSend: function() {
                $('.wrap-loading__').show()
            },
            success: function(res) {
                $('.wrap-loading__').hide()
                $('#show-data').html(res)
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
                    url: `${url}purchase/deletedetail`,
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

    const cancelTransaction = () => {
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
                    url: `${url}purchase/deletetransaction`,
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
                        alertAction('Transaksi berhasil dibatalkan')
                    }
                })
            }
        })
    }

    const saveTransaction = () => {
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
                    url: `${url}purchase/savetransaction`,
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
                        alertAction('Transaksi berhasil  diselesaikan')
                    }
                })
            }
        })
    }
</script>
</body>

</html>