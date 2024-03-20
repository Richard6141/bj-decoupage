<?php

namespace App\Http\Controllers\api;

use App\Models\Commune;
use Illuminate\Http\Request;
use App\Models\Arrondissement;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArrondissementRequest;

/**
 * @group Arrondissements
 *
 * Requêtes sur les arrondissements
 */
class ArrondissementController extends Controller
{
    /**
     * Récupère la liste des arrondissements.
     *
     * @urlParam search  Une partie de l\'écriture de l\arrondissement recherchée. Example: Pa 
     * @urlParam perPage int Nombre de résultat par page. Example: 20
     * @urlParam page int Le numero de page. Example: 3 
     * @return JsonResponse La liste des arrondissements.
     */
    public function index(ArrondissementRequest $request)
    {
        try {
            $arrondissements = Arrondissement::query();
            if ($request->input('search') == null && $request->input('page')== null && $perPage = $request->input('perPage') == null) {
                $result = $arrondissements->get();
                return response()->json($result);
            }
            
            $search = $request->input('search');
            $page = $request->input('page', 1);
            $perPage = $request->input('perPage', 40);
        
            // Filtrer les arrondissements en fonction du terme de recherche s'il est fourni
            if ($search) {
                $arrondissements->where('label', 'LIKE', '%' . $search . '%');
            }
            // Récupérer le nombre total de résultats
            $total = $arrondissements->count();
            if ($total==0) {
                return response()->json(["error" => "Arrondissement non trouvé"], 404);
            }
            // Calculer le nombre total de pages
            $lastPage = ceil($total / $perPage);
            // Vérifier si la page demandée est valide
            if ($page < 1 || $page > $lastPage) {
                return response()->json(["error" => "Aucun résultat sur cette page"], 404);
            }
            // Récupérer les arrondissements pour la page demandée
            $result = $arrondissements->offset(($page - 1) * $perPage)->limit($perPage)->get();
            // Vérifier si aucun résultat sur la page
            if ($result->isEmpty()) {
                return response()->json(["error" => "Aucun résultat sur cette page"], 404);
            }
        
            return response()->json([
                "current_page" => $page,
                "last_page" => $lastPage,
                "arrondissements" => $result
            ]);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }  
    }

    /**
     * Récupère les quartiers d'un arrondissement d'une commune spécifique
     * @urlParam communeName string required Le nom de la commune. Example: Bohicon
     * @urlParam arrondissementName string required Le nom de l'arrondissement. Example:AGBANWEME
     * @return JsonResponse : Les quartiers de l'arrondissement fourni.
     */
    public function getAllQuartierArrondissement($communeName, $arrondissementName)
    {
        try{
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
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }  
        
    }
    
}