<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation mot de passe</title>
    <style>
        body {
            font-family: monospace;
            background-color: #000;
            color: #fff;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
        }
        .header {
            font-size: 2.5rem;
            font-weight: 900;
            letter-spacing: 0.2em;
            margin-bottom: 30px;
            color: #3b82f6;
        }
        .content {
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            background-color: #3b82f6;
            color: #fff;
            padding: 14px 28px;
            text-decoration: none;
            font-weight: 600;
            margin: 20px 0;
            border: none;
        }
        .button:hover {
            background-color: #2563eb;
        }
        .footer {
            font-size: 0.8rem;
            color: #666;
            margin-top: 30px;
            border-top: 1px solid #333;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">OPaK</div>
        
        <div class="content">
            <p>Bonjour,</p>
            <p>Vous avez demandé la réinitialisation de votre mot de passe.</p>
        </div>
        
        <a href="{{ $url }}" class="button">Réinitialiser</a>
        
        <div class="content">
            <p>Ce lien expire dans 60 minutes.</p>
            <p>Si vous n'avez pas demandé cette réinitialisation, ignorez cet email.</p>
        </div>
        
        <div class="footer">
            <p>— OPaK</p>
        </div>
    </div>
</body>
</html>