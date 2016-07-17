<?php
/*
Класс фильтрации/валидации данных, полученых различными методами.
Версия - 1.0.1 , Создан - 15.07.2016 года , Обновлен - 17.07.2016 года
Автор - ZKolyaNZ
Сайт - https://zkolyanz.name/
GitHub - https://github.com/zkolyanz/ru_zsecurity.class
FAQ - https://forum.antichat.ru/threads/443271/
*/

class Zsecurity { # название класса
   public $data=NULL; // публичное свойство, любые входящие данные
   
   public function Zlogin($data,$mask="^[a-zA-Zа-яА-Я0-9\-_\+]",$len="{4,20}"){ 
   # функция проверки/валидации логина
   return (is_array($data)) ? false : ( !preg_match("/{$mask}{$len}$/", $data)) ? false : trim($data);
   }
   
   public function Zpass($data,$mask="^[a-zA-Zа-яА-Я0-9\-_\+.,!?@#$%^&*():;~|<>'`]",$len="{4,20}"){ 
   # функция проверки/валидации пароля, в конце данные md5() или sha1()
   return (is_array($data)) ? false : ( !preg_match("/{$mask}{$len}$/", $data)) ? false : trim($data);
   }
   
   public function Zemail($data,$mask = "^([a-zа-я0-9\+_\-]+)(\.[a-zа-я0-9\+_\-]+)*@([a-zа-я0-9\-]+\.)+[a-zа-я]{2,8}"){
   # функция проверки/валидации емейл-адреса
   if(is_array($data) && empty($data) && strlen($data) > 255 && strpos($data,'@') > 64) return false;
   return ( !preg_match("/{$mask}$/ix", $data)) ? false : strtolower(trim($data));
   }
   
   public function Zurl($data,$mask="\b(?:(?:https?|ftp):\/\/|www\.)[-a-zа-я0-9+&@#\/%?=~_|!:,.;]*[-a-zа-я0-9+&@#\/%=~_|]"){
   # функция для проверки/валидации адреса сайта
   return (is_array($data)) ? false : ( !preg_match("/{$mask}/i",$data) ) ? false : trim($data);
   }
   
   public function Zonlytext($data,$mask="^[a-zA-Zа-яА-Я0-9\-_\+]"){
   # функция для работы с получеными данными
   return (is_array($data)) ? false : ( !preg_match("/{$mask}$/i", $data)) ? false : trim($data);
   }
   
   public function Zhtml($data){
   # функция для подготовки вставки html в базу данных
   $array_find = array("<?", "?>"); // делаем php-код читабельным
   $array_replace = array("&#60;&#63;", "&#63;&#62;");
   return str_replace($array_find, $array_replace, $data);
   }
   
   public function Znohtml($data){ 
   # функция для подготовки вставки в базу
   $array_find = array("<", ">"); // делаем практически любой код читабельным
   $array_replace = array("&#60;", "&#62;");
   return str_replace($array_find, $array_replace, $data);
   }
   
}
?>
