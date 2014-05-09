<?php
class User{

    // массив ссылок для получения данных сервиса
    public static $resources_links = array( //
        'seances'  =>array('Просмотр расписания сеансов по кинотеатрам/залам', 'link'),
        'movies'   =>'Просмотр расписания сеансов выбранного фильма',
        'seats'    =>'Проверка наличия свободных мест на сеанс',
        'order'    =>'Заказ билетов',
        'cancel'   =>array('Отмена заказа билетов (не позже, чем за час до начала сеанса).', 'link')
    );
    /**
     * Список доступных юзеру опций
     */
    public static function getUserOptions($listing=false){
        if($listing){
            $links='';
            foreach(self::$resources_links as $link=>$text){
                if(is_array($text)){
                    if($text[1]=='link'){
                        $links.='<li>
                <a href="'.SITE_ROOT.$link.'">'.$text[0].'</a>
            </li>';
                    }
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
    ORDER BY username"; //echo "<div>$query</div>";
    $result = $connect->query($query, PDO::FETCH_ASSOC);
        foreach ($result as $i=>$row) {
            // если нет активного юзера, установить дефолтного
            if(!isset($_SESSION['active_user_id'])&&!$i)
                $_SESSION['active_user_id']=$row['id'];?>
                <option value="<?php
                echo $row['id'];
                ?>"<?php
            if($_SESSION['active_user_id']==$row['id']){
            ?> selected<?php
            }?>><?php echo $row['username']; ?></option>
            <?php
        }
    echo "ACTIVE USER ID: ".$_SESSION['active_user_id'];
    ?>
        </select>
<?php
    }
    /**
     * Установить заголовок секции для юзера
     */
    public static function setSectionHeader($segment){
        return is_array(self::$resources_links[$segment]) ?
            self::$resources_links[$segment][0]
            : self::$resources_links[$segment];
    }
}