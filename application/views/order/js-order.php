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

        let status = $('#changeStatus').val()
        let customer = $('#changeCustomer').val()
        let startDate = $('#start-date').val()
        let endDate = $('#end-date').val()

        $.ajax({
            url: `${url}order/loaddata`,
            method: 'POST',
            data: {
                status,
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
            url: `${url}order/detail`,
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

	const cancelTransaction = id => {
		Swal.fire({
			title: 'Yakin, nih?',
			text: 'Lanjut jika ada transaksi yang tidak valid',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yakin, dong!',
			cancelButtonText: 'Nggak jadi',
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: `${url}order/cancel`,
					method: 'POST',
					data: {
						id
					},
					dataType: 'JSON',
					success: function(res) {
						if (res.status == 400) {
							errorAlert(res.message)
							return false
						}
						alertAction(res.url)
					}
				})
			}
		})
	}

	const alertAction = (url) => {
		Swal.fire({
			title: "Transaksi berhasil dibatalkan",
			icon: 'success',
			html: 'Anda akan diarahkan dalam <strong>2</strong> detik.<br/><br/>',
			timer: 2000,
			timerProgressBar: true
		})
		setTimeout(function() {
			if (url !== 0) {
				window.open(url);
			}
		}, 2000)
	}
</script>
</body>

</html>
