<!doctype html>
<html lang="en">
<head>
  <title>Login - Simple Dashboard</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="./css/custom.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
  <div class="card p-4 shadow-sm" style="width: 300px;">
    <h1 class="h3 mb-3 fw-normal text-center">Přihlášení</h1>
    
    <form action="index.php" method="POST">
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="E-mailová adresa" required>
      </div>
      <div>
        <input type="password" name = "password" class="form-control" placeholder="Heslo" required>
      </div>
      <div>
         <?php if(isset($login_error)) echo $login_error;  ?>
      </div>
        <button class="w-100 btn btn-primary mt-3" type="submit">Přihlásit</button>
    </form>
    
  </div>
</body>
</html>