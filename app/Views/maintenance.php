<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Maintenance</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: url('assets/images/maintenance.webp') no-repeat center center/cover;
      color: #ffffff;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.6);
    }

    .container {
      position: relative;
      text-align: center;
      padding: 20px;
      max-width: 500px;
      z-index: 1;
    }

    h1 {
      font-size: 36px;
      margin-bottom: 15px;
    }

    p {
      font-size: 18px;
      line-height: 1.5;
      opacity: 0.9;
    }
  </style>
</head>

<body>
  <div class="overlay"></div>

  <div class="container">
    <h1>Kami Segera Kembali</h1>
    <p>
      Website sedang dalam perbaikan.<br>
      Silakan kembali beberapa saat lagi.
    </p>
  </div>
</body>

</html>