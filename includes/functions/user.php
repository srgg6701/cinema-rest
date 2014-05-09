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
     *
     */
}