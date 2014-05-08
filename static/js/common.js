//
var startSlash = (location.href.indexOf('localhost')==-1)? 2:3;
var site_name = 'http://'+window.location.hostname+'/'+window.location.href.split('/')[startSlash]+'/';

$(function(){
    // валидировать форму добавления записей
    $('#admin-form').on('submit', function(){
        var cancelSending = false;
        $('input:text, input[type="email"], input[type="datetime"], input[type="date"], input[type="time"], select', this)
            .each(function(index,element){
                if(this.tagName=='INPUT'&&!this.value){
                    cancelSending=true;
                    return false;
                }
                if(this.tagName=='SELECT'&&$('option:selected',element).index()==0){
                    cancelSending=true;
                    return false;
                }
            });
        if(cancelSending) {
            alert('Указаны не все данные.');
            return false;
        }
    });
	var table_name = $('[name="table"]').val();
    // удалить запись
    $('.db_table tr td:last-child').on('click', function(){
        var rowToDelete = $(this).parent('tr');
        var record_id = $(rowToDelete).find('td:first-child').text();
        //console.log('record id = '+record_id);
        $.ajax({
            // ВНИМАНИЕ: адрес будет обработан роутером
            url: site_name+'admin/'+table_name+'/'+record_id,
            type:'DELETE',
            success:function(data){
                //alert(data);
                if(data==record_id)
                    $(rowToDelete).fadeOut(300);
                else
                    console.log("%cid id удаляемой строки не совпадают...", 'color:red');
            }
        });
    });
    // подгрузить расписание сеансов для зала
    $('a[role="schedule"]').on('click', function(){
        var link = this;
        var myTr = $(this).parents('tr').eq(0);
        var tr = $(myTr).next();
        if(!$(this).attr('data-loaded')) {
            var linkText = extractId($(this).attr('href'));
            var hall_id = linkText.substr(linkText.lastIndexOf("/")+1);
            //console.log('Go schedule! Hall id = '+hall_id);
            $.ajax({
                url:site_name+'api/halls/'+hall_id,
                success:function(data){
                    //console.log(data);
                    var i=0;
                    for(var seance_id in data){
                        i++;
                        $(tr).before('<tr class="hidden">'+
                            '<td align="right">'+i+'</td>'+
                            '<td><a href="'+site_name+'movies/'+data[seance_id]['movie_id']+'">'
                            +data[seance_id]['movie_name']+'</a></td>'+
                            '<td>'+data[seance_id]['showtime']+'</td>'+
                            '<td>'+data[seance_id]['free_seats_numbers']+'</td>'+
                        '</tr>');/*
                        console.log(seance_id);
                        console.log(data[seance_id]['movie_id']);
                        console.log(data[seance_id]['movie_name']);
                        console.log(data[seance_id]['showtime']);
                        console.log(data[seance_id]['free_seats_numbers']);
                        //console.dir(data[seance_id]);

                         [4]=>
                         array(4) {
                         ["movie_id"]=>
                         string(1) "5"
                         ["movie_name"]=>
                         string(33) "Заводной апельсин"
                         ["showtime"]=>
                         string(11) "05.02 20:57"
                         ["free_seats_numbers"]=>
                         string(2) "11"
                         }  */
                    }
                    $(myTr).nextUntil('tr.header').fadeIn(500);
                    $(link).attr('data-loaded',1);
                },
                error:function(){
                    console.log('error. Url: '+site_name+'api/halls/'+hall_id);
                }
            });
        }else{
            $(myTr).nextUntil('tr.header').fadeToggle(500);
        }
        return false;
    });
    // открыть окно выбора мест
    $('#tbl-order button').on('click', function(){
        $(this).parent().css('position', 'relative');
        var btn = this;
        //
        if($('.showplace:visible').size())
            $('.showplace').fadeOut(150,function(){
                console.dir(btn);
                $('.showplace').remove();
                createHall(btn);
            });
        else{
            createHall(btn);
        }
    });
    $(window).on('resize', function(){
        recalculateBoxParams();
    });
});

function extractId(linkText){
    return linkText.substr(linkText.lastIndexOf("/")+1);
}

function createHall(btn){
    var showplace = $('<div/>',{
        id:'hall-places-area',
        class:'showplace'
    }).addClass('showplace')
        .attr('data-seance-id',btn.value);

    $('body').append(showplace);
    //console.log(btn.value);
    $.ajax({
        url:site_name+'api/tickets/taken/'+btn.value,
        success:function(data){
            $('#hall-places-area').load(site_name+'templates/partials/seats_box.php',
                function(){
                    $('#hall-places-area #seats').append(data);
                }); //console.log(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
            console.log('error. Url: '+site_name+'api/tickets/taken/'+btn.value);
        }
    });
    recalculateBoxParams();
    $(showplace).fadeIn(150);
}

function recalculateBoxParams(){
    var box = $('#hall-places-area');
    var seance_id = $(box).attr('data-seance-id');
    var btn = $('button[value="'+seance_id+'"');
    $(box).css({
        width:function(){
            return window.outerWidth/4+'px';
        },
        left:function(){
            var offLeft = $(btn).offset().left+$(btn).outerWidth()+10;
            return offLeft+'px';
        },
        top:function(){
            return $(btn).offset().top-12+'px';
        }
    });
}

