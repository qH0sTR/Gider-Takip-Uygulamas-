@extends('app')
@section('icerik')

<div role="main" class="main">
    <div class="container">
        <div class="row">
            <div class="kol col-12">
                <form>
                    <div class="form-group">
                        <label for="tutar">Tutar</label>
                        <input type="number" class="form-control" name="tutar" id="tutar" placeholder="Tutar">
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select class="form-control" name="kategori" id="kategori">
                            <option>Seçiniz</option>
                            <option>Gündelik</option>
                            <option>Spor</option>
                            <option>Sanat</option>
                            <option>Lüks</option>
                            <option id="other">Diğer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="açıklama">Açıklama</label>
                        <input type="text" class="form-control" name="açıklama" id="aciklama" placeholder="Açıklama">
                    </div>
                    <div class="form-group">
                        <label for="tarih">Tarih</label>
                        <input type='text' class="form-control" id='datetimepicker1' />
                    </div>
                    <div class="form-group">
                        <button id="konum_ekle" type="button" class="btn btn-info">Konum <i class="fa fa-map-marker"></i></button>
                        <input disabled id="latitude" type="text">
                        <input disabled id="longitude" type="text">
                        <span><i class="fa fa-undo"></i></span>
                    </div>
                    <button type="button" id="submit_ekle" class="btn btn-primary">Ekle</button>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
@section('css')
@endsection
@section('js')
<script>
    $(function() {
        $('#datetimepicker1').datetimepicker();
        $("#other").parents("select").change(function() {
            if ($(this).val() == "Diğer") {
                $("#other").parents("select").after('<input type="text" class="removal form-control"  placeholder="Kategori Yazınız">');
            } else {
                $(".removal").remove()
            }
        })
        $("#submit_ekle").click(function() {
            let tutar = $("#tutar").val()
            let kategori = $("#kategori").val()
            let aciklama = $("#aciklama").val()
            let tarih = $("#datetimepicker1").val()
            let konum = ""
            if ($("#latitude").val() && $("#longitude").val) {
                konum = $("#latitude").val() + "," + $("#longitude").val()
            }
            console.log(konum)
            // console.log(tutar + ", " + kategori + ", " + aciklama + ", " + tarih)
            if (tutar && kategori != "Seçiniz" && aciklama && tarih) {
                if (kategori == "Diğer" && !$(".removal").val()) {
                    vt.warn("Kategori alanı boş bırakılamaz", {
                        position: "top-center",
                        duration: 5000
                    });
                } else {
                    Swal.fire({
                        title: 'Eklemek istediğinize emin misiniz?',
                        showDenyButton: true,
                        confirmButtonText: 'Ekle',
                        denyButtonText: `Vazgeç`,
                    }).then((result) => {
                        if (result.isConfirmed) {

                            $.ajax({
                                type: "post",
                                url: '',
                                headers: {
                                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                                },
                                data: {
                                    tutar: tutar,
                                    kategori: kategori,
                                    açıklama: aciklama,
                                    tarih: new Date(tarih).toISOString().slice(0, 19).replace('T', ' '),
                                    konum: konum
                                },
                                dataType: 'json',
                                success: function(data) {
                                    if (data.success) {
                                        vt.success(data.success, {
                                            position: "top-center",
                                            duration: 5000
                                        });
                                    } else if (data.warning) {
                                        if (data.success) {
                                            vt.warn(data.warning, {
                                                position: "top-center",
                                                duration: 5000
                                            });
                                        }
                                    }
                                    if (data.success) {
                                        setTimeout(() => {
                                            location.href = location.href
                                        }, 900);
                                    }
                                }
                            });
                        }
                    })
                }

            } else {
                if (!tutar) {
                    vt.warn("Tutar alanı boş bırakılamaz", {
                        position: "top-center",
                        duration: 5000
                    });
                } else if (kategori == "Seçiniz") {
                    vt.warn("Kategori alanı boş bırakılamaz", {
                        position: "top-center",
                        duration: 5000
                    });
                } else if (!aciklama) {
                    vt.warn("Açıklama alanı boş bırakılamaz", {
                        position: "top-center",
                        duration: 5000
                    });
                } else if (!tarih) {
                    vt.warn("Tarih alanı boş bırakılamaz", {
                        position: "top-center",
                        duration: 5000
                    });
                }
            }
        })
        $("#datetimepicker1").keypress(function(event) {
            event.preventDefault();
        });
        $("#konum_ekle").click(function() {
            $(".logo img").css("display", "none")
            $(".map_container").css("display", "block")
        })

        $(".geri_don").click(function() {
            $(".logo img").css("display", "block")
            $(".map_container").css("display", "none")
        })

        $(".konumu_kaydet").click(function() {
            $("#latitude").val($("#lat").val())
            $("#longitude").val($("#lng").val())

            $(".logo img").css("display", "block")
            $(".map_container").css("display", "none")
        })

        $(".fa-undo").click(function() {
            $("#latitude").val("")
            $("#longitude").val("")
        })
    })
</script>
@endsection