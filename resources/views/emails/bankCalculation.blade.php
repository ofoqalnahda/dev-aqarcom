<!DOCTYPE html>
<html>
<head>
    <title>New Mail</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .card h2 {
            margin: 0 0 10px;
        }
        .card p {
            margin: 0;
            margin-bottom: 10px;
        }
        .card strong {
            display: inline-block;
            width: 100px;
        }
        .logo {
            display: block;
            max-width: 150px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="container">

    <div class="card">
        <h2>نتيجة حسبة البنك</h2>
        <p><strong>الاسم:</strong> {{ $calc->name}}</p>
        <p><strong>رقم الهوية:</strong> {{ $calc->national_id }}</p>
        <p><strong>الوظيفة:</strong> {{ $calc->job }} - {{$calc->job_name}}</p>
        <p><strong>الرد:</strong> {{ $calc->result }}</p>




    </div>
</div>
</body>
</html>
