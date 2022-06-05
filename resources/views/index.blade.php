@extends('app')
@section('icerik')
<style>
    .ayarlar {
        margin: 10px 0;
    }

    tr {
        position: relative;
    }

    .editing {
        top: 0;
    }

    #ta1,
    #ta2,
    #datetimepicker1 {
        min-width: 200px;
    }
</style>


<div role="main" class="main">
    <div class="container">
        <div class="row">
            <div class="kol col-12">
                <div class="ayarlar">
                    <a href="gider-ekle" class="ekle"><button class="btn btn-primary">Ekle</button></a>
                    <span class="filtreler"><button class="btn btn-success">Filtreler</button></span>
                    <span class="genel_haritayi_ac"><button class="btn btn-danger">Tüm Giderler</button></span>
                    <span class="gider_raporu"><a href="/rapor" class="btn btn-warning">Gider Raporu</a></span>
                    <span>{{$x}}</span>
                </div>

                <div class="">
                    <table class="table">
                        <thead id="giderler_thead">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tutar</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Açıklama</th>
                                <th scope="col">Tarih</th>
                                <th scope="col">Konum</th>
                                <th>Duzenle</th>
                                <th>Sil</th>
                            </tr>
                        </thead>
                        <tbody id="rehber">
                            @foreach($giderler as $gider)
                            <tr>
                                <td t_id="<?= $gider->id ?>"></td>
                                <td>{{$gider->tutar}} TL</td>
                                <td>{{$gider->kategori}}</td>
                                <td>{{$gider->açıklama}}</td>
                                <td>{{$gider->tarih}}</td>
                                <td><i konum='{{$gider->konum}}' class="fa fa-map-marker {{$gider->konum ? 'konum_var' : ''}}" aria-hidden="true"></i></td>
                                <td><i class="fa fa-edit " aria-hidden="true"></i></td>
                                <td><i class="fa fa-trash" aria-hidden="true"></i></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$giderler->links("pagination::bootstrap-4")}}
                </div>
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
        var ayarlar = {
            toplam_satir_sayisi: 0,
            sayfa_basi_kayit_sayisi: 5,
            toplam_sayfa_sayisi: 0,
            suanki_sayfa: 1
        }
        var filter = {
            ad: "",
            soyad: "",
            telefon: ""
        }
        let konum_goster = false
        let isEditingModeOpen = false

        var tarih_donustur = function(eski_tarih) {
            let date = eski_tarih.split(" ")
            let date_array = date[0].split("-")
            let tarih = ""
            tarih = date_array[1] + "/" + date_array[2] + "/" + date_array[0] + " "
            let hours_array = date[1].split(":")
            let hours = ""
            if (hours_array[0] >= 12) {
                hours = (hours_array[0] - 12) + ":" + hours_array[1] + ":" + hours_array[2] + " PM"
            } else {
                hours = hours_array[0] + ":" + hours_array[1] + ":" + hours_array[2] + " AM"
            }
            return tarih + hours
        }
        $("table").on("click", ".fa-edit", function() {
            isEditingModeOpen = true
            $("table .editing").remove()

            edit_satir = $(this).parents("tr")
            edit_satir.children().each(function(i) {
                if (i == 0) return
                let hucre = edit_satir.children().eq(i)
                let text = hucre.text()
                let height = hucre.outerHeight(true)
                let width = hucre.outerWidth()
                if (i == 4) {
                    let new_datetime = tarih_donustur(text)
                    console.log(new_datetime)
                    hucre.append('<div class = "editing" style="position: absolute; bottom:0"><input style="width:' + width + 'px; height:' + height + 'px" type="text" class="form-control" id="datetimepicker1" value= ""></div>')
                    $('#datetimepicker1').datetimepicker();
                    $('#datetimepicker1').val(new_datetime);
                } else if (i == 5) {
                    hucre.append("<div class = 'ortala konum_goster  editing' style='position: absolute; bottom:0; '><span  style='width:" + width + "px; height:" + height + "px' class='btn btn-secondary'>" + $(this).html() + "</span><input  type='hidden' id='latitude'><input type='hidden' id='longtitude'></div>")
                } else if (i == 6) {
                    hucre.append("<div class = 'ortala konum_sifirla editing' style='position: absolute; bottom:0; '><span style='width:" + width + "px; height:" + height + "px'  class='btn btn-third'><i class='fa fa-undo'></i></span></div>")
                } else if (i == 1) {
                    tutar = text.substr(0, text.length - 3)
                    hucre.append("<div class = 'editing' style='position: absolute; bottom:0'><input style='width:" + width + "px; height:" + height + "px' type = 'number' class = 'form-control' value= '" + tutar + "'></div>")
                } else if (i == 2) {
                    hucre.append("<div class = 'editing' style='position: absolute; bottom:0'><input  type='text' value='" + text + "' style='width:" + width + "px; height:" + height + "px' class = 'form-control' ></div>")
                } else if (i == 3) {
                    hucre.append("<div class = 'editing' style='position: absolute; bottom:0'><textarea style='height:" + height + "px; width:" + width + "px; resize:both; position:absolute; z-index:999' class = 'form-control' >" + text + "</textarea></div>")
                } else {
                    hucre.append("<div class = 'editing' style='position: absolute; bottom:0'><button style='width:" + width + "px; height:" + height + "px' class='bos'></button></div>")
                }
            })
        })
        $("table").on("keypress", "#datetimepicker1", function(event) {
            event.preventDefault();
        });
        $(document).click(function(e) {
            if (!konum_goster) {
                if (isEditingModeOpen && !$(e.target).closest(edit_satir).length) {
                    let editing_tr = $(".editing").parents("tr")

                    let proper_update = true
                    let id = editing_tr.children().eq(0).attr("id")
                    id = $(".editing").parents("tr").children().eq(0).attr("t_id")
                    tutar = ""
                    kategori = ""
                    aciklama = ""
                    tarih = ""
                    let konum = $(".editing").parents("tr").children().eq(5).children("i").attr("konum")
                    console.log(konum)
                    $(".editing").each(function(i) {
                        switch (i) {
                            case 0:
                                tutar = $.trim($(this).find("input").val())
                                break;
                            case 1:
                                kategori = $.trim($(this).find("input").val())
                                break;
                            case 2:
                                aciklama = $(this).find("textarea").val()
                                break;
                            case 3:
                                tarih = $(this).find("input").val()
                                break;
                        }
                    })
                    if (tutar == "") {
                        proper_update = false
                        vt.warn("Tutar alanı boş bırakılamaz.", {
                            position: "top-center",
                            duration: 5000
                        });

                    } else if (kategori == "") {
                        proper_update = false
                        vt.warn("Kategori alanı boş bırakılamaz.", {
                            position: "top-center",
                            duration: 5000
                        });
                    } else if (aciklama == "") {
                        proper_update = false
                        vt.warn("Açıklama alanı boş bırakılamaz.", {
                            position: "top-center",
                            duration: 5000
                        })
                    } else if (tarih == "") {
                        proper_update = false
                        vt.warn("Açıklama alanı boş bırakılamaz.", {
                            position: "top-center",
                            duration: 5000
                        })
                    } else {
                        // console.log(tutar + ", " +kategori + ", " + aciklama + ", " +tarih + ", ")
                        // console.log(id)
                        $.ajax({
                            type: "post",
                            url: '/duzenle',
                            headers: {
                                'X-CSRF-TOKEN': '{{csrf_token()}}'
                            },
                            data: {
                                id: id,
                                tutar: tutar,
                                kategori: kategori,
                                açıklama: aciklama,
                                konum: konum,
                                tarih: new Date(tarih).toISOString().slice(0, 19).replace('T', ' ')
                            },
                            dataType: 'json',
                            success: function(data) {
                                console.log(data)
                                if (data.success) {
                                    vt.success(data.success, {
                                        position: "top-center",
                                        duration: 5000
                                    });
                                } else if (data.warning) {
                                    vt.warn(data.warning, {
                                        position: "top-center",
                                        duration: 5000
                                    });
                                }
                                if (data.success) {
                                    location.href = location.href
                                }
                            }
                        });

                        $(".editing").remove()
                        isEditingModeOpen = false

                    }
                }
            }
        })


        $("table").on("click", ".fa-trash", function() {
            Swal.fire({
                title: 'Silmek istediğinize emin misiniz?',
                showDenyButton: true,
                confirmButtonText: 'Sil',
                denyButtonText: `Vazgeç`,
            }).then((result) => {
                if (result.isConfirmed) {
                    let row = $(this).parents("tr")
                    let id = row.children().eq(0).attr("t_id")
                    $.ajax({
                        type: "post",
                        url: '',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        },
                        data: {
                            id: id
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
                            location.href = "/"
                        }
                    });
                }
            })
        })

        $("table").on("click", ".konum_goster", function() {
            let konumm = $(".editing").parents("tr").children().eq(5).children("i").attr("konum")
            let textarea = $(".editing").parents("tr").children().eq(3).find("textarea")
            textarea.css("z-index", "-1")
            if (konumm != "") {
                let latitude = konumm.split(",")[0]
                let longtitude = konumm.split(",")[1]
                console.log(latitude + "," + longtitude)
                $("#lat").val(latitude)
                $("#lng").val(longtitude)
                initMap(parseFloat(latitude), parseFloat(longtitude))
            } else {
                let latitude = 41.028325
                let longtitude = 28.913060
                $("#lat").val(latitude)
                $("#lng").val(longtitude)
                initMap(parseFloat(latitude), parseFloat(longtitude))
            }
            konum_goster = true
            $(".logo img").css("display", "none")
            $(".map_container").css("display", "block")
        })


        $(".geri_don").click(function(e) {
            e.stopPropagation()
            konum_goster = false
            $(".logo img").css("display", "block")
            $(".map_container").css("display", "none")
            let textarea = $(".editing").parents("tr").children().eq(3).find("textarea")
            textarea.css("z-index", "999")
        })

        $(".konumu_kaydet").click(function(e) {
            e.stopPropagation()
            konum_goster = false
            let konum_ = $(".editing").parents("tr").children().eq(5).children("i").attr("konum", $("#lat").val() + "," + $("#lng").val())
            $("#latitude").val($("#lat").val())
            $("#longtitude").val($("#lng").val())

            $(".editing").parents("tr").children().eq(5).find("div i").addClass("konum_var")

            $(".logo img").css("display", "block")
            $(".map_container").css("display", "none")
            let textarea = $(".editing").parents("tr").children().eq(3).find("textarea")
            textarea.css("z-index", "999")
        })

        $("table").on("click", ".konum_sifirla", function() {
            $(".editing").parents("tr").children().eq(5).children("i").attr("konum", "")
            $(".editing").parents("tr").children().eq(5).find("div i").removeClass("konum_var")
        })

        $(".genel_haritayi_ac").click(function() {
            console.log(locations)
            initMap(0, 0, locations)
            $(".logo img").css("display", "none")
            $(".map_genel").css("display", "block")
        })


        $(".geri_don2").click(function(e) {
            e.stopPropagation()
            konum_goster = false


            $(".logo img").css("display", "block")
            $(".map_genel").css("display", "none")
        })

        let filtere_is_open = false
        $(".filtreler").click(function() {
            console.log(filtere_is_open)
            let tu = JSON.parse(`{{ json_encode($tu) }}`.replace(/&quot;/g, '"'));
            let ta = JSON.parse(`{{ json_encode($ta) }}`.replace(/&quot;/g, '"'));
            let k = (`{{ $k }}`)
            let a = (`{{ $a }}`)
            if (!filtere_is_open) {
                $("#giderler_thead").prepend(
                    '<tr class="filtreler_removal">' +
                    '<th scope="col"></th>' +
                    '<th scope="col"><span>Tutar Aralığı</span></th>' +
                    '<th scope="col"><input value="' + tu[0] + '" id="tu1" class="form-control" type="number"></th>' +
                    '<th scope="col"><input value="' + tu[1] + '" id="tu2" class="form-control" type="number"></th>' +
                    '<th scope="col"></th>' +
                    '<th scope="col"></th>' +
                    '<th></th>' +
                    '<th></th>' +
                    '</tr>' +
                    '<tr class="filtreler_removal">' +
                    '<th scope="col"></th>' +
                    '<th scope="col"><span>Kategori</span></th>' +
                    '<th scope="col"><input value="' + k + '" id="k" class="form-control" type=""text></th>' +
                    '<th scope="col"></th>' +
                    '<th scope="col"></th>' +
                    '<th scope="col"></th>' +
                    '<th></th>' +
                    '<th></th>' +
                    '</tr>' +
                    '<tr class="filtreler_removal">' +
                    '<th scope="col"></th>' +
                    '<th scope="col"><span>Tarih Aralığı</span></th>' +
                    '<th scope="col"><input id="ta1" class="form-control" type=""text></th>' +
                    '<th scope="col"><input id="ta2" class="form-control" type=""text></th>' +
                    '<th scope="col"></th>' +
                    '<th scope="col"></th>' +
                    '<th></th>' +
                    '<th></th>' +
                    '</tr>' +
                    '<tr class="filtreler_removal">' +
                    '<th scope="col"></th>' +
                    '<th scope="col"><span>Açıklama</span></th>' +
                    '<th scope="col"><input value="' + a + '" id="a" class="form-control" type=""text></th>' +
                    '<th scope="col"><button class="sonuclari_filtrele btn btn-primary" type="button">Sonuçları Filtrele</button></th>' +
                    '<th scope="col"></th>' +
                    '<th scope="col"></th>' +
                    '<th></th>' +
                    '<th></th>' +
                    '</tr>'
                )
                $("#ta1").datetimepicker()
                ta[0] != "" ? $("#ta1").val(tarih_donustur(ta[0])) : null
                $("#ta2").datetimepicker()
                ta[1] != "" ? $("#ta2").val(tarih_donustur(ta[1])) : null
                // $("#ta2").val(tarih_donustur(ta[1]))
                filtere_is_open = true
            } else {
                $(".filtreler_removal").remove()
                filtere_is_open = false
            }
        })

        function base64_encode(stringToEncode) {
            const encodeUTF8string = function(str) {
                return encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
                    function toSolidBytes(match, p1) {
                        return String.fromCharCode('0x' + p1)
                    })
            }
            if (typeof window !== 'undefined') {
                if (typeof window.btoa !== 'undefined') {
                    return window.btoa(encodeUTF8string(stringToEncode))
                }
            } else {
                return new Buffer(stringToEncode).toString('base64')
            }
            const b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/='
            let o1
            let o2
            let o3
            let h1
            let h2
            let h3
            let h4
            let bits
            let i = 0
            let ac = 0
            let enc = ''
            const tmpArr = []
            if (!stringToEncode) {
                return stringToEncode
            }
            stringToEncode = encodeUTF8string(stringToEncode)
            do {
                // pack three octets into four hexets
                o1 = stringToEncode.charCodeAt(i++)
                o2 = stringToEncode.charCodeAt(i++)
                o3 = stringToEncode.charCodeAt(i++)
                bits = o1 << 16 | o2 << 8 | o3
                h1 = bits >> 18 & 0x3f
                h2 = bits >> 12 & 0x3f
                h3 = bits >> 6 & 0x3f
                h4 = bits & 0x3f
                // use hexets to index into b64, and append result to encoded string
                tmpArr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4)
            } while (i < stringToEncode.length)
            enc = tmpArr.join('')
            const r = stringToEncode.length % 3
            return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3)
        }

        var getParameterByName = function(name, url = window.location.href) {
            name = name.replace(/[\[\]]/g, '\\$&');
            var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }
        $("#giderler_thead").on("click", ".sonuclari_filtrele", function() {
            let tutar = $("#tu1").val() + "-" + $("#tu2").val()
            let kategori = base64_encode($("#k").val())
            let tarih = ($("#ta1").val() == "" ? "" : new Date($("#ta1").val()).getTime()) + "-" + ($("#ta2").val() == "" ? "" : new Date($("#ta2").val()).getTime())
            let aciklama = base64_encode($("#a").val())
            let url = location.href.toString()
            // var page = getParameterByName("page")
            url = "/?tu=" + tutar + "&k=" + kategori + "&ta=" + tarih + "&a=" + aciklama

            location.href = url
            // console.log(url)
            // console.log("tutar: " + tutar1 + " - " + tutar2)
            // console.log("kategori: " + kategori)
            // console.log("tarih: " + tarih1 + " - " + tarih2)
            // console.log("açıklama: " + aciklama)



        })
        // var searching = false
        // $("#search").click(function() {
        //     if (searching) {
        //         $(".searching").remove()
        //         filter = {
        //             ad: "",
        //             soyad: "",
        //             telefon: ""
        //         }
        //         initialize()
        //     } else {
        //         $("#rehber_thead").append("<tr class='searching'><td></td><td><input class='form-control name_search' placeholder='Ad' type='text'></td><td><input class='form-control surname_search' placeholder='Soyad' type='text'></td><td><input class='form-control phone_search' placeholder='Telefon' type='text'></td><td></td><td></td></tr>")
        //     }
        //     searching = !searching
        // })

        // $(document).on("keyup", function() {
        //     if (searching) {
        //         let name = $(".name_search").val()
        //         filter.ad = name
        //         let surname = $(".surname_search").val()
        //         filter.soyad = surname
        //         let telefon = $(".phone_search").val()
        //         filter.telefon = telefon
        //         initialize()
        //     }
        // })
    })
</script>
<script>

</script>

@endsection