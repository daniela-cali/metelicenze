<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f9f9f9;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 600px;
      margin: 20px auto;
      background: #fff;
      border-radius: 8px;
    }

    .header {
      background: #000;
      color: #fff;
      padding: 20px;
      text-align: center;
    }

    .content {
      padding: 30px;
      line-height: 1.6;
    }

    .footer {
      font-size: 12px;
      color: #666;
      text-align: center;
      padding: 15px;
      background: #f1f1f1;
    }

    .button {
      display: inline-block;
      margin-top: 20px;
      padding: 12px 24px;
      background: #000;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
    }

    .details {
      background: #f8f9fa;
      padding: 10px;
      border: 1px solid #dee2e6;
      border-radius: 5px;
    }

    .details p {
      margin: 0 0 5px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>MeTe Licenze</h1>
    </div>
    <div class="title"><?= esc($title) ?></div>
    <div class="content">
      <?= $content ?>
    </div>
    <div class="footer">
      &copy; <?= date('Y') ?> MeTe Licenze - Tutti i diritti riservati.
    </div>
  </div>
</body>

</html>