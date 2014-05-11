<?php
class User{

    // массив ссылок для получения данных сервиса
    public static $resources_links = array( //
        'seances'       =>array('Просмотр расписания сеансов по кинотеатрам/залам', 'link'),
        'movies'        =>'Просмотр расписания сеансов выбранного фильма',
        'seats'         =>'Проверка наличия свободных мест на сеанс',
        'order'         =>'Заказ билетов',
        'orders'        =>array('Просмотр заказанных билетов.', 'link'),
        'cancel'        =>'Отмена заказа билетов (не позже, чем за час до начала сеанса).'
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
                        $links.='<li class="no_marker">
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
     * Обработать данные кинозала и вернуть в виде HTML
     */
    public static function showSeancePlaces($all_places,$taken_places){
        $current_user_id = $_SESSION['active_user_id'];
        $seatsHTML = '';
        //
        foreach(range(1,(int)$all_places) as $current_place){
            $label='<label>';
            $hidden='';
            $input_name = ' name="seat_'.$current_place.'"';
            $HTML='<input id="seat_'.$current_place.'" type="checkbox"';
            // проверить, не занято ли место, и, если да, то не текущим ли юзером
            foreach ($taken_places as $user_id=>$user_taken_places) {
                if(in_array($current_place,$user_taken_places)){
                    $HTML.=' checked disabled';
                    if($user_id==$current_user_id){
                        // перезаписывает ранее созданный
                        $label='<label class="mine">';
                        // нужен для отправки данных отмеченных (и заблокированных) чекбоксов
                        $hidden='<input type="hidden" ' . $input_name .
                            ' value="'.$current_place.'">';
                    }
                }else
                    $HTML.=$input_name;
            }
            $HTML.=' value="'.$current_place.'">';
            $HTML.=$current_place;
            $seatsHTML.=$label.$HTML.'</label>'.$hidden;
        }
        return $seatsHTML;
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