$(function(){

    var startSlash = (location.href.indexOf('localhost')==-1)? 2:3;
    var site_name = 'http://'+window.location.hostname+'/'+window.location.href.split('/')[startSlash]+'/';

    $('select[name="movies_id"]').on('change', function(){

        $.ajax({
            url: site_name+'api/tables/halls/',
            data:{
                filter:'movie',
                'id':$('option:selected',this).val()
            },
            success:function(data){
                alert('OK: '+data);
            }
        });
    });
});
