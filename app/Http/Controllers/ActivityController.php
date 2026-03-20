<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entres;
use App\Models\Sorties;
use Illuminate\Support\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class ActivityController extends Controller
{
    /**
     * Détails d'une entrée
     */
  public function show($id)
{
    $entree = Entres::findOrFail($id);

    // Vérifier si une sortie existe pour cette entrée
    $hasSortie = Sorties::where('plaque', $entree->plaque)
                        ->where('created_at', '>', $entree->created_at)
                        ->exists();

    return view('entres.show', compact('entree', 'hasSortie'));
}

    /**
     * Détails d'une sortie
     */
    public function Sortie($id)
    {
        $sortie = Sorties::findOrFail($id);
        return view('sorties.show', compact('sortie'));
    }

    /**
     * Historique des activités
     */
    public function activites(Request $request)
    {
        $user = auth()->user();

        $plaque = $request->input('plaque');
        $type   = $request->input('type');
        $periode = $this->resolvePeriode($request->input('periode'));

        $activites = collect();

        /*
        |--------------------------------------------------------------------------
        | AGENT : uniquement ses actions
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'agent') {

            // Entrées
            $entres = Entres::where('user_id', $user->id);
            $entres = $this->applyFilters($entres, $plaque, $type, $periode)->get();

            foreach ($entres as $entre) {
                $t = Carbon::parse($entre->created_at);

                $activites->push([
                    'id'        => $entre->id,
                    'source'    => 'entree',
                    'plaque'    => $entre->plaque,
                    'evenement' => 'Entrée',
                    'name'      => $entre->name ?? '-',
                    'type'      => ucfirst($entre->type),
                    'date'      => $t->format('d/m/Y'),
                    'entre'     => $t->format('H:i'),
                    'sortie'    => '-',
                    'duree'     => '-',
                    'statut'    => 'Enregistrée',
                ]);
            }

            // Sorties
            $sorties = Sorties::where('user_id', $user->id);
            $sorties = $this->applyFilters($sorties, $plaque, $type, $periode)->get();

            foreach ($sorties as $sortie) {
                $t = Carbon::parse($sortie->created_at);

                $activites->push([
                    'id'        => $sortie->id,
                    'source'    => 'sortie',
                    'plaque'    => $sortie->plaque,
                    'evenement' => 'Sortie',
                    'name'      => $sortie->owner_name ?? '-',
                    'type'      => ucfirst($sortie->type),
                    'date'      => $t->format('d/m/Y'),
                    'entre'     => '-',
                    'sortie'    => $t->format('H:i'),
                    'duree'     => '-',
                    'statut'    => 'Effectuée',
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | ADMIN / GÉRANT : historique global
        |--------------------------------------------------------------------------
        */
        else {

            $entres  = $this->applyFilters(Entres::query(), $plaque, $type, $periode)->get();
            $sorties = $this->applyFilters(Sorties::query(), $plaque, $type, $periode)
                ->get()
                ->groupBy('plaque');

            foreach ($entres as $entre) {
                $t1 = Carbon::parse($entre->created_at);

                $sortie = optional($sorties[$entre->plaque] ?? collect())
                    ->firstWhere('created_at', '>', $entre->created_at);

                $t2 = $sortie ? Carbon::parse($sortie->created_at) : null;

                $activites->push([
                    'id'        => $entre->id,
                    'source'    => 'entree',
                    'plaque'    => $entre->plaque,
                    'evenement' => $sortie ? ' Sortie':'Entrée'  ,
                    'name'      => $entre->name ?? '-',
                    'type'      => ucfirst($entre->type),
                    'date'      => $t1->format('d/m/Y'),
                    'entre'     => $t1->format('H:i'),
                    'sortie'    => $t2 ? $t2->format('H:i') : '-',
                    'duree'     => $t2 ? $t1->diff($t2)->format('%hh %imin') : '-',
                    'statut'    => $sortie ? 'Complété' : 'En attente',
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | TRI + PAGINATION
        |--------------------------------------------------------------------------
        */
        $activites = $activites
            ->sortBy(fn ($a) =>
                strtotime($a['date'].' '.($a['entre'] !== '-' ? $a['entre'] : $a['sortie']))
            )
            ->values();

        $page = $request->input('page', 1);
        $perPage = 15;

        $activites = new LengthAwarePaginator(
            $activites->forPage($page, $perPage),
            $activites->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('recent', compact(
            'activites',
            'plaque',
            'type',
            'periode'
        ));
    }

    /**
     * Appliquer les filtres communs
     */
    private function applyFilters($query, $plaque, $type, $periode)
    {
        if ($plaque) {
            $query->where('plaque', 'like', "%$plaque%");
        }

        if ($type) {
            $query->where('type', $type);
        }

        if ($periode) {
            $query->whereBetween('created_at', [$periode['from'], $periode['to']]);
        }

        return $query;
    }

    /**
     * Convertir la période sélectionnée
     */
    private function resolvePeriode($periode)
    {
        if (!$periode) return null;

        return match ($periode) {
            'jour'    => ['from' => now()->startOfDay(),   'to' => now()->endOfDay()],
            'semaine' => ['from' => now()->startOfWeek(),  'to' => now()->endOfWeek()],
            'mois'    => ['from' => now()->startOfMonth(), 'to' => now()->endOfMonth()],
            'année'   => ['from' => now()->startOfYear(),  'to' => now()->endOfYear()],
            default   => null,
        };
    }
}
