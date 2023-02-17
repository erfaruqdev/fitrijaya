<script>
    $('[data-mask]').inputmask();

    toastr.options = {
        "positionClass": "toast-top-center",
        "timeOut": "2000"
    }

    const errorAlert = message => {
        toastr.error(`Opss.! ${ message }`)
    }

    const loadData = () => {
        let category = $('#changeCategory').val()
        let contest = $('#changeContest').val()
        $('#category-result-champion').val(category)
        $('#contest-result-champion').val(contest)

        $.ajax({
            url: '<?= base_url() ?>championship/loaddata',
            method: 'POST',
            data: {
                category,
                contest
            },
            success: res => {
                $('#show-data-champion').html(res)
            }
        })
    }

    const loadDataPoint = () => {
        let category = $('#changeCategoryPoin').val()
        $('#category-result').val(category)
        if (category == '') {
            $('#button-print').prop('disabled', true)
        } else {
            $('#button-print').prop('disabled', false)
        }
        $.ajax({
            url: '<?= base_url() ?>championship/loaddatapoint',
            method: 'POST',
            data: {
                category
            },
            success: res => {
                $('#show-data-point').html(res)
            }
        })
    }

    $(function() {
        loadData()
    })

    $('#modal-champion').on('hidden.bs.modal', () => {
        $('#form-champion')[0].reset()
        hideResult()
    })

    $('#modal-point').on('hidden.bs.modal', () => {
        $('#changeCategoryPoin').val('')
        $('#show-data-point').html('')
        $('#button-print').prop('disabled', true)
    })

    $('#modal-point').on('shown.bs.modal', () => {
        loadDataPoint()
    })

    const save = id => {
        Swal.fire({
            title: 'Yakin, nih?',
            text: 'Pastikan data diisi dengan lengkap dan benar',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin, dong!',
            cancelButtonText: 'Masih ragu'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url() ?>championship/save',
                    method: 'POST',
                    data: $('#form-champion').serialize(),
                    dataType: 'JSON',
                    success: function(res) {
                        if (res.status == 400) {
                            errorAlert(res.message)
                            return false
                        }
                        toastr.success(`Yeaahh.! ${res.message} berhasil ditambahkan`)
                        $('#modal-champion').modal('hide')
                        hideResult()
                        loadData()
                    }
                })
            }
        })
    }

    const changeContest = el => {
        hideResult()
        let contest = $(el).val()
        if (contest == '') {
            errorAlert('Jangan biarkan kosong')
            return false
        }

        if (contest == 2) {
            $('#content-rank-2').hide()
            $('#content-rank-3').hide()
        } else {
            $('#content-rank-2').show()
            $('#content-rank-3').show()
        }

        $('#rank-1').focus().val('')
        $('#rank-2').val('')
        $('#rank-3').val('')
    }

    const hideResult = () => {
        $('#show-data-rank-1').html('')
        $('#show-data-rank-2').html('')
        $('#show-data-rank-3').html('')
    }

    $('#rank-1').on('keyup', function(e) {
        let id = $(this).val()
        let key = e.which
        if (key == 13 && id != '') {
            checkData(id, $('#rank-2'), $('#show-data-rank-1'))
        }
    })

    $('#rank-2').on('keyup', function(e) {
        let id = $(this).val()
        let key = e.which
        if (key == 13 && id != '') {
            checkData(id, $('#rank-3'), $('#show-data-rank-2'))
        }
    })

    $('#rank-3').on('keyup', function(e) {
        let id = $(this).val()
        let key = e.which
        if (key == 13 && id != '') {
            checkData(id, $('#button-save'), $('#show-data-rank-3'))
        }
    })

    const checkData = (id, el, target) => {
        let contest = $('#contest').val()
        if (contest == '') {
            errorAlert('Pilih dulu jenis lomba')
            return false
        }
        if (contest != 2) {
            el.focus().val('')
        }

        $.ajax({
            url: '<?= base_url() ?>championship/checkdata',
            method: 'POST',
            data: {
                id,
                contest
            },
            success: res => {
                target.html(res)
            }
        })
    }
</script>
</body>

</html>