<?php

namespace App\Http\Controllers\Admin;

use App\Models\Marque;
use App\Models\Article;
use App\Models\Category;
use App\Models\Expedition;
use Illuminate\Http\Request;
use App\Models\ArticleFamily;
use App\Models\Expedition_product;
use App\Http\Controllers\Controller;

class Stock extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function receiveProducts(Request $request) {
        $receivedQuantities = $request->input('qty_reception');

        foreach ($receivedQuantities as $productId => $quantityReceived) {
            $product = Article::find($productId);
            $product->quantity_initial += $quantityReceived;
            $product->save();
        }
    }
       // public function inFabrication()
    // {

    //     $inFabrication = Article::where(['etat' => 'actif', 'status' => 'enFabrication'])->get();

    //     return view('admin.niveauStock.inFabrication', compact('inFabrication', 'categories'));
    // }

    // public function inFabrication(Request $request)
    // {
    //     $categories = Category::all(); // Récupérez toutes les catégories

    //     $selectedCategory = $request->input('category'); // Récupérez la catégorie sélectionnée

    //     $inFabricationQuery = Article::where(['etat' => 'actif', 'status' => 'enFabrication']);

    //     if ($selectedCategory) {
    //         $inFabricationQuery->whereHas('category', function ($query) use ($selectedCategory) {
    //             $query->where('libelle', $selectedCategory);
    //         });
    //     }

    //     $inFabrication = $inFabricationQuery->get();

    //     return view('admin.niveauStock.inFabrication', compact('inFabrication', 'categories', 'selectedCategory'));
    // }

    public function inFabrication(Request $request)
    {
            $inFabricationQuery = Article::where(['etat' => 'actif', 'status' => 'enFabrication']);

        // Obtenez les catégories associées aux articles en fabrication
            $categories = Article::where(['status' => 'enFabrication'])
                ->join('categories', 'articles.categorie_uuid', '=', 'categories.uuid')
                ->select('categories.uuid', 'categories.libelle')
                ->distinct()
                ->get()
                ->pluck('libelle', 'uuid');

            $selectedCategory = $request->input('category');

        if ($selectedCategory) {
            // Filtrez par catégorie si une catégorie est sélectionnée
            $inFabricationQuery->whereHas('category', function ($query) use ($selectedCategory) {
                $query->where('libelle', $selectedCategory);
            });
        }

        // Obtenez les marques associées aux articles en fabrication
        $brands = Article::where(['status' => 'enFabrication'])
            ->join('marques', 'articles.marque_uuid', '=', 'marques.uuid')
            ->select('marques.uuid', 'marques.libelle')
            ->distinct()
            ->get()
            ->pluck('libelle', 'uuid');

        $selectedBrand = $request->input('brand');

        if ($selectedBrand) {
            // Filtrez par marque si une marque est sélectionnée
            $inFabricationQuery->whereHas('marque', function ($query) use ($selectedBrand) {
                $query->where('libelle', $selectedBrand);
            });
        }

        $families = Article::where(['status' => 'enFabrication'])
            ->join('article_families', 'articles.famille_uuid', '=', 'article_families.uuid')
            ->select('article_families.uuid', 'article_families.libelle')
            ->distinct()
            ->get()
            ->pluck('libelle', 'uuid');

        $selectedFamily = $request->input('family');

        if ($selectedFamily) {
            // Filtrez par famille si une famille est sélectionnée
            $inFabricationQuery->whereHas('familly', function ($query) use ($selectedFamily) {
                $query->where('libelle', $selectedFamily);
            });
        }

        // Récupérez les articles en fabrication
        $inFabrication = $inFabricationQuery->get();


        return view('admin.niveauStock.inFabrication', compact('inFabrication', 'categories', 'selectedCategory','brands', 'selectedBrand', 'families', 'selectedFamily'));
    }
    public function insortiUsine(Request $request)
    {
            $inSortiUsineQuery = Article::where(['etat' => 'actif', 'status' => 'sortiUsine']);

        // Obtenez les catégories associées aux articles en fabrication
            $categories = Article::where(['status' => 'sortiUsine'])
                ->join('categories', 'articles.categorie_uuid', '=', 'categories.uuid')
                ->select('categories.uuid', 'categories.libelle')
                ->distinct()
                ->get()
                ->pluck('libelle', 'uuid');

            $selectedCategory = $request->input('category');

        if ($selectedCategory) {
            // Filtrez par catégorie si une catégorie est sélectionnée
            $inSortiUsineQuery->whereHas('category', function ($query) use ($selectedCategory) {
                $query->where('libelle', $selectedCategory);
            });
        }

        // Obtenez les marques associées aux articles en fabrication
        $brands = Article::where(['status' => 'sortiUsine'])
            ->join('marques', 'articles.marque_uuid', '=', 'marques.uuid')
            ->select('marques.uuid', 'marques.libelle')
            ->distinct()
            ->get()
            ->pluck('libelle', 'uuid');

        $selectedBrand = $request->input('brand');

        if ($selectedBrand) {
            // Filtrez par marque si une marque est sélectionnée
            $inSortiUsineQuery->whereHas('marque', function ($query) use ($selectedBrand) {
                $query->where('libelle', $selectedBrand);
            });
        }

        $families = Article::where(['status' => 'sortiUsine'])
            ->join('article_families', 'articles.famille_uuid', '=', 'article_families.uuid')
            ->select('article_families.uuid', 'article_families.libelle')
            ->distinct()
            ->get()
            ->pluck('libelle', 'uuid');

        $selectedFamily = $request->input('family');

        if ($selectedFamily) {
            // Filtrez par famille si une famille est sélectionnée
            $inSortiUsineQuery->whereHas('familly', function ($query) use ($selectedFamily) {
                $query->where('libelle', $selectedFamily);
            });
        }

        // Récupérez les articles en fabrication
        $insortiUsine = $inSortiUsineQuery->get();


        return view('admin.niveauStock.insortiUsine', compact('insortiUsine', 'categories', 'selectedCategory','brands', 'selectedBrand', 'families', 'selectedFamily'));
    }
    public function enExpedition(Request $request)
    {
            $inEnExpeditionQuery = Article::where(['etat' => 'actif', 'status' => 'enExpedition']);

        // Obtenez les catégories associées aux articles en fabrication
            $categories = Article::where(['status' => 'enExpedition'])
                ->join('categories', 'articles.categorie_uuid', '=', 'categories.uuid')
                ->select('categories.uuid', 'categories.libelle')
                ->distinct()
                ->get()
                ->pluck('libelle', 'uuid');

            $selectedCategory = $request->input('category');

        if ($selectedCategory) {
            // Filtrez par catégorie si une catégorie est sélectionnée
            $inEnExpeditionQuery->whereHas('category', function ($query) use ($selectedCategory) {
                $query->where('libelle', $selectedCategory);
            });
        }

        // Obtenez les marques associées aux articles en fabrication
        $brands = Article::where(['status' => 'enExpedition'])
            ->join('marques', 'articles.marque_uuid', '=', 'marques.uuid')
            ->select('marques.uuid', 'marques.libelle')
            ->distinct()
            ->get()
            ->pluck('libelle', 'uuid');

        $selectedBrand = $request->input('brand');

        if ($selectedBrand) {
            // Filtrez par marque si une marque est sélectionnée
            $inEnExpeditionQuery->whereHas('marque', function ($query) use ($selectedBrand) {
                $query->where('libelle', $selectedBrand);
            });
        }

        $families = Article::where(['status' => 'enExpedition'])
            ->join('article_families', 'articles.famille_uuid', '=', 'article_families.uuid')
            ->select('article_families.uuid', 'article_families.libelle')
            ->distinct()
            ->get()
            ->pluck('libelle', 'uuid');

        $selectedFamily = $request->input('family');

        if ($selectedFamily) {
            // Filtrez par famille si une famille est sélectionnée
            $inEnExpeditionQuery->whereHas('familly', function ($query) use ($selectedFamily) {
                $query->where('libelle', $selectedFamily);
            });
        }

        // Récupérez les articles en fabrication
        $inEnExpedition = $inEnExpeditionQuery->get();


        return view('admin.niveauStock.enExpedition', compact('inEnExpedition', 'categories', 'selectedCategory','brands', 'selectedBrand', 'families', 'selectedFamily'));
    }
    public function arriverAuPod(Request $request)
    {
            $arriverAuPodQuery = Article::where(['etat' => 'actif', 'status' => 'arriverAuPod']);

        // Obtenez les catégories associées aux articles en fabrication
            $categories = Article::where(['status' => 'arriverAuPod'])
                ->join('categories', 'articles.categorie_uuid', '=', 'categories.uuid')
                ->select('categories.uuid', 'categories.libelle')
                ->distinct()
                ->get()
                ->pluck('libelle', 'uuid');

            $selectedCategory = $request->input('category');

        if ($selectedCategory) {
            // Filtrez par catégorie si une catégorie est sélectionnée
            $arriverAuPodQuery->whereHas('category', function ($query) use ($selectedCategory) {
                $query->where('libelle', $selectedCategory);
            });
        }

        // Obtenez les marques associées aux articles en fabrication
        $brands = Article::where(['status' => 'arriverAuPod'])
            ->join('marques', 'articles.marque_uuid', '=', 'marques.uuid')
            ->select('marques.uuid', 'marques.libelle')
            ->distinct()
            ->get()
            ->pluck('libelle', 'uuid');

        $selectedBrand = $request->input('brand');

        if ($selectedBrand) {
            // Filtrez par marque si une marque est sélectionnée
            $arriverAuPodQuery->whereHas('marque', function ($query) use ($selectedBrand) {
                $query->where('libelle', $selectedBrand);
            });
        }

        $families = Article::where(['status' => 'arriverAuPod'])
            ->join('article_families', 'articles.famille_uuid', '=', 'article_families.uuid')
            ->select('article_families.uuid', 'article_families.libelle')
            ->distinct()
            ->get()
            ->pluck('libelle', 'uuid');

        $selectedFamily = $request->input('family');

        if ($selectedFamily) {
            // Filtrez par famille si une famille est sélectionnée
            $arriverAuPodQuery->whereHas('familly', function ($query) use ($selectedFamily) {
                $query->where('libelle', $selectedFamily);
            });
        }

        // Récupérez les articles en fabrication
        $arriverAuPod = $arriverAuPodQuery->get();


        return view('admin.niveauStock.arriverAuPod', compact('arriverAuPod', 'categories', 'selectedCategory','brands', 'selectedBrand', 'families', 'selectedFamily'));
    }
    public function stocked(Request $request)
    {
            $stockedQuery = Article::where(['etat' => 'actif', 'status' => 'stocked']);

        // Obtenez les catégories associées aux articles en fabrication
            $categories = Article::where(['status' => 'stocked'])
                ->join('categories', 'articles.categorie_uuid', '=', 'categories.uuid')
                ->select('categories.uuid', 'categories.libelle')
                ->distinct()
                ->get()
                ->pluck('libelle', 'uuid');

            $selectedCategory = $request->input('category');

        if ($selectedCategory) {
            // Filtrez par catégorie si une catégorie est sélectionnée
            $stockedQuery->whereHas('category', function ($query) use ($selectedCategory) {
                $query->where('libelle', $selectedCategory);
            });
        }

        // Obtenez les marques associées aux articles en fabrication
        $brands = Article::where(['status' => 'stocked'])
            ->join('marques', 'articles.marque_uuid', '=', 'marques.uuid')
            ->select('marques.uuid', 'marques.libelle')
            ->distinct()
            ->get()
            ->pluck('libelle', 'uuid');

        $selectedBrand = $request->input('brand');

        if ($selectedBrand) {
            // Filtrez par marque si une marque est sélectionnée
            $stockedQuery->whereHas('marque', function ($query) use ($selectedBrand) {
                $query->where('libelle', $selectedBrand);
            });
        }

        $families = Article::where(['status' => 'stocked'])
            ->join('article_families', 'articles.famille_uuid', '=', 'article_families.uuid')
            ->select('article_families.uuid', 'article_families.libelle')
            ->distinct()
            ->get()
            ->pluck('libelle', 'uuid');

        $selectedFamily = $request->input('family');

        if ($selectedFamily) {
            // Filtrez par famille si une famille est sélectionnée
            $stockedQuery->whereHas('familly', function ($query) use ($selectedFamily) {
                $query->where('libelle', $selectedFamily);
            });
        }

        // Récupérez les articles en fabrication
        $stocked = $stockedQuery->get();


        return view('admin.niveauStock.stocked', compact('stocked', 'categories', 'selectedCategory','brands', 'selectedBrand', 'families', 'selectedFamily'));
    }
    public function expEnCours(Request $request)
    {
            $expEnCoursQuery = Article::where(['etat' => 'actif', 'status' => 'expEnCours']);

        // Obtenez les catégories associées aux articles en fabrication
            $categories = Article::where(['status' => 'expEnCours'])
                ->join('categories', 'articles.categorie_uuid', '=', 'categories.uuid')
                ->select('categories.uuid', 'categories.libelle')
                ->distinct()
                ->get()
                ->pluck('libelle', 'uuid');

            $selectedCategory = $request->input('category');

        if ($selectedCategory) {
            // Filtrez par catégorie si une catégorie est sélectionnée
            $expEnCoursQuery->whereHas('category', function ($query) use ($selectedCategory) {
                $query->where('libelle', $selectedCategory);
            });
        }

        // Obtenez les marques associées aux articles en fabrication
        $brands = Article::where(['status' => 'expEnCours'])
            ->join('marques', 'articles.marque_uuid', '=', 'marques.uuid')
            ->select('marques.uuid', 'marques.libelle')
            ->distinct()
            ->get()
            ->pluck('libelle', 'uuid');

        $selectedBrand = $request->input('brand');

        if ($selectedBrand) {
            // Filtrez par marque si une marque est sélectionnée
            $expEnCoursQuery->whereHas('marque', function ($query) use ($selectedBrand) {
                $query->where('libelle', $selectedBrand);
            });
        }

        $families = Article::where(['status' => 'expEnCours'])
            ->join('article_families', 'articles.famille_uuid', '=', 'article_families.uuid')
            ->select('article_families.uuid', 'article_families.libelle')
            ->distinct()
            ->get()
            ->pluck('libelle', 'uuid');

        $selectedFamily = $request->input('family');

        if ($selectedFamily) {
            // Filtrez par famille si une famille est sélectionnée
            $expEnCoursQuery->whereHas('familly', function ($query) use ($selectedFamily) {
                $query->where('libelle', $selectedFamily);
            });
        }

        // Récupérez les articles en fabrication
        $expEnCours = $expEnCoursQuery->get();


        return view('admin.niveauStock.expEnCours', compact('expEnCours', 'categories', 'selectedCategory','brands', 'selectedBrand', 'families', 'selectedFamily'));
    }
    public function delivered(Request $request)
    {
            $deliveredQuery = Article::where(['etat' => 'actif', 'status' => 'delivered']);

        // Obtenez les catégories associées aux articles en fabrication
            $categories = Article::where(['status' => 'delivered'])
                ->join('categories', 'articles.categorie_uuid', '=', 'categories.uuid')
                ->select('categories.uuid', 'categories.libelle')
                ->distinct()
                ->get()
                ->pluck('libelle', 'uuid');

            $selectedCategory = $request->input('category');

        if ($selectedCategory) {
            // Filtrez par catégorie si une catégorie est sélectionnée
            $deliveredQuery->whereHas('category', function ($query) use ($selectedCategory) {
                $query->where('libelle', $selectedCategory);
            });
        }

        // Obtenez les marques associées aux articles en fabrication
        $brands = Article::where(['status' => 'delivered'])
            ->join('marques', 'articles.marque_uuid', '=', 'marques.uuid')
            ->select('marques.uuid', 'marques.libelle')
            ->distinct()
            ->get()
            ->pluck('libelle', 'uuid');

        $selectedBrand = $request->input('brand');

        if ($selectedBrand) {
            // Filtrez par marque si une marque est sélectionnée
            $deliveredQuery->whereHas('marque', function ($query) use ($selectedBrand) {
                $query->where('libelle', $selectedBrand);
            });
        }

        $families = Article::where(['status' => 'delivered'])
            ->join('article_families', 'articles.famille_uuid', '=', 'article_families.uuid')
            ->select('article_families.uuid', 'article_families.libelle')
            ->distinct()
            ->get()
            ->pluck('libelle', 'uuid');

        $selectedFamily = $request->input('family');

        if ($selectedFamily) {
            // Filtrez par famille si une famille est sélectionnée
            $deliveredQuery->whereHas('familly', function ($query) use ($selectedFamily) {
                $query->where('libelle', $selectedFamily);
            });
        }

        // Récupérez les articles en fabrication
        $delivered = $deliveredQuery->get();


        return view('admin.niveauStock.delivered', compact('delivered', 'categories', 'selectedCategory','brands', 'selectedBrand', 'families', 'selectedFamily'));
    }
    public function allProduction(Request $request)
    {
            $deliveredQuery = Article::where(['etat' => 'actif']);
            $allLigneProduction = Article::where(['etat' => 'actif'])->get();

        // Obtenez les catégories associées aux articles sur ligne de production
        $categories = Article::join('categories', 'articles.categorie_uuid', '=', 'categories.uuid')
                ->select('categories.uuid', 'categories.libelle')
                ->distinct()
                ->get()
                ->pluck('libelle', 'uuid');

            $selectedCategory = $request->input('category');

        if ($selectedCategory) {
            // Filtrez par catégorie si une catégorie est sélectionnée
            $deliveredQuery->whereHas('category', function ($query) use ($selectedCategory) {
                $query->where('libelle', $selectedCategory);
            });
        }

        // Obtenez les marques associées aux articles en fabrication
        $brands = Article::join('marques', 'articles.marque_uuid', '=', 'marques.uuid')
            ->select('marques.uuid', 'marques.libelle')
            ->distinct()
            ->get()
            ->pluck('libelle', 'uuid');

        $selectedBrand = $request->input('brand');

        if ($selectedBrand) {
            // Filtrez par marque si une marque est sélectionnée
            $deliveredQuery->whereHas('marque', function ($query) use ($selectedBrand) {
                $query->where('libelle', $selectedBrand);
            });
        }

        $families = Article::join('article_families', 'articles.famille_uuid', '=', 'article_families.uuid')
            ->select('article_families.uuid', 'article_families.libelle')
            ->distinct()
            ->get()
            ->pluck('libelle', 'uuid');

        $selectedFamily = $request->input('family');

        if ($selectedFamily) {
            // Filtrez par famille si une famille est sélectionnée
            $deliveredQuery->whereHas('familly', function ($query) use ($selectedFamily) {
                $query->where('libelle', $selectedFamily);
            });
        }

        $statuses = Article::select('status')->distinct()->get()->pluck('status', 'status');
        $selectedStatus = $request->input('status');

        if ($selectedStatus) {
            // Filtrez par statut si un statut est sélectionné
            $deliveredQuery->where('status', $selectedStatus);
        }

        $customerProduct = Expedition_product::where(['etat' => 'actif'])->get();


        $delivered = $deliveredQuery->get();



        $allCats = Category::where('etat', 'actif')->get();
        $totalProducts = $allCats->flatMap->articles->count(); // Nombre total de produits dans toutes les catégories

        // Marque
        $allBrands = Marque::where('etat', 'actif')->get();
        $totalProductsBybrand = $allBrands->flatMap->articles->count(); // Nombre total de produits dans toutes les marques

        // Familie
        $allFamilies = ArticleFamily::where('etat', 'actif')->get();
        $totalProductsByfamily = $allFamilies->flatMap->articles->count(); // Nombre total de produits dans toutes les familles

        $groupByStatuses = Article::distinct()->pluck('status');

        return view('admin.niveauStock.allStateModal', compact('delivered', 'categories', 'selectedCategory','brands', 'selectedBrand', 'families', 'selectedFamily', 'statuses', 'selectedStatus', 'allCats', 'totalProducts', 'allBrands', 'totalProductsBybrand', 'allFamilies', 'totalProductsByfamily', 'groupByStatuses'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}