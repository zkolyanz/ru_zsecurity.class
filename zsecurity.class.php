<?php
/*
Класс фильтрации/валидации данных, полученых различными методами.
Создан - 15.07.2016 года
Обновлен - 16.07.2016 года
Автор - ZKolyaNZ
Сайт - http://zkolyanz.name/
GitHub - https://github.com/zkolyanz/ru_zsecurity.class
*/

class Zsecurity { # название класса
   public $data=NULL; // публичное свойство, любые входящие данные
   
   public function __construct(){ # функция создания экземпляра
   }
   
   public function __destruct(){ # функция уничтожения экземпляра
   }
   
   public function Zlogin($data,$mask="^[a-zA-Zа-яА-Я0-9\-_\+]",$len="{4,20}"){ 
   # функция проверки/валидации логина, безопасен sql inj/xss
   return (is_array($data)) ? false : ( !preg_match("/{$mask}{$len}$/", $data)) ? false : trim($data);
   unset($data,$mask,$len); // уничтожаем временные данные
   }
   
   public function Zpass($data,$mask="^[a-zA-Zа-яА-Я0-9\-_\+.,!?@#$%^&*():;~|<>'`]",$len="{4,20}"){ 
   # функция проверки/валидации пароля, в конце данные md5() или sha1(), есть уязвимость sql inj/xss
   return (is_array($data)) ? false : ( !preg_match("/{$mask}{$len}$/", $data)) ? false : trim($data);
   unset($data,$mask,$len); // уничтожаем временные данные
   }
   
   public function Zemail($data,$mask = "^([a-zа-я0-9\+_\-]+)(\.[a-zа-я0-9\+_\-]+)*@([a-zа-я0-9\-]+\.)+[a-zа-я]{2,8}"){
   # функция проверки/валидации емейл-адреса, безопасен sql inj/xss
   if(is_array($data) && empty($data) && strlen($data) > 255 && strpos($data,'@') > 64) return false;
   return ( !preg_match("/{$mask}$/ix", $data)) ? false : strtolower(trim($data));
   unset($data,$mask); // уничтожаем временные данные			
   }
   
   public function Zurl($data,$mask="\b(?:(?:https?|ftp):\/\/|www\.)[-a-zа-я0-9+&@#\/%?=~_|!:,.;]*[-a-zа-я0-9+&@#\/%=~_|]"){
   # функция для проверки/валидации адреса сайта, безопасен sql inj/xss
   $data=$this->Zxss($data); //чистим от xss
   return (is_array($data)) ? false : ( !preg_match("/{$mask}/i",$data) ) ? false : trim($data);
   unset($data,$mask); // уничтожаем временные данные
   }
   
   public function Zonlytext($data,$mask="^[a-zA-Zа-яА-Я0-9\-_\+]"){
   # функция для работы с получеными данными, безопасен sql inj/xss
   return (is_array($data)) ? false : ( !preg_match("/{$mask}$/i", $data)) ? false : trim($data);
   unset($data,$mask,$len); // уничтожаем временные данные
   }
   
   public function Zhtml($data){
   # функция для подготовки вставки html в базу данных, есть вероятность sql inj
   $data=$this->Zxss($data); //чистим от xss
   $array_find = array("<?", "?>"); // делаем php-код читабельным
   $array_replace = array("&#60;&#63;", "&#63;&#62;");
   return str_replace($array_find, $array_replace, $data);
   unset($data,$array_find,$array_replace); // уничтожаем временные данные
   }
   
   public function Znohtml($data){ 
   # функция для подготовки вставки в базу, в теории и xss перестает тоже работать, вероятность sql inj
   $array_find = array("<", ">");
   $array_replace = array("&#60;", "&#62;");
   return str_replace($array_find, $array_replace, $data);
   unset($data,$array_find,$array_replace); // уничтожаем временные данные
   }
   
   /*private*/ public function Zsafedb($data){
   # функция для вставки в базу данных, экранизирование  ' " \ и NULL байт, 
   return (is_array($data)) ? false : ( addslashes($data)) ? $data : false;
   unset($data); // уничтожаем временные данные
   }
   
   /*private*/ public function Zxss($data){
   # функция для борьбы с xss уязвимостью, начальный уровень
   $search=array("'<script[^>]*?>.*?</script>'si","'alert\('i","'javascript:'i","'data:'i","'vbscript:'i","'livescript:'i");
   $replace=array("","","","","","");
   return preg_replace($search, $replace, $data);
   unset($search,$replace,$data); // уничтожаем временные данные
   }
   
}
