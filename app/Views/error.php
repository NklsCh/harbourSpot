<!-- app/Views/error.php -->
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Fehler - HarbourSpot</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-danger">
            <h4 class="alert-heading">Fehler!</h4>
            <p><?= esc($message) ?></p>
        </div>
        <a href="/" class="btn btn-primary">Zurück zur Startseite</a>
    </div>
</body>
</html>