<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperação de Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #b41f1f 0%, #8b1818 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 40px 30px;
            color: #2c3e50;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            padding: 15px 40px;
            background: #b41f1f;
            color: white !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin: 20px 0;
        }
        .button:hover {
            background: #8b1818;
        }
        .footer {
            background: #f5f7fa;
            padding: 20px;
            text-align: center;
            color: #7f8c8d;
            font-size: 14px;
        }
        .alert {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🇵🇹 Tuguinha</h1>
            <p>Recuperação de Password</p>
        </div>
        <div class="content">
            <p>Olá!</p>
            <p>Recebeste este email porque foi solicitada a recuperação da password da tua conta.</p>

            <div style="text-align: center;">
                <a href="{{ $url }}" class="button">Redefinir Password</a>
            </div>

            <div class="alert">
                <strong>⚠️ Atenção:</strong> Este link de recuperação expira em {{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire') }} minutos.
            </div>

            <p>Se não solicitaste a recuperação da password, podes ignorar este email em segurança.</p>

            <p>Cumprimentos,<br>
            <strong>Equipa Tuguinha</strong></p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} Tuguinha. Todos os direitos reservados.</p>
            <p>Este é um email automático, por favor não respondas.</p>
        </div>
    </div>
</body>
</html>
