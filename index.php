<?php
# Буфер начало
ob_start();

# Время выполнение и размер памяти для скрипта
$sistem_time=microtime(); 
$sistem_ram=memory_get_usage();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=WINDOWS-1251" />
</head>
<body>
<?php
# Установка magic_quotes (runtime,sybase) на off
ini_set("magic_quotes_runtime",0);
ini_set("magic_quotes_sybase",0);
# Если gpc включена
if(get_magic_quotes_gpc() == 1){
foreach(@$_GET as $key => $value)@$_GET[$key]=stripslashes($value); // массив _GET
foreach(@$_POST as $key => $value)@$_POST[$key]=stripslashes($value); // массив _POST
foreach(@$_COOKIE as $key => $value)@$_COOKIE[$key]=stripslashes($value); // массив _COOKIE
foreach(@$_REQUEST as $key => $value)@$_REQUEST[$key]=stripslashes($value); // массив _REQUEST
}

# Установка кодировки для отображения на сайте
header('Content-Type: text/html; charset=windows-1251', true);

# Подзагрузка класса фильтров безопасности
include('zsecurity.class.php');

// POST
if(isset($_POST['ok_post'])){
    
# Создание экземпляра класса
$Zsecurity=new Zsecurity();
    
# Использование класса
$login=$Zsecurity->Zlogin($_POST['login']);
$pass=$Zsecurity->Zpass($_POST['pass']);
$email=$Zsecurity->Zemail($_POST['email']);
$url=$Zsecurity->Zurl($_POST['url']);
$onlytext=$Zsecurity->Zonlytext($_POST['onlytext']);
$html=$Zsecurity->Zhtml($_POST['html']);
$nohtml=$Zsecurity->Znohtml($_POST['nohtml']);

#print_r($_POST);

// Выводим результаты
echo "Ввод логина - ".$_POST['login']." | Фильтр логина - ".$login."<br />";
echo "Ввод пароля - ".$_POST['pass']." | Фильтр пароля - ".$pass."<br />";
echo "Ввод емейла - ".$_POST['email']." | Фильтр емейла - ".$email."<br />";
echo "Ввод url - ".$_POST['url']." | Фильтр url - ".$url."<br />";
echo "Ввод onlytext - ".$_POST['onlytext']." | Фильтр onlytext - ".$onlytext."<br />";
echo "Ввод html - ".$_POST['html']." | Фильтр html - ".$html."<br />";
echo "Ввод nohtml - ".$_POST['nohtml']." | Фильтр nohtml - ".$nohtml."<br />";

}else{
    
?>
<form method='POST' action=''>
Логин:<br />
<textarea name="login"></textarea><br />
<br />
Пароль:<br />
<textarea name="pass"></textarea><br />
<br />
Емейл-адрес:<br />
<textarea name="email"></textarea><br />
<br />
url:<br />
<textarea name="url"></textarea><br />
<br />
onlytext:<br />
<textarea name="onlytext"></textarea><br />
html:<br />
<textarea name="html"></textarea><br />
nohtml:<br />
<textarea name="nohtml"></textarea><br />
<input type='submit' name='ok_post' value='Отправить' />
</form>
<?php
    
}

?>
<br /> Время выполнение скрипта - {-TIME-} с. , размер выделеной памяти - {-RAM-} кб.
</body>
</html>
<?php
# Буфер очистка кеша
$content=ob_get_contents();

# Считаем время выполнения и затраченую память на скрипт
$sistem_time_end=round(microtime()-$sistem_time,3);
$sistem_ram_end=round((memory_get_usage()-$sistem_ram)/1024,2);

ob_end_clean();

# Необходимые замены
$content = str_replace("{-TIME-}",$sistem_time_end,$content);
$content = str_replace("{-RAM-}",$sistem_ram_end,$content);

# Вывод текста
echo $content;

# Завершение скрипта
exit();
?>
