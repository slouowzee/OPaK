<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation mot de passe</title>
    <style>
        @font-face {
            font-family: 'IBMPlexMono';
            src: url('../assets/font/IBMPlexMono-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        body {
            font-family: 'IBMPlexMono', monospace;
            background-color: #000;
            color: #fff;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            border: 1px solid #dc2626;
            padding: 30px;
        }
        .header {
            font-size: 2rem;
            font-weight: 900;
            letter-spacing: 0.2em;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            background-color: #dc2626;
            color: #fff;
            padding: 12px 24px;
            text-decoration: none;
            font-weight: 600;
            margin: 20px 0;
        }
        .button:hover {
            background-color: #b91c1c;
        }
        .footer {
            font-size: 0.8rem;
            color: #666;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">OPaK</div>
        
        <div class="content">
            <p>Bonjour,</p>
            <p>Vous avez demandé la réinitialisation de votre mot de passe sur OPaK.</p>
            <p>Cliquez sur le bouton ci-dessous pour créer un nouveau mot de passe :</p>
        </div>
        
        <a href="{{ $url }}" class="button">Réinitialiser mon mot de passe</a>
        
        <div class="content">
            <p>Ce lien expire dans 60 minutes.</p>
            <p>Si vous n'avez pas demandé cette réinitialisation, vous pouvez ignorer cet email.</p>
        </div>
        
        <div class="footer">
            <p>— L'équipe OPaK</p>
        </div>
    </div>
</body>
</html>