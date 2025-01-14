<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login Formular</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="form-section">
            <h2>🔒 Registrierung</h2>
            <form action="<?= site_url('registration/submit') ?>" method="POST">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="user" class="form-label">User</label>
                        <input type="user" class="form-control" id="user" name="user" required>
                        <div class="valid-feedback">
                            Das sieht gut aus!
                        </div>
                        <div class="invalid-feedback">
                            Bitte geben Sie einen validen Username ein.
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Passwort</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="valid-feedback">
                            Das sieht gut aus!
                        </div>
                        <div class="invalid-feedback">
                            Bitte gebe ein valides Passwort ein.
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Absenden</button>
            </form>
        </div>
    </div>
</body>
</html>