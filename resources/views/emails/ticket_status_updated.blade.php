<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mise à jour de votre demande</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f4f8; color: #2d3748; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { padding: 36px 32px; text-align: center; }
        .header.validated { background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); }
        .header.canceled  { background: linear-gradient(135deg, #fc8181 0%, #e53e3e 100%); }
        .header.pending   { background: linear-gradient(135deg, #f6ad55 0%, #dd6b20 100%); }
        .header h1 { color: #fff; font-size: 26px; font-weight: 700; margin-bottom: 6px; }
        .header p  { color: rgba(255,255,255,0.85); font-size: 14px; }
        .badge { display: inline-block; background: rgba(255,255,255,0.2); color: #fff; border-radius: 20px; padding: 4px 14px; font-size: 13px; margin-top: 10px; }
        .body { padding: 32px; }
        .greeting { font-size: 18px; font-weight: 600; margin-bottom: 12px; color: #2d3748; }
        .message { font-size: 15px; color: #4a5568; line-height: 1.7; margin-bottom: 28px; }
        .status-box { border-radius: 10px; padding: 20px 24px; text-align: center; margin-bottom: 28px; }
        .status-box.validated { background: #f0fff4; border: 2px solid #48bb78; }
        .status-box.canceled  { background: #fff5f5; border: 2px solid #fc8181; }
        .status-box.pending   { background: #fffaf0; border: 2px solid #f6ad55; }
        .status-box .icon { font-size: 40px; margin-bottom: 8px; }
        .status-box .label { font-size: 18px; font-weight: 700; }
        .status-box.validated .label { color: #276749; }
        .status-box.canceled  .label { color: #9b2c2c; }
        .status-box.pending   .label { color: #7b341e; }
        .section-title { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #a0aec0; margin-bottom: 16px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 28px; }
        .info-item { background: #f7fafc; border-radius: 8px; padding: 14px 16px; border-left: 3px solid #667eea; }
        .info-item .label { font-size: 11px; color: #a0aec0; font-weight: 600; text-transform: uppercase; margin-bottom: 4px; }
        .info-item .value { font-size: 15px; color: #2d3748; font-weight: 600; }
        .cta { text-align: center; margin-top: 10px; }
        .cta a { display: inline-block; background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-weight: 700; font-size: 15px; }
        .footer { background: #f7fafc; padding: 20px 32px; text-align: center; font-size: 12px; color: #a0aec0; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
@if($nouveauStatut === 'validated')
    @php $icon = '✅'; $statusLabel = 'Demande Validée'; $statusText = 'Votre demande a été <strong>validée</strong> ! Notre équipe va vous contacter prochainement.'; @endphp
@elseif($nouveauStatut === 'canceled')
    @php $icon = '❌'; $statusLabel = 'Demande Annulée'; $statusText = 'Votre demande a malheureusement été <strong>annulée</strong>. Contactez-nous pour plus d\'informations.'; @endphp
@else
    @php $icon = '⏳'; $statusLabel = 'En Attente'; $statusText = 'Votre demande est en cours d\'examen par notre équipe.'; @endphp
@endif

<div class="wrapper">
    <div class="header {{ $nouveauStatut }}">
        <h1>{{ $icon }} Mise à jour de votre demande</h1>
        <p>Le statut de votre ticket a changé</p>
        <span class="badge">Ticket #{{ $ticket->id }}</span>
    </div>

    <div class="body">
        <p class="greeting">Bonjour {{ $ticket->nom_complet }},</p>
        <p class="message">{!! $statusText !!}</p>

        <div class="status-box {{ $nouveauStatut }}">
            <div class="icon">{{ $icon }}</div>
            <div class="label">{{ $statusLabel }}</div>
        </div>

        <div class="section-title">Détails de votre demande</div>
        <div class="info-grid">
            <div class="info-item">
                <div class="label">Hébergement</div>
                <div class="value">{{ $ticket->hosting->nom ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="label">Date de soumission</div>
                <div class="value">{{ $ticket->created_at->format('d/m/Y') }}</div>
            </div>
        </div>

        <div class="cta">
            <a href="{{ url('/dashboard') }}">Voir mes demandes →</a>
        </div>
    </div>

    <div class="footer">
        <p>Cet email a été envoyé automatiquement par <strong>{{ config('app.name') }}</strong>.</p>
        <p style="margin-top: 4px;">{{ now()->format('d/m/Y à H:i') }}</p>
    </div>
</div>
</body>
</html>
