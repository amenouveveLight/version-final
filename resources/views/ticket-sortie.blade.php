<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ticket de Sortie - {{ $sortie->plaque }}</title>
  <style>
    /* Configuration de la page pour imprimante thermique */
    @page {
      size: 80mm auto;
      margin: 0; /* On gère les marges dans le body pour éviter les coupures */
    }

    body {
      font-family: 'Arial', sans-serif;
      font-size: 12px;
      color: #000;
      margin: 0;
      padding: 10px;
      width: 72mm; /* Largeur utile réelle pour éviter les débordements */
      background-color: #fff;
    }

    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .bold { font-weight: bold; }

    .logo {
      max-width: 50px;
      height: auto;
      display: block;
      margin: 0 auto 5px auto;
      /* Si impression depuis navigateur, asset() est préférable à public_path() */
    }

    .title {
      font-size: 15px;
      font-weight: bold;
      margin-top: 5px;
      padding: 8px 0;
      border-top: 1px dashed #000;
      border-bottom: 1px dashed #000;
      text-transform: uppercase;
    }

    .date {
      font-size: 10px;
      margin: 5px 0 10px 0;
      color: #333;
    }

    .section {
      margin: 12px 0;
    }

    .section-title {
      font-weight: bold;
      margin-bottom: 5px;
      border-bottom: 1px solid #000;
      font-size: 12px;
      text-transform: uppercase;
      text-align: center;
    }

    /* Remplacement de flexbox par table pour une meilleure compatibilité imprimante */
    .info-table {
      width: 100%;
      border-collapse: collapse;
    }

    .info-table td {
      padding: 2px 0;
      vertical-align: top;
    }

    .label {
      width: 40%;
      text-align: left;
      font-size: 11px;
    }

    .value {
      width: 60%;
      text-align: right;
      font-weight: bold;
      font-size: 11px;
    }

    .total-line {
      font-size: 14px;
      margin-top: 5px;
      padding-top: 5px;
      border-top: 1px double #000;
    }

    .dashed-separator {
      border-top: 1px dashed #000;
      margin: 15px 0;
    }

    .footer {
      font-size: 10px;
      margin-top: 10px;
      line-height: 1.4;
    }

    /* Cacher les éléments inutiles à l'impression */
    @media print {
      .no-print { display: none; }
    }
  </style>
</head>
<body>

  <!-- Note: public_path est pour DomPDF, asset() est pour le navigateur -->
  <img src="{{ asset('images/T.png') }}" alt="Logo" class="logo">

  <div class="text-center">
    <div class="title">
      REÇU DE SORTIE<br>
      N° {{ str_pad($sortie->id, 6, '0', STR_PAD_LEFT) }}
    </div>
    <div class="date italic">Émis le {{ now()->format('d/m/Y à H:i') }}</div>
  </div>

  <div class="section">
    <div class="section-title">Véhicule</div>
    <table class="info-table">
      <tr>
        <td class="label">Plaque :</td>
        <td class="value">{{ strtoupper($entree->plaque) }}</td>
      </tr>
      <tr>
        <td class="label">Type :</td>
        <td class="value">{{ ucfirst($entree->type) }}</td>
      </tr>
      @if($entree->name)
      <tr>
        <td class="label">Propriétaire :</td>
        <td class="value">{{ $entree->name }}</td>
      </tr>
      @endif
    </table>
  </div>

  <div class="section">
    <div class="section-title">Facturation</div>
    <table class="info-table">
      <tr>
        <td class="label">Arrivée :</td>
        <td class="value">{{ $entree->created_at->format('d/m/y H:i') }}</td>
      </tr>
      <tr>
        <td class="label">Départ :</td>
        <td class="value">{{ $sortie->created_at->format('d/m/y H:i') }}</td>
      </tr>
      <tr>
        <td class="label">Durée :</td>
        <td class="value">{{ $joursPasses }} jour(s)</td>
      </tr>
      <tr>
        <td class="label">Paiement :</td>
        <td class="value">{{ ucfirst($sortie->paiement) }}</td>
      </tr>
      <tr class="total-line">
        <td class="label bold">TOTAL :</td>
        <td class="value" style="font-size: 16px;">{{ number_format($montantTotal, 0, ',', ' ') }} F</td>
      </tr>
    </table>
  </div>

  <div class="section text-center">
    <span style="font-size: 9px;">Agent: {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</span>
  </div>

  <div class="dashed-separator"></div>

  <div class="footer text-center">
    Merci pour votre confiance<br>
    À bientôt et bonne route !<br>
    <strong style="font-size: 13px;">VIROSCOPE</strong>
  </div>

  <script>
    window.onload = function () {
      window.print();
      // Optionnel : fermer la fenêtre après impression
      // window.onafterprint = function() { window.close(); };
    }
  </script>

</body>
</html>