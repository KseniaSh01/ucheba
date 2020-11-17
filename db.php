<?php
$db_name = 'kontingent'; //Название базы данных
$db_host = 'localhost'; // Хост (обычно это localhost)
$db_user = 'mysql'; // Имя пользователя для подключения к БД
$db_pass = 'mysql'; // Пароль для подключения к БД

//Выполняем подключение к БД
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
//Задаем кодировку БД
mysqli_set_charset($conn, "utf8");