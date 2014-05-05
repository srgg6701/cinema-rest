$(function(){
    $('#user_admin, #user_spectator').on('click', function(){
        $.get(
            'api/user_status.php',
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