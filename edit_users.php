<?php
    require_once "init.php";
    $users = Database::getInstance()->get('users', ['id', '>', '0'])->result();

    $user = new User(Session::get(Config::get('session.session_user')));

    if(!$user->hasPermission('admin')) {
        Session::flash('danger', true);
        Redirect::to('index.php');
        exit;
    }

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Users</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
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
    <div class="col-md-12">
        <h1>Пользователи</h1>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Действия</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user->id; ?></td>
                    <td><?php echo $user->username; ?></td>
                    <td><?php echo $user->email; ?></td>
                    <td>
                        <?php if($user->group_id == 2): ?>
                            <a href="action/userRoleDelete.php?id=<?php echo $user->id; ?>" class="btn btn-danger">Разжаловать</a>
                        <?php else: ?>
                            <a href="action/userRole.php?id=<?php echo $user->id; ?>" class="btn btn-success">Назначить администратором</a>
                        <?php endif; ?>
                        <a href="user_profile.php?id=<?php echo $user->id; ?>"class="btn btn-info">Посмотреть</a>
                        <a href="profile.php?id=<?php echo $user->id; ?>" class="btn btn-warning">Редактировать</a>
                        <a href="action/delete.php?id=<?php echo $user->id; ?>" class="btn btn-danger" onclick="return confirm('Вы уверены?');">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
