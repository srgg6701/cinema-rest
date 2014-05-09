<?php
class User{

    // массив ссылок для получения данных сервиса
    public static $resources_links = array( //
        'seances'  =>'Просмотр расписания сеансов по кинотеатрам/залам',
        'movies'   =>'Просмотр расписания сеансов выбранного фильма',
        'seats'    =>'Проверка наличия свободных мест на сеанс',
        'order'    =>'Заказ билетов',
        'cancel'   =>'Отмена заказа билетов (не позже, чем за час до начала сеанса).'
    );
    /**
     * Список доступных юзеру опций
     */
    public static function getUserOptions($listing=false){
        if($listing){
            $links='';
            $as_link=true;
            foreach(self::$resources_links as $link=>$text){
                if($as_link){
                    $links.='<li>
                <a href="'.SITE_ROOT.$link.'">'.$text.'</a>
            </li>';
                    $as_link=false;
                }
                else{
                    $links.='<li>'.$text.'</li>';
                }
            }
            return $links;
        }
        else
            return self::$resources_links;
    }
    /**
     * Создать список юзеров
     */
    public static function makeUserList(){
        global $connect;
        ?>
        <select name="user_list" id="user-list">
    <?php $query = "SELECT
          id,username
     FROM user
    ORDER BY username";
    $result = $connect->query($query, PDO::FETCH_ASSOC);
        foreach ($result as $i=>$row) {
            // если нет активного юзера, установить дефолтного
            if(!isset($_SESSION['active_user_id'])&&!$i)
                $_SESSION['active_user_id']=$row['id'];?>
                <option value="<?php echo $row['id'];
            if($_SESSION['active_user_id']==$row['id']){
            ?>" selected<?php
            }?>><?php echo $row['username']; ?></option>
            <?php
        }
    echo "ACTIVE USER ID: ".$_SESSION['active_user_id'];
    ?>
        </select>
<?php
    }
}