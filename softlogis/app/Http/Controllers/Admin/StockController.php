<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Article;
use App\Models\Entrepot;
use App\Models\Sourcing;
use App\Models\OdLivraison;
use App\Models\stockUpdate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Sourcing_product;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\MyLogNotification;

class StockController extends Controller
{

    // public function receiveProducts(Request $request) {

    //     try {
    //         DB::beginTransaction();
    //         $receivedQuantities = $request->input('qty_reception');
    //         $userId = auth()->user()->id;

    //         $updatedProducts = [];
    //         foreach ($receivedQuantities as $productId => $quantityReceived) {
    //             $product = Article::where('id', $productId)->first();

    //             if ($product) {

    //                 $file = $request->file('file');
    //                 $filename = 'default.jpg';
    //                 if ($file != null) {
    //                     $filename = 'InStock_' . date('YmdHis') . '_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
    //                     $file->move('documents/files', $filename);
    //                 }

    //                 $updatedProducts[] = $product;
    //                 $product->entrepot_uuid = $request->input('entrepot_uuid');

    //                 stockUpdate::create([
    //                     'uuid' => Str::uuid(),
    //                     'product_id' => $productId,
    //                     'entrepot_uuid' => $request->input('entrepot_uuid'),
    //                     'file' => $filename,
    //                     'updated_at' => now(),
    //                     'user_id' => $userId,
    //                 ]);
    //             }
    //         }

    //         // $statutReceive = $request->has('is_received');
    //         Sourcing_product::where('product_id', $productId)->update(['is_received' => 1]);

    //         if (!empty($updatedProducts)) {
    //             $dataResponse = [
    //                 'type' => 'success',
    //                 'urlback' => "back",
    //                 'message' => "Enregistré avec succès!",
    //                 'code' => 200,
    //             ];
    //             DB::commit();
    //         } else {
    //             DB::rollback();
    //             $dataResponse = [
    //                 'type' => 'error',
    //                 'urlback' => '',
    //                 'message' => "Erreur lors de l'enregistrement!",
    //                 'code' => 500,
    //             ];
    //         }
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         $dataResponse = [
    //             'type' => 'error',
    //             'urlback' => '',
    //             'message' => "Erreur système! $th",
    //             'code' => 500,
    //         ];
    //     }
    //     return response()->json($dataResponse);
    // }

    // public function receiveProducts(Request $request) {
    //     try {
    //         DB::beginTransaction();

    //         $productId = $request->input('product_id');
    //         $userId = auth()->user()->id;

    //         $sourcing = Sourcing::where(['uuid'=>$request->input('sourcing_uuid')])->first();

    //         $product = Article::find($productId);

    //         if ($product) {
    //             $file = $request->file('file');

    //             if ($file !== null) {
    //                 $filename = 'InStock_' . date('YmdHis') . '_' . Str::uuid().'.'.$file->getClientOriginalExtension();
    //                 $file->move('documents/files', $filename);
    //             }

    //             stockUpdate::create([
    //                 'uuid' => Str::uuid(),
    //                 'product_id' => $productId,
    //                 'entrepot_uuid' => $request->input('entrepot_uuid'),
    //                 'file' => $filename,
    //                 'note'=>$request->input('note'),
    //                 'conformity'=> $request->input('conformity'),
    //                 'updated_at' => now(),
    //                 'user_id' => $userId,
    //             ]);


    //         $sourcingProducts = $sourcing->products;

    //         foreach ($sourcingProducts as $sourcingProduct) {
    //             $product = $sourcingProduct->product;
    //             if ($product) {
    //                 $product->update([
    //                     'status' => 'stocked',
    //                 ]);
    //             }
    //         }

    //         $stocked = Article::where('id', $productId)->update(['entrepot_uuid' => $request->input('entrepot_uuid')]);

    //         if ($stocked) {
    //             $sourcing->update([
    //                 'statut' => 'stocked',
    //             ]);
    //         }

    //             $dataResponse = [
    //                 'type' => 'success',
    //                 'urlback' => "back",
    //                 'message' => "Enregistré avec succès!",
    //                 'code' => 200,
    //             ];

    //             DB::commit();
    //         } else {
    //             $dataResponse = [
    //                 'type' => 'error',
    //                 'urlback' => '',
    //                 'message' => "Produit non trouvé!",
    //                 'code' => 404,
    //             ];
    //         }
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         $dataResponse = [
    //             'type' => 'error',
    //             'urlback' => '',
    //             'message' => "Erreur système! $th",
    //             'code' => 500,
    //         ];
    //     }

    //     return response()->json($dataResponse);
    // }

    public function receiveProducts(Request $request) {
        try {
            DB::beginTransaction();

            $userId = auth()->user()->id;

            $product = Article::where('uuid', $request->input('product_uuid'))->first();

            Article::where('uuid', $request->input('product_uuid'))->update([
                'date_reception' => $request->input('date_reception'),
                'status' => 'received',
            ]);

            $isReceived = Sourcing_product::where('product_uuid', $request->input('product_uuid'))->update([
                'is_received' => true,
            ]);

            if ($product) {
                if ($request->file('file')) {
                    $file = $request->file('file');
                    $filename = 'InStock_' . date('YmdHis') . '_' . Str::uuid().'.'.$file->getClientOriginalExtension();
                    $file->move('documents/files', $filename);
                }

                stockUpdate::create([
                    'uuid' => Str::uuid(),
                    'product_id' => $product->id,
                    'entrepot_uuid' => $request->input('entrepot_uuid'),
                    'file' => $filename,
                    'note'=>$request->input('note'),
                    'conformity'=> $request->input('conformity'),
                    'updated_at' => now(),
                    'user_id' => $userId,
                ]);



                $updateSourcing = Sourcing::where(['uuid' => $request->input('sourcing_uuid')])->update([
                    'statut' => 'received',
                ]);
                $sourcing = Sourcing::where(['uuid' => $request->input('sourcing_uuid')])->first();

                $users = User::all();
                $user = auth()->user()->name." ".auth()->user()->lastname;
                $details_log = [
                    // 'url' => url()->current(),
                    'url' => route('admin.sourcing.show',$sourcing->uuid),
                    'user' => $user,
                    'date' => date('Y-m-d H:i:s'),
                    'title' => "Reception de produit",
                    'action' => "Le Produit ".$product->code." Du sourcing ".$sourcing->code." a ete receptionné par ".$user."le ".date('Y-m-d H:i:s'),
                ];

                // Assurez-vous que $users est une collection d'instances de User
                foreach ($users as $user) {
                    $user->notify(new MyLogNotification($details_log));
                }


                $dataResponse = [
                    'type' => 'success',
                    'urlback' => "back",
                    'message' => "Enregistré avec succès!",
                    'code' => 200,
                ];

                DB::commit();
            } else {
                $dataResponse = [
                    'type' => 'error',
                    'urlback' => '',
                    'message' => "Produit non trouvé!",
                    'code' => 404,
                ];
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $dataResponse = [
                'type' => 'error',
                'urlback' => '',
                'message' => "Erreur système! $th",
                'code' => 500,
            ];
        }

        return response()->json($dataResponse);
    }
    public function stockProducts(Request $request) {
        try {
            DB::beginTransaction();

            $userId = auth()->user()->id;

            $sourcing = Sourcing::where(['uuid'=>$request->input('sourcing_uuid')])->first();

            $product = Article::where('uuid', $request->input('product_uuid'))->first();

            Article::where('uuid', $request->input('product_uuid'))->update([
                'date_stockage' => $request->input('date_stockage'),
                'entrepot_uuid' => $request->input('entrepot_uuid'),
                'status' => 'stocked',
            ]);

            if ($product) {

                $updateSourcing = Sourcing::where(['uuid' => $request->input('sourcing_uuid')])->update([
                    'statut' => 'stocked',
                ]);

                $sourcing = Sourcing::where(['uuid' => $request->input('sourcing_uuid')])->first();

                $users = User::all();
                $user = auth()->user()->name." ".auth()->user()->lastname;
                $details_log = [
                    // 'url' => url()->current(),
                    'url' => route('admin.sourcing.show',$sourcing->uuid),
                    'user' => $user,
                    'date' => date('Y-m-d H:i:s'),
                    'title' => "Stockage de produit",
                    'action' => "Le Produit ".$product->code." Du sourcing ".$sourcing->code." a ete stocké par ".$user."le ".date('Y-m-d H:i:s'),
                ];

                // Assurez-vous que $users est une collection d'instances de User
                foreach ($users as $user) {
                    $user->notify(new MyLogNotification($details_log));
                }


                $dataResponse = [
                    'type' => 'success',
                    'urlback' => "back",
                    'message' => "Enregistré avec succès!",
                    'code' => 200,
                ];

                DB::commit();
            } else {
                $dataResponse = [
                    'type' => 'error',
                    'urlback' => '',
                    'message' => "Produit non trouvé!",
                    'code' => 404,
                ];
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $dataResponse = [
                'type' => 'error',
                'urlback' => '',
                'message' => "Erreur système! $th",
                'code' => 500,
            ];
        }

        return response()->json($dataResponse);
    }
    public function addStockProducts(Request $request) {
        try {
            DB::beginTransaction();

            $productId = $request->input('product_id');
            $userId = auth()->user()->id;

            if ($productId) {

            Article::where('id', $productId)->update([
                'entrepot_uuid' => $request->input('entrepot_uuid'),
            ]);

                $dataResponse = [
                    'type' => 'success',
                    'urlback' => "back",
                    'message' => "Enregistré avec succès!",
                    'code' => 200,
                ];

                DB::commit();
            } else {
                $dataResponse = [
                    'type' => 'error',
                    'urlback' => '',
                    'message' => "Produit non trouvé!",
                    'code' => 404,
                ];
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $dataResponse = [
                'type' => 'error',
                'urlback' => '',
                'message' => "Erreur système! $th",
                'code' => 500,
            ];
        }

        return response()->json($dataResponse);
    }


    public function removeStockProducts(Request $request) {

        try {
            DB::beginTransaction();
            $addQuantities = $request->input('qty_reception');
            $productId = $request->input('product_id');
            $userId = auth()->user()->id;

            $updatedProducts = [];

            foreach ($addQuantities as $productId => $quantityAdd) {
                $product = Article::where('id', $productId)->first();

                if ($product && $product->quantity_initial >= $quantityAdd) {
                    // Mettez à jour la quantité initiale
                    $product->quantity_initial -= $quantityAdd;
                    $product->save();

                    $updatedProducts[] = $product;

                    stockUpdate::create([
                        'uuid' => Str::uuid(),
                        'product_id' => $productId,
                        'mouvement' => 'Out',
                        'quantity_removed' => $quantityAdd,
                        'entrepot_uuid' => $request->input('entrepot_uuid'),
                        'updated_at' => now(),
                        'user_id' => $userId,
                    ]);
                }
            }

            if (!empty($updatedProducts)) {
                $dataResponse = [
                    'type' => 'success',
                    'urlback' => "back",
                    'message' => "Enregistré avec succès!",
                    'code' => 200,
                ];
                DB::commit();
            } else {
                DB::rollback();
                $dataResponse = [
                    'type' => 'error',
                    'urlback' => '',
                    'message' => "Erreur lors de la mise a jour du stock!
                     La quantité en stock n'est pas suffisante!",
                    'code' => 500,
                ];
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $dataResponse = [
                'type' => 'error',
                'urlback' => '',
                'message' => "Erreur système! $th",
                'code' => 500,
            ];
        }
        return response()->json($dataResponse);
    }

    public function stockMouvement() {

        $mvtUpdates = stockUpdate::all();

        $products = Article::where(['etat' => 'actif', 'status' => 'stocked'])->get();
        // dd($products);
        $entrepots = Entrepot::where(['etat' => 'actif'])->get();

        return view('admin.stock.mouvement', compact('mvtUpdates', 'products', 'entrepots'));
    }
}
