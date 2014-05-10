//
var site_name='cinema-rest';

$(function(){
    // установить параметры роутинга
    if(location.href.indexOf(site_name)==-1){
        alert("Имя сайта указано неправильно, роутинг может не работать."+
            "\nПроверьте значение глобальной пер. \"site_name\", "+
            "устанавливаемой в начале файла common.js.");
        return false;
    }else
        site_name = location.href.substr(0,location.href.indexOf(site_name)+site_name.length)+'/';
    //console.log('site_name: '+site_name);

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
    // удалить запись админом
    $('.db_table tr td:last-child').on('click', function(){
        var rowToDelete = $(this).parent('tr');
        var record_id = $(rowToDelete).find('td:first-child').text();
        var Url = site_name+'includes/admin/delete.php?table='+table_name+'&id='+record_id;
        $.ajax({
            //
            url: Url,
            //type:'DELETE',
            success:function(data){
                //alert(data);
                if(data==record_id)
                    $(rowToDelete).fadeOut(300);
                else{
                    console.log("%cid id удаляемой строки не совпадают.", 'color:red');
                    console.log('URL: '+Url+'\nrecord_id: '+record_id+'\ndata: '+data);
                }
            },
            error:function(){
                console.log('error. Url: '+site_name+'api/halls/'+hall_id);
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
            console.log('Url = '+site_name+'api/halls/'+hall_id);
            $.ajax({
                url:site_name+'api/halls/'+hall_id,
                success:function(data){
                    console.log(data);
                    var i=0;
                    for(var seance_id in data){
                        i++;
                        $(tr).before('<tr class="hidden">'+
                            '<td align="right">'+i+'</td>'+
                            '<td><a href="'+site_name+'movies/'+data[seance_id]['movie_id']+'">'
                            +data[seance_id]['movie_name']+'</a></td>'+
                            '<td>'+data[seance_id]['showtime']+'</td>'+
                            '<td>'+data[seance_id]['free_seats_numbers']+'</td>'+
                        '</tr>');
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
    $('[role="show_hall_places"]').on('click', function(){
        var cinemaHall=null,
            btn = this;
        if(cinemaHall=getBox())
            $(cinemaHall).fadeOut(150,function(){
                $(cinemaHall).remove();
                createHall(btn);
            });
        else{
            createHall(btn);
        }
    });
    // переопраделить параметры окна выбора мест
    $(window).on('resize', function(){
        recalculateBoxParams();
    });
    // установить активного юзера
    $('#user-list').on('change', function(){
        setActiveUser($('option:selected', this));
    });
});

function createHall(btn){

    var cinemaHall = $('<div/>',{
        id:'hall-places-area'
    });

    var Td = $(btn).parent();
    $(Td).css('position', 'relative')
        .append(cinemaHall);
    //console.log('btn, Td, cinemaHall: ');
    //console.dir(btn);console.dir(Td);console.dir(cinemaHall);
    $(cinemaHall)
        .css({
            left:calculateOffsetLeft(Td)+'.px',
            top:calculateOffsetTop(Td)+'.px'
        })
        .html('Загрузка&nbsp;информации о наличии свободных мест в кинозале...')
        .attr('data-seance-id',btn.value)
        .fadeIn(800, function(){
        //console.log('btn parent:'); console.dir(Td);
        $.ajax({
            url:site_name+'api/tickets/taken/'+btn.value,
            success:function(data){
                $(getBox()).load(site_name+'templates/partials/seats_box.php',
                    function(){
                        $('#seats', getBox()).append(data);
                        recalculateBoxParams();
                        $('input:hidden[name="seance_id"]').val(btn.value);
                        //console.log('btn.value = '+btn.value);
                        $('body').append(cinemaHall);
                    }); //console.log(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
                console.log('error. Url: '+site_name+'api/tickets/taken/'+btn.value);
            }
        });
    });
}
function extractId(linkText){
    return linkText.substr(linkText.lastIndexOf("/")+1);
}
function getBox(){
    return document.getElementById('hall-places-area');
}
function hideBox(){
    var box = getBox();
    $(box).fadeOut(300, function(){
        $(box).remove();
    });
}
function recalculateBoxParams(){
    var box = getBox();
    var all_seats = $('label', box).size(),
        seance_id = $(box).attr('data-seance-id');
    var btn = $('button[value="'+seance_id+'"');
    $(box).css({
        width:function(){
            var maxW = window.outerWidth/100*60;
            //console.log(window.outerWidth+'/('+window.outerWidth+'/'+all_seats+'/'+6+')');
            var ww = window.outerWidth*8*all_seats/window.outerWidth;
            if (ww>maxW) ww = maxW;
            return ww+'px';
        },
        left:function(){
            var offLeft = calculateOffsetLeft(btn, true);
            return offLeft+'px';
        },
        top:function(){
            var maxH = window.innerHeight;
            var offTop = calculateOffsetTop(btn, true);
            if($(box).height()+offTop>maxH){
                offTop=10;
                $(box).css('max-height', maxH-24+'px');
            }
            return offTop+'px';
        }
    });
}
function calculateOffsetLeft(btnPlace,fromPage){ //console.dir(btnPlace);
    return (fromPage)?
        $(btnPlace).offset().left+$(btnPlace).outerWidth()+10
            : $(btnPlace).width()+10;
}
function calculateOffsetTop(btnPlace, fromTop){ //console.dir(btnPlace);
    return (fromTop)?
        $(btnPlace).offset().top-12
            : $(btnPlace).height()-100;
}
function setActiveUser(selected_option){
    var user_id     = $(selected_option).val(),
        user_name   = $(selected_option).text(),
        Url         = site_name+'includes/admin/handle_session_data.php?user_id='+user_id;
    $.ajax({
        url:Url,
        success: function(data){
            alert('Welcome, '+user_name);
            console.log('user_id: '+data+':'+user_id+'\nUrl: '+Url);
        },
        error:function(){
            console.log('error. Url: '+site_name+'api/halls/'+hall_id);
        }
});
}

