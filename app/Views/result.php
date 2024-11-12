<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Results</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .result-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="result-container bg-white">
            <h2 class="text-center mb-4">Form Submission Results</h2>
            
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= ucfirst($form_type) ?> Form Data:</h5>
                    
                    <?php if($form_type === 'registration'): ?>
                        <p><strong>Username:</strong> <?= $username ?></p>
                        <p><strong>Email:</strong> <?= $email ?></p>
                        <p><strong>Password:</strong> <?= $password ?></p>
                        <p><strong>Terms Accepted:</strong> <?= $terms ? 'Yes' : 'No' ?></p>
                    <?php else: ?>
                        <p><strong>Email:</strong> <?= $email ?></p>
                        <p><strong>Password:</strong> <?= $password ?></p>
                        <p><strong>Remember Me:</strong> <?= isset($remember) ? 'Yes' : 'No' ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="<?= base_url($form_type === 'registration' ? 'register' : 'login') ?>" class="btn btn-primary">Back to Form</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>