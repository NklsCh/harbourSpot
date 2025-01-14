<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login erfolgreich</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-success">✅ Login erfolgreich!</h2>
                        <div class="alert alert-success mt-4">
                            Sie wurden erfolgreich eingeloggt.
                        </div>
                        
                        <div class="mt-4">
                            <h4>Ihre Login-Daten:</h4>
                            <table class="table">
                                <tr>
                                    <th>Login:</th>
                                    <td><?= esc($user) ?></td>
                                </tr>
                                <tr>
                                    <th>Passwort:</th>
                                    <td><?= esc($password) ?></td>
                                </tr>
                            </table>
                        </div>

                        <div class="mt-4">
                            <a href="<?= site_url('/') ?>" class="btn btn-primary">Zurück zum Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>