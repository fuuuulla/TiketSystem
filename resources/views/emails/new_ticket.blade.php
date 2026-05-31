<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Ticket</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f4f8; color: #2d3748; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 36px 32px; text-align: center; }
        .header h1 { color: #fff; font-size: 26px; font-weight: 700; margin-bottom: 6px; }
        .header p { color: rgba(255,255,255,0.85); font-size: 14px; }
        .badge { display: inline-block; background: rgba(255,255,255,0.2); color: #fff; border-radius: 20px; padding: 4px 14px; font-size: 13px; margin-top: 10px; }
        .body { padding: 32px; }
        .section-title { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #a0aec0; margin-bottom: 16px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 28px; }
        .info-item { background: #f7fafc; border-radius: 8px; padding: 14px 16px; border-left: 3px solid #667eea; }
        .info-item .label { font-size: 11px; color: #a0aec0; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .info-item .value { font-size: 15px; color: #2d3748; font-weight: 600; }
        .info-item.full { grid-column: 1 / -1; }
        .status-badge { display: inline-block; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; background: #fef3c7; color: #92400e; }
        .cta { text-align: center; margin-top: 28px; }
        .cta a { display: inline-block; background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-weight: 700; font-size: 15px; }
        .footer { background: #f7fafc; padding: 20px 32px; text-align: center; font-size: 12px; color: #a0aec0; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>🎫 Nouveau Ticket Reçu</h1>
        <p>Un utilisateur vient de soumettre une nouvelle demande</p>
        <span class="badge">Ticket #{{ $ticket->id }}</span>
    </div>

    <div class="body">
        <div class="section-title">Informations du demandeur</div>

        <div class="info-grid">
            <div class="info-item full">
                <div class="label">Nom complet</div>
                <div class="value">{{ $ticket->nom_complet }}</div>
            </div>
            <div class="info-item">
                <div class="label">Téléphone</div>
                <div class="value">{{ $ticket->telephone }}</div>
            </div>
            <div class="info-item">
                <div class="label">Société</div>
                <div class="value">{{ $ticket->societe ?? 'N/A' }}</div>
            </div>
            <div class="info-item full">
                <div class="label">Adresse</div>
                <div class="value">{{ $ticket->adresse }}</div>
            </div>
            <div class="info-item">
                <div class="label">Hébergement demandé</div>
                <div class="value">{{ $ticket->hosting->nom ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="label">Statut actuel</div>
                <div class="value"><span class="status-badge">⏳ En attente</span></div>
            </div>
            <div class="info-item">
                <div class="label">Email utilisateur</div>
                <div class="value">{{ $ticket->user->email ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="label">Date de soumission</div>
                <div class="value">{{ $ticket->created_at->format('d/m/Y à H:i') }}</div>
            </div>
        </div>

        
    <div class="footer">
        <p>Cet email a été envoyé automatiquement par <strong>{{ config('app.name') }}</strong>.</p>
        <p style="margin-top: 4px;">{{ now()->format('d/m/Y à H:i') }}</p>
    </div>
</div>
</body>
</html>
