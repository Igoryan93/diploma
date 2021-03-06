<?php
    session_start();
    require_once "init.php";

    $users = Database::getInstance()->get('users', ['id', '>', '0'])->result();
    $user = new User(Session::get(Config::get('session.session_user')));

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">User Management</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="#">Главная</a>
          </li>
            <?php if ($user->hasPermission('admin')) :?>
                <li class="nav-item">
                    <a class="nav-link" href="edit_users.php">Управление пользователями</a>
                </li>
            <?php endif; ?>
        </ul>

        <ul class="navbar-nav">
          <?php if($user->isLoggedIn()): ?>
              <li class="nav-item">
                  <a href="profile.php?id=<?php echo $user->data()->id ?>" class="nav-link">Профиль</a>
              </li>
              <li class="nav-item">
                  <a href="logout.php" class="nav-link">Выйти</a>
              </li>
          <?php else: ?>
              <li class="nav-item">
                  <a href="login.php" class="nav-link">Войти</a>
              </li>
              <li class="nav-item">
                  <a href="register.php" class="nav-link">Регистрация</a>
              </li>
          <?php endif; ?>
        </ul>
      </div>
    </nav>

  <div class="container">


      <div class="row">
          <div class="col-md-12">
              <?php if(Session::flash('danger')): ?>
                <div class="alert alert-danger">
                    У вас не достаточно прав!
                </div>
              <?php endif; ?>
              <?php if(Session::get(Config::get('session.session_user'))): ?>
                <div class="jumbotron">
                    <h1 class="display-4">Привет, <?php echo $user->data()->username ?></h1>
                </div>
              <?php else: ?>
                  <div class="jumbotron">
                      <h1 class="display-4">Привет, мир!</h1>
                      <p class="lead">Это дипломный проект по разработке на PHP. На этой странице список наших пользователей.</p>
                      <hr class="my-4">
                      <p>Чтобы стать частью нашего проекта вы можете пройти регистрацию.</p>
                      <a class="btn btn-primary btn-lg" href="register.php" role="button">Зарегистрироваться</a>
                  </div>
              <?php endif ?>

          </div>
      </div>

    <div class="row">
      <div class="col-md-12">
        <h1>Пользователи</h1>
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Имя</th>
              <th>Email</th>
              <th>Дата</th>
            </tr>
          </thead>

          <tbody>
           <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user->id ?></td>
                <td><a href="user_profile.php?id=<?php echo $user->id ?>"><?php echo $user->username ?></a></td>
                <td><?php echo $user->email ?></td>
                <td><?php echo $user->date ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>