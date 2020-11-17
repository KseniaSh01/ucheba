<?php
session_start(); //Запускаем сессию
//Если пользователь авторизован
if ($_SESSION['auth']) {
  //Перенаправляем на другую страницу и выходим
  header('Location: /group.php');
  return;
}
if ($_POST) {
  //Подключаем файл (подключение к БД)
  require realpath('include/db.php');
  /* 
 При получение данных с сайта необходимо обернуть их в функцию htmlspecialchars
 это поможет обезопасить БД от не нужных знаков. 
 */
  $login = htmlspecialchars($_POST['login']); // Получение логина
  $password = htmlspecialchars(($_POST['password'])); // Получение пароля

  //Проверка пришли все данные или нет
  if ($login && $password) {
    global $conn; // Получаем переменную с подключением к БД
    $query = "Select login from users where login = '$login'"; //создаем запрос к БД с проверкой, есть ли такой пользователь
    $result = mysqli_query($conn, $query); //Выполняем запрос
    if (!mysqli_num_rows($result)) { //проверяем есть ли такой пользователь
      $query_insert = "INSERT INTO users (`login`,`password`) VALUES ('$login','$password')";
      $result_insert = mysqli_query($conn, $query_insert);
      if ($result_insert) { //Если запрос выполнен успешно
        $result_text = 'Вы успешно зарегистрировались <a href="index.php">Войти</a>';
      } else {
        $result_text = 'Ошибка запроса';
      }
    } else {
      //Выводим сообщение если пользователь уже существует
      $result_text = 'Пользователь с таким логином уже существует';
    }
  } else {
    //Выводим сообщение если какие то поля пустые
    $result_text = 'Все поля должны быть заполнены';
  }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/style.css">
  <title>Регистрация</title>
</head>

<body>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="auth__block">
            <form method="POST" action="register.php">
              <h5>Регистрация</h5>
              <div class="form-group">
                <label for="exampleInputEmail1">Логин</label>
                <input type="text" required <?php
                                            //Если пользовател авторизован, то запрещаем поля ввода (можно убрать)
                                            if ($_SESSION['auth']) {
                                              echo 'disabled';
                                            } ?> name="login" class="form-control">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Пароль</label>
                <input type="password" required <?php
                                                //Если пользовател авторизован, то запрещаем поля ввода (можно убрать)
                                                if ($_SESSION['auth']) {
                                                  echo 'disabled';
                                                } ?> name="password" class="form-control">
              </div>
              <button type="submit" <?php
                                    //Если пользовател авторизован, то запрещаем поля ввода (можно убрать)
                                    if ($_SESSION['auth']) {
                                      echo 'disabled';
                                    } ?> class="btn btn-primary">Зарегистрироваться</button>
              <p class="register_result"><?php echo $result_text; ?></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>