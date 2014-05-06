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
});
