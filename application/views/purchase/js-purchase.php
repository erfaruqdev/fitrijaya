<script>
    let url = $('#url').val()
    $('[data-mask]').inputmask();

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

        let market = $('#changeMarket').val()
        let startDate = $('#start-date').val()
        let endDate = $('#end-date').val()

        $.ajax({
            url: `${url}purchase/loaddata`,
            method: 'POST',
            data: {
                market,
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
            url: `${url}purchase/detail`,
            method: 'POST',
            data: {
                invoice: id
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
</script>
</body>

</html>