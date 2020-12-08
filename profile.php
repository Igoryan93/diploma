<?php
    require_once "init.php";
    $user = new User(Session::get(Config::get('session.session_user')));

    if(Session::get(Config::get('session.session_user')) !== $_GET['id'] && !$user->hasPermission('admin')) {
        Session::flash('danger', true);
        Redirect::to('index.php');
        exit;
    }

    $userByGet = new User($_GET['id']);

    if(Input::exists($_POST)) {
        if(Token::exists(Input::get('token'))) {
            $validate = new Validation();

            $validation = $validate->check($_POST, [
                'username' => [
                    'required' => true,
                    'min'      => 3
                ]
            ]);

            if($validation->passed()) {
                $userByGet->update($_GET['id'], [
                    'username' => Input::get('username'),
                    'text'     => Input::get('text')
                ]);
                Redirect::to('flash.php?id=' . $_GET['id']);

            } else {
                $errors = $validation->error();
                Session::flash('danger', true);
            }
        }
    }



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
              <?php if(Session::get(Config::get('session.session_user'))): ?>
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
       <div class="col-md-8">
         <h1>Профиль пользователя - <?php echo $userByGet->data()->username ?></h1>
           <?php if(Session::flash('danger')): ?>
             <div class="alert alert-danger">
                 <ul>
                     <?php foreach ($errors as $error) : ?>
                         <li><?php echo $error ?></li>
                     <?php endforeach; ?>
                 </ul>
             </div>
           <?php elseif(Session::flash('success')) : ?>
              <div class="alert alert-success">
                  Ваш профиль был изменен!
              </div>
           <?php endif; ?>
           <ul>
           <li><a href="changepassword.php?id=<?php echo $userByGet->data()->id ?>">Изменить пароль</a></li>
         </ul>
         <form action="" class="form" method="POST">
           <div class="form-group">
             <label for="username">Имя</label>
             <input type="text" id="username" class="form-control" name="username" value="<?php echo $userByGet->data()->username ?>">
           </div>
           <div class="form-group">
             <label for="status">Статус</label>
             <input type="text" id="status" class="form-control" name="text" value="<?php echo $userByGet->data()->text ?>">
           </div>

             <input type="hidden" name="token" value="<?php echo Token::generate() ?>">

           <div class="form-group">
             <button class="btn btn-warning">Обновить</button>
           </div>
         </form>


       </div>
     </div>
   </div>
</body>
</html>