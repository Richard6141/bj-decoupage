<?php

namespace App\Http\Controllers\api;

use App\Models\Departement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartementRequest;

/**
 * @group Départements
 *
 * Requêtes sur les départements
 */

class DepartementController extends Controller
{
    /**
     * Récupère la liste des départements.
     *
     * @urlParam search  Une partie de l\'écriture de la département recherché. Example: Bo
     * @urlParam perPage int Nombre de résultat par page. Example: 10
     * @urlParam page int Le numero de page. Example: 2
     * @return JsonResponse Liste des départements.
     */
    public function index(DepartementRequest $request)
    {
        try {
            $departements = Departement::query();
            if ($request->input('search') == null && $request->input('page')== null && $perPage = $request->input('perPage') == null) {
                $result = $departements->get();
                return response()->json($result);
            }
            
            $search = $request->input('search');
            $page = $request->input('page', 1);
            $perPage = $request->input('perPage', 6);
        
            // Filtrer les departements en fonction du terme de recherche s'il est fourni
            if ($search) {
                $departements->where('label', 'LIKE', '%' . $search . '%');
            }
            // Récupérer le nombre total de résultats
            $total = $departements->count();
            if ($total==0) {
                return response()->json(["error" => "Département non trouvé"], 404);
            }
            // Calculer le nombre total de pages
            $lastPage = ceil($total / $perPage);
            // Vérifier si la page demandée est valide
            if ($page < 1 || $page > $lastPage) {
                return response()->json(["error" => "Aucun résultat sur cette page"], 404);
            }
            // Récupérer les departements pour la page demandée
            $result = $departements->offset(($page - 1) * $perPage)->limit($perPage)->get();
            // Vérifier si aucun résultat sur la page
            if ($result->isEmpty()) {
                return response()->json(["error" => "Aucun résultat sur cette page"], 404);
            }
        
            return response()->json([
                "current_page" => $page,
                "last_page" => $lastPage,
                "departements" => $result
            ]);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }  
    }

    /**
     * Récupère tous les départements avec leurs communes, arrondissements et quartiers.
     *
     * @return JsonResponse Les détails du département avec ses communes, arrondissements et quartiers.
     */

    public function getAllDepartementsWithDetails()
    {
        // Récupérer tous les départements avec leurs relations
        try{
            $departements = Departement::with('communes.arrondissements.quartiers')->get();

            return response()->json($departements);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }  
    }

    /**
     * Récupère un département avec ses communes, arrondissements et quartiers.
     *
     * @urlParam departementName string required Le nom de la commune. Example: Alibori
     * @return JsonResponse Les détails du département avec ses communes, arrondissements et quartiers.
     */

    public function getDepartementWithDetails($departementName)
    {
        //Opérer des opérations sur l'entrée de l'utilsateur
        try{
            $departementLabel = strtoupper(htmlspecialchars(trim($departementName)));
            $departement = Departement::where('label', $departementLabel)->get();
            $departement = Departement::with('communes.arrondissements.quartiers')->find($departement);
            if (!$departement) {
                return response()->json(['message' => 'Département non trouvé'], 404);
            }

            return response()->json($departement);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }  
    }

    /**
     * Récupère un département avec ses communes.
     *
     * @urlParam departementName string required Le nom de la commune. Example: Alibori
     * @return JsonResponse Les détails du département avec ses communes, arrondissements et quartiers.
     */

    public function getCommunes($departementName)
    {
        try{
            $departementLabel = strtoupper(htmlspecialchars(trim($departementName)));
            $departement = Departement::where('label', $departementLabel)->get();
            $departement = Departement::with('communes')->find($departement);
            if (!$departement) {
                return response()->json(['message' => 'Département non trouvé'], 404);
            }

            return response()->json($departement);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }  
    }
}