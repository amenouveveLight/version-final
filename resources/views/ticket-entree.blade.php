<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <style>
    @page { size: 80mm auto; margin: 0; }
    body { font-family: 'Courier New', Courier, monospace; font-size: 12px; width: 80mm; margin: 0; padding: 10px; text-align: center; }
    .logo { max-width: 50px; margin-bottom: 5px; }
    .title { font-weight: bold; font-size: 14px; border-bottom: 1px dashed #000; padding-bottom: 5px; margin-bottom: 5px; }
    .info { text-align: left; margin-bottom: 10px; }
    .info-line { display: flex; justify-content: space-between; margin-bottom: 2px; }
    .footer { border-top: 1px dashed #000; padding-top: 5px; font-size: 10px; }
    /* Masquer tout bouton si affiché par erreur */
    @media print { .no-print { display: none; } }
  </style>
</head>
<body>
    <img src="{{ asset('images/T.png') }}" class="logo">
    <div class="title">TICKET D'ENTRÉE #{{ str_pad($entree->id, 5, '0', STR_PAD_LEFT) }}</div>
    <div style="font-size: 10px; margin-bottom: 10px;">{{ now()->format('d/m/Y H:i') }}</div>

    <div class="info">
        <div class="info-line"><span>PLAQUE :</span> <strong>{{ strtoupper($entree->plaque) }}</strong></div>
        <div class="info-line"><span>TYPE :</span> <span>{{ ucfirst($entree->type) }}</span></div>
        <div class="info-line"><span>CLIENT :</span> <span>{{ $entree->name ?? 'Anonyme' }}</span></div>
        <div class="info-line"><span>AGENT :</span> <span>{{ Auth::user()->firstname }}</span></div>
    </div>

    <div class="footer">
        Viroscope - Merci de votre visite<br>
        Gardez ce ticket précieusement.
    </div>
</body>
</html>