<script>
    let url = $('#url').val()
    $('[data-mask]').inputmask();

    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    $('#reservation').daterangepicker({
        ranges: {
            'Hari ini': [moment(), moment()],
            'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '7 hari terakhir': [moment().subtract(6, 'days'), moment()],
            '30 hari terakhir': [moment().subtract(29, 'days'), moment()],
            'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
            'Bulan lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Reset',
            applyLabel: 'Terapkan'
        }
    })

    $('#reservation').on('apply.daterangepicker', function(ev, picker) {
        $(this).val('').attr('placeholder', picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        $('#start-date').val(picker.startDate.format('YYYY-MM-DD'))
        $('#end-date').val(picker.endDate.format('YYYY-MM-DD'))

        loadData()
    });

    $('#reservation').on('cancel.daterangepicker', function(ev, picker) {
        $(this).attr('placeholder', 'Semua waktu').val('');
        $('#start-date').val('')
        $('#end-date').val('')

        loadData()
    });

    toastr.options = {
        "positionClass": "toast-top-center",
        "timeOut": "2000"
    }

    const errorAlert = message => {
        toastr.error(`Opss.! ${ message }`)
    }

    $(function() {
        loadData()
    })

    const loadData = () => {
        $('.skeleton_loading__').show()
        $('#show-data').html('')

        let customer = $('#changeCustomer').val()
        let startDate = $('#start-date').val()
        let endDate = $('#end-date').val()

        $.ajax({
            url: `${url}retur/loaddata`,
            method: 'POST',
            data: {
                customer,
                startDate,
                endDate
            },
            beforeSend: function() {
                $('.skeleton_loading__').show()
            },
            success: function(res) {
                $('#show-data').html(res)
            },
            complete: function() {
                $('.skeleton_loading__').hide()
            }
        })
    }

    const detailTransaction = id => {
        $.ajax({
            url: `${url}retur/detail`,
            method: 'POST',
            data: {
                id
            },
            beforeSend: function() {
                $('.wrap-loading__').show()
            },
            success: function(res) {
                $('#show-detail').html(res)
            },
            complete: function() {
                $('#modal-detail').modal('show')
                $('.wrap-loading__').hide()
            }
        })
    }

    $('#modal-retur').on('shown.bs.modal', () => {
        $('#invoice').focus().val('')
    })

    $('#modal-retur').on('hidden.bs.modal', () => {
        $('#invoice').val('')
        $('#show-retur').html('')
        $('#customer-retur').val('')
    })

    $('#invoice').on('keyup', function(e) {
        let key = e.which
        if (key != 13) {
            return false
        }

        checkTransaction()
    })

    const checkTransaction = () => {
        let id = $('#invoice').val()
        if (id == '') {
            errorAlert('Isi dulu Nomor Faktur')
            return false
        }

        $.ajax({
            url: `${url}retur/checktransaction`,
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
                    $('#invoice').focus().select()
                    return false
                }
                loadTransaction(id)
            }
        })
    }

    const loadTransaction = id => {
        $.ajax({
            url: `${url}retur/loadtransaction`,
            method: 'POST',
            data: {
                id
            },
            beforeSend: function() {
                $('.wrap-loading__').show()
            },
            success: function(res) {
                $('#show-retur').html(res)
            },
            complete: function() {
                $('.wrap-loading__').hide()
            }
        })
    }

    const returOrder = id => {
        Swal.fire({
            title: 'Yakin, nih?',
            text: 'Tindakan hanya bisa sekali',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Lanjut',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${url}retur/returorder`,
                    method: 'POST',
                    data: $(`#form-retur-${id}`).serialize(),
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

                        toastr.success(`Yeaahh..! ${res.message} barang berhsil diretur`)
                        loadTransaction(res.id)
                    }
                })
            }
        })
    }
</script>
</body>

</html>