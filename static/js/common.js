$(function(){
    $('#admin-form').on('submit', function(){
        //alert('test!');
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
    /*var startSlash = (location.href.indexOf('localhost')==-1)? 2:3;
    var site_name = 'http://'+window.location.hostname+'/'+window.location.href.split('/')[startSlash]+'/';

    $('select[name="movies_id"]').on('change', function(){

        $.ajax({
            url: site_name+'api/admin/halls/filter/movie/'+$('option:selected',this).val(),
            success:function(data){
                alert(data);
            }
        });
    });*/
});
