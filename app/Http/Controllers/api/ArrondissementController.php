<?php

namespace App\Http\Controllers\api;

use App\Models\Commune;
use Illuminate\Http\Request;
use App\Models\Arrondissement;
use App\Http\Controllers\Controller;

/**
 * @group Arrondissements
 *
 * Requêtes sur les arrondissements
 */
class ArrondissementController extends Controller
{
    public function index()
    {
        $arrondissements = Arrondissement::all();
        return response()->json($arrondissements);
    }

    /**
     * Récupère les quartiers d'un arrondissement d'une commune spécifique
     * @urlParam communeName string required Le nom de la commune. Example: Bohicon
     * @urlParam arrondissementName string required Le nom de l'arrondissement. Example:AGBANWEME
     * JsonResponse : Les quartiers de l'arrondissement fourni.
     */
    public function getAllQuartierArrondissement($communeName, $arrondissementName)
    {
        $communeLabel = strtoupper(htmlspecialchars(trim($communeName)));
        $commune = Commune::where('label', $communeLabel)->first();

        if (!$commune) {
            return response()->json(['message' => 'Commune non trouvée'], 404);
        }

        $arrondissementLabel = strtoupper(htmlspecialchars(trim($arrondissementName)));
        $arrondissement = Arrondissement::where('label', $arrondissementLabel)
            ->where('commune_id', $commune->id)
            ->first();

        if (!$arrondissement) {
            return response()->json(['message' => 'Arrondissement non trouvé dans cette commune'], 404);
        }
        $quartiers = $arrondissement->quartiers;
        return response()->json($arrondissement);
    }
}