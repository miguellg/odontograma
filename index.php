<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Odontograma</title>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<style>
    #areas_click {
        height: 100%;
        width: 100%;
    }

    #areas_click polygon {
        fill: #e00000;
        opacity: 0.85;
        /*fill:transparent;*/
        cursor: pointer;
        fill-rule: nonzero;
    }

    .polygon-select{
        fill: limegreen !important;
    }

    #areas_click polygon:hover {
        fill: #e00000;
        opacity: 0.85;
    }

    #img_dente_2 {

        /*position: fixed;*/
    }

    area:hover {
        border: 1px solid red;
    }

    ''
</style>
<script>
    $(document).ready(function () {
        var points = '';
        var marcando = false;
        var count = 0;
        $('#marcar').click(function () {
            $("#dente").unbind('dblclick').dblclick(function () {
                var last_pointX = -5;
                var last_pointY = -5;
                var obj = $('.newpoint:first').clone();
                obj.data('id', ++count);
                points = '';
                marcando = true;
                $('#areas_click').append(obj)
                $("#dente").mousemove(function (event) {
                    // Para corrigir problema quando point se perde
                    if(event.offsetX < last_pointX - 15 || event.offsetY < last_pointY - 15 ){
                        return false;
                    }

                    if (event.offsetX > last_pointX + 5 || event.offsetX < last_pointX - 5 || event.offsetY > last_pointY + 5 || event.offsetY < last_pointY - 5) {
                        console.log('marcou');
                        points += " " + (event.offsetX) + ", " + (event.offsetY);
                        $(obj).attr('points', points);
                        last_pointX = event.offsetX;
                        last_pointY = event.offsetY;
                    }
                });
            }).click(function () {
                if(marcando == true) {
                    $("#dente").unbind('mousemove');
                    var obj = $('.newpoint:last');
                    $('#table-hist tbody').append('<tr data-id="'+count+'" data-points="' + points + '"><td>Ponto '+(count)+'</td><td class="desc"></td><td><i class="ico-remove">X</i></td></tr>');
                    marcando = false;
                }
            });
        });
        $('#table-hist tbody').on('mouseover', 'tr', function(){
            $(".newpoint[points='"+$(this).data('points')+"']").addClass('polygon-select');
        }).on('mouseleave', 'tr', function(){
            $('.newpoint').removeClass('polygon-select');
        });
        $('#table-hist tbody').on('click', '.ico-remove', function(){
            var tr = $(this).closest('tr');
            $(".newpoint[points='"+tr.data('points')+"']").remove();
            tr.remove();
        })
        $('#areas_click').on('click', '.newpoint', function(){
            var tab_ref = $('#table-hist tbody tr[data-id='+$(this).data('id')+']');
            if(tab_ref) {
                var procedimento = prompt("O que tem nessa parte ?", tab_ref.find('.desc').text());
                if (!(procedimento == null || procedimento == "")) {
                    tab_ref.find('td.desc').text(procedimento);
                }
            }
        })
    })
</script>
<body>
<div style=" border: 1px solid black; margin: 0 auto; width: 510px; float: left;">
    <div style=" border: 1px solid black; width: 250px; float: left ">
        <div style="width: 250px;">
            Dois cliques pra iniciar a marcação e um clique pra finalizar<br>
            <button id="marcar">Marcar Area</button>
        </div>
        <div id="dente" style="background: url('./dente2.png'); background-repeat: no-repeat; background-size: contain; height: 400px; width: 250px; border: 1px solid black;">
            <svg id="areas_click" style="width: 100%;">
                <polygon class="newpoint" points=""/>
            </svg>
        </div>
    </div>
    <div style=" border: 1px solid black; margin: 0 auto; width: 250px;float: right;">
        <table id="table-hist">
            <thead>
                <tr>
                    <td>Historico</td>
                    <td>Descrição</td>
                    <td>#</td>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
</body>

</html>