<?php
session_start(); //Запускаем сессию
if ($_SESSION['auth']) { //проверяем авторизованного пользователя
  //Подключаем файл (подключение к БД)
  require realpath('include/db.php');
  global $conn; // Получаем переменную с подключением к БД
  $query = "Select * from специальности"; //создаем запрос к БД 
  $result = mysqli_query($conn, $query); //Выполняем запрос
} else {
  //Если пользователь не авторизован, перенаправляем его на страницу авторизации
  header('Location: /index.php');
  return;
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/style.css">
  <title>Специальности</title>
</head>

<body>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h4>Специальности</h4>
          <div class="menu_header">
            <div class="menu__item">
              <ul class="link_menu">
                <li><a href="group.php">Группы</a></li>
                <li><a href="students.php">Студенты</a></li>
                <li><a href="specialties.php">Специальности</a></li>
              </ul>
            </div>
            <div class="menu__item">
              <form class="form_search" action="search.php" method="post">
                <input class="form-control" name="search" type="text" required placeholder="Поиск">
                <button class="btn btn-warning">Найти</button>
              </form>
            </div>
          </div>
          <div class="block__table">
            <table class="table">
              <thead>
                <tr>
                  <th>Код специальности</th>
                  <th>Полное название</th>
                  <th>Краткое название</th>
                  <th>Шифр специальности</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($result) {
                  while ($r = mysqli_fetch_array($result)) {
                ?>
                <tr>
                  <td><?php echo $r['Код_специальности']; ?></td>
                  <td><?php echo $r['Полное_название']; ?></td>
                  <td><?php echo $r['Краткое_название']; ?></td>
                  <td><?php echo $r['Шифр_специальности']; ?></td>
                </tr>
                <?php
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>