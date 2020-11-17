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
    $query = "Select login from users where login = '$login' and password='$password'"; //создаем запрос к БД с проверкой, есть ли такой пользователь
    $result = mysqli_query($conn, $query); //Выполняем запрос
    $user = mysqli_fetch_assoc($result); //преобразуем ответ из БД в нормальный массив PHP
    if (!empty($user)) { // Проверка на пустой массив
      session_start();
      $_SESSION['auth'] = true; //Записываем в сессию состояние
      $_SESSION['person_id'] = $user['id']; //Записываем в сессию id пользователя
      header('Location: /group.php');
    } else {
      $result_text = 'Не верный логин или пароль!';
    }
  } else {
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
  <title>Вход</title>
</head>

<body>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="auth__block">
            <form method="POST" action="">
              <h5>Авторизация</h5>
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
              <button type="submit" class="btn btn-primary" <?php
                                                            //Если пользовател авторизован, то запрещаем поля ввода (можно убрать)
                                                            if ($_SESSION['auth']) {
                                                              echo 'disabled';
                                                            } ?>>Войти</button>
              <?php
              //Если пользователь не авторизован, то показываем ссылку на регистрацию
              if (!$_SESSION['auth']) {
                echo '<a class="register" href="register.php">Регистрация</a>';
              } ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>