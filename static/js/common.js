$(function(){
    var startSlash = (location.href.indexOf('localhost')==-1)? 2:3;
    var site_name = 'http://'+window.location.hostname+'/'+window.location.href.split('/')[startSlash]+'/';

    $('.user_status').on('click', function(){
        console.log('url= '+site_name+'api/user_status.php');
        $.get(
            site_name+'api/user_status.php',
            {'role':this.getAttribute('role')},
            onAjaxSuccess
        );
    });
});
function onAjaxSuccess(data)
{
    // Здесь мы получаем данные, отправленные сервером и выводим их на экран.
    alert('Установлен статус: '+data);
}