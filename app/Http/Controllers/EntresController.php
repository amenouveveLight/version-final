<?php

namespace App\Http\Controllers;

use App\Models\Entres;
use App\Models\Sorties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;

class EntresController extends Controller
{
    public function create()
    {
        return view('entres'); // Formulaire d'entrée
    }

    public function store(Request $request)
    {
        // 1. Validation du formulaire
        $validated = $request->validate([
            'plaque' => 'required|string|max:255',
            'type'   => 'required|string',
            'name'   => 'nullable|string|max:255',
            'phone'  => 'nullable|string|max:20',
        ]);

         // 2. Rechercher la dernière entrée pour cette plaque ET type
        $lastEntry = Entres::where('plaque', $validated['plaque'])
                            ->where('type', $validated['type'])
                            ->latest()
                            ->first();

        if ($lastEntry) {
            // 3. Vérifie s’il y a une sortie correspondante
            $hasExit = Sorties::where('plaque', $validated['plaque'])
                            ->where('type', $validated['type'])
                            ->where('created_at', '>=', $lastEntry->created_at)
                            ->exists();

            if (!$hasExit) {
                return back()->withErrors([
                    'plaque' => 'Ce véhicule est déjà présent dans le parking.'
                ])->withInput();
            }

            // Si nom ou téléphone non fourni, on reprend ceux de la dernière entrée
            if (empty($validated['name'])) {
                $validated['name'] = $lastEntry->name;
            }

            if (empty($validated['phone'])) {
                $validated['phone'] = $lastEntry->phone;
            }

            if (empty($validated['phone'])) {
                $validated['phone'] = $lastEntry->phone;
            } 
         
              if (empty($validated['name'])) {
             return back()->withErrors(['name' => 'Veuillez compléter le nom.'])->withInput();
            }

            if (empty($validated['phone'])) {
            return back()->withErrors(['phone' => 'Veuillez compléter le numéro de téléphone.'])->withInput();
            }


        }

        // 4. Enregistrer l’entrée
        $entree = Entres::create([
            'plaque' => $validated['plaque'],
            'type'   => $validated['type'],
            'name'   => $validated['name'],
            'phone'  => $validated['phone'],
            'user_id' => auth()->id(),
        ]);

     //  $pdf = Pdf::loadView('ticket-entree', compact('entree'))
              //     ->setPaper([0, 0, 270, 400], 'portrait'); // format mini-ticket

     // return $pdf->stream('ticket-entree.pdf');
     // return view('entres') ->with('success', "Entrée enrégistrée avec succès.");
      return redirect()->back()
        ->with('success', "Entrée enregistrée avec succès.")
        ->with('ticket_url', route('entres.ticket', $entree->id)); // On prépare l'URL du ticket
     
}




    // 🔹 Affichage détail entrée
    public function show($id)
    {
        $entree = Entres::findOrFail($id);
        return view('entres.show', compact('entree'));
    }

    // 🔹 Formulaire édition
    public function edit($id)
{
    $entree = Entres::findOrFail($id);

    $hasSortie = Sorties::where('plaque', $entree->plaque)
                        ->where('created_at', '>', $entree->created_at)
                        ->exists();

    if ($hasSortie) {
        return redirect()->route('recent')
            ->with('error', "Cette entrée ne peut pas être modifiée car elle a déjà une sortie.");
    }

    return view('entres.edit', compact('entree'));
}


    // 🔹 Mise à jour entrée
    public function update(Request $request, $id)
    {
        $entree = Entres::findOrFail($id);

        $validated = $request->validate([
            'plaque' => 'required|string|max:255',
            'type'   => 'required|string',
            'name'   => 'required|string|max:255',
            'phone'  => 'required|string|max:20',
        ]);

        $entree->update($validated);

        return back()->with('success', 'Entrée mise à jour.');
    }

    // 🔹 Suppression entrée
   public function destroy($id)
{
    $entree = Entres::findOrFail($id);

    // Vérifier si une sortie existe pour cette entrée
    $hasSortie = Sorties::where('plaque', $entree->plaque)
                        ->where('created_at', '>', $entree->created_at)
                        ->exists();

    if ($hasSortie) {
        return redirect()->route('recent')
            ->with('error', "Cette entrée ne peut pas être supprimée car elle a déjà une sortie.");
    }

    $entree->delete();

    return redirect()->route('recent')
        ->with('success', "Entrée supprimée avec succès.");
}

public function ticket($id)
{
    $entree = Entres::findOrFail($id);

    $pdf = Pdf::loadView('ticket-entree', compact('entree'))
        ->setPaper([0, 0, 270, 400], 'portrait');

    return $pdf->stream('ticket-entree.pdf');
}


}

 