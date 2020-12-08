<?php
    require_once "init.php";

    if(Input::exists($_POST)) {
        if(Token::exists(Input::get('token'))) {
            $validate = new Validation();

            $validation = $validate->check($_POST, [
                'email' => [
                    'required' => true,
                    'email'    => true
                ],
                'password' => [
                    'required' => true
                ]
            ]);

            if(Input::get('remember') === 'on') {
                $remember = true;
            }

            if($validation->passed()) {
                $user = new User();
                $user->login(Input::get('email'), Input::get('password'), $remember);
                if($user->isLoggedIn()) {
                    Redirect::to('index.php');
                    Session::flash('success', true);
                } else {
                    Session::flash('info', true);
                }
            } else {
                $errors = $validation->error();
                Session::flash('danger', true);

            }
        }
    }

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register</title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" method="POST" action="">
    	  <img class="mb-4" src="images/apple-touch-icon.png" alt="" width="72" height="72">
    	  <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>

        <?php if(Session::flash('danger')): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php elseif(Session::flash('success')): ?>
            <div class="alert alert-success">
                Вы успешно зарегистрировались!
            </div>
        <?php elseif(Session::flash('info')): ?>
            <div class="alert alert-info">
                Неверный E-mail или пароль!
            </div>
        <?php endif; ?>

    	  <div class="form-group">
          <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo Input::get('email') ?>">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" id="password" name="password" placeholder="Пароль">
        </div>

    	  <div class="checkbox mb-3">
    	    <label>
    	      <input type="checkbox" name="remember"> Запомнить меня
    	    </label>
    	  </div>
          <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
    	  <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
    	  <p class="mt-5 mb-3 text-muted">&copy; 2017-2020</p>
    </form>
</body>
</html>
