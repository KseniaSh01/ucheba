<?php
session_start(); //Запускаем сессию
if ($_SESSION['auth']) { //проверяем авторизованного пользователя
  if ($_POST['search']) { //проверяем есть ли текст для поиска
    //Подключаем файл (подключение к БД)
    require realpath('include/db.php');
    $search = htmlspecialchars($_POST['search']);
    global $conn; // Получаем переменную с подключением к БД
    $query = "Select s.* from студенты s
    left join группы g on g.Код_группы = s.Код_группы
    where g.Название_группы like '%$search%'"; //создаем запрос к БД c подключением таблицы группы

    /*
    $query = "Select s.* from студенты s
    where s.Название_группы like '%$search%'"; //создаем запрос к БД без подключения таблицы группы
    */

    $result = mysqli_query($conn, $query); //Выполняем запрос
  } else {
    echo 'Пустой запрос';
  }
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
  <title>Результат запроса "<?php echo $search; ?>"</title>
</head>

<body>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h4>Результат запроса "<?php echo $search; ?>"</h4>
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
                  <th>Код студента</th>
                  <th>ФИО</th>
                  <th>Дата рождения</th>
                  <th>Домашний адрес</th>
                  <th>Контактный телефон</th>
                  <th>Email</th>
                  <th>Номер договора</th>
                  <th>Название группы</th>
                  <th>Код группы</th>
                  <th>Контактная информация родителя</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($result) {
                  while ($r = mysqli_fetch_array($result)) {
                ?>
                <tr>
                  <td><?php echo $r['Код_студента']; ?></td>
                  <td><?php echo $r['ФИО']; ?></td>
                  <td><?php echo $r['Дата_рождения']; ?></td>
                  <td><?php echo $r['Домашний_адрес']; ?></td>
                  <td><?php echo $r['Контактный_телефон']; ?></td>
                  <td><?php echo $r['Email']; ?></td>
                  <td><?php echo $r['Номер_договора']; ?></td>
                  <td><?php echo $r['Название_группы']; ?></td>
                  <td><?php echo $r['Код_группы']; ?></td>
                  <td><?php echo $r['Контактная_информация_родителя']; ?></td>
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