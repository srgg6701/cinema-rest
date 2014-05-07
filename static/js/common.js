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
	//
    var startSlash = (location.href.indexOf('localhost')==-1)? 2:3;
    var site_name = 'http://'+window.location.hostname+'/'+window.location.href.split('/')[startSlash]+'/';
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
                //$(this).attr('href');
            var hall_id = linkText.substr(linkText.lastIndexOf("/")+1);
            console.log('Go schedule! Hall id = '+hall_id);
            $.ajax({
                url:site_name+'api/halls/get.php?id='+hall_id,
                success:function(data){
                    //console.log(data);
                    var i=0;
                    for(var seance_id in data){
                        i++;
                        $(tr).before('<tr class="hidden">'+
                            '<td align="right">'+i+'</td>'+
                            '<td><a href="'+site_name+'seances/'+seance_id+'">'
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
                    console.log('error. Url: '+site_name+'api/halls/get.php?id='+hall_id);
                }
            });
        }else{
            $(myTr).nextUntil('tr.header').fadeToggle(500);
        }
        return false;
    });
});

function extractId(linkText){
    return linkText.substr(linkText.lastIndexOf("/")+1);
}

