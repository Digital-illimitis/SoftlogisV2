<?php

use App\Models\User;
use App\Models\GrilleTarif;
use App\Models\FactProforma;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\Stock;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ArretController;
use App\Http\Controllers\Admin\ModelController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\ExcelImportController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\MarqueController;
use App\Http\Controllers\Admin\RegimeController;
use App\Http\Controllers\Admin\SourceController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EntrepotController;
use App\Http\Controllers\Admin\SourcingController;
use App\Http\Controllers\Admin\ExpTransitController;
use App\Http\Controllers\Admin\OdTransiteController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\ExTransportController;
use App\Http\Controllers\Admin\FacturationController;
use App\Http\Controllers\Admin\GrilleTarifController;
use App\Http\Controllers\Admin\OdLivraisonController;
use App\Http\Controllers\Admin\TransitaireController;
use App\Http\Controllers\Admin\FactProformaController;
use App\Http\Controllers\Admin\TransporteurController;
use App\Http\Controllers\Admin\CollaborateurController;
use App\Http\Controllers\Admin\RefacturationController;
use App\Http\Controllers\Admin\DocumentRequisController;
use App\Http\Controllers\Admin\ManageDocumentController;
use App\Http\Controllers\Admin\OdreExpeditionController;
use App\Http\Controllers\Admin\FactureProformaController;
use App\Http\Controllers\Admin\RapportController;
use App\Http\Controllers\Transporteur\TrController;
use App\Http\Controllers\Admin\LoginAttemptController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Auth::routes();
Route::middleware('guest', 'PreventBackHistory')->group(function(){
    Route::get('/', [HomeController::class, 'login'])->name('home.login');
});


    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


    /*------------------------------------------
    --------------------------------------------
    All Admin Routes List
    --------------------------------------------
    --------------------------------------------*/
    Route::post('/send-email', [HomeController::class, 'sendEmail'])->name('send.email');
    // Route::get('/get-current-datetime', [HomeController::class, 'getCurrentDateTime']);
    // Route pour obtenir les détails d'un transporteur
    Route::get('/get-transporteur-details/{uuid}',[RapportController::class, 'getTransporteurDetails']);

    // Route pour obtenir les statistiques d'un transporteur
    Route::get('/get-transporteur-stats/{uuid}', [RapportController::class, 'getTransporteurStats']);



  Route::get('/import-excel', [ExcelImportController::class, 'index'])->name('import.index');
  Route::get('/search-products-by-numero-serie/{input}', [ArticleController::class, 'searchByNumeroSerie']);
  Route::get('/tag-products-by-numero-serie/{input}', [ArticleController::class, 'tagproductByNumSeri']);
  Route::get('/articles/search', [ArticleController::class, 'search']);
  Route::get('/articles/all', [ArticleController::class, 'all']);
  Route::get('/search-products-by-bon-command/{input}', [ArticleController::class, 'searchByBonCommand']);

        Route::post('/import-excel', [ExcelImportController::class, 'import'])->name('import.excel');

        // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/update-transporteur-uuid', [GrilleTarifController::class, 'updateUuid']);
    Route::post('/update-transitaire-uuid', [GrilleTarifController::class, 'updateUuidTransit']);

Route::prefix('admin')->name('admin.')->group(function(){
    Route::middleware('guest', 'PreventBackHistory')->group(function(){
    });

    Route::middleware(['auth','PreventBackHistory', 'user-access:' . User::TYPE_ADMIN])->group(function () {
        Route::get('/home', [HomeController::class, 'adminHome'])->name('home');

        // import
        Route::get('/admin/logins', [LoginAttemptController::class, 'index'])->name('admin.logins');


        Route::get('/import-excel', [ExcelImportController::class, 'index'])->name('import.index');
        // collaborateur route

        Route::get('/collaborateur', [CollaborateurController::class, 'index'])->name('collaborateur.index');

        Route::post('/store/collaborateur', [CollaborateurController::class, 'store'])->name('collaborateur.store');

        Route::post('/destroy/collaborateur', [CollaborateurController::class, 'destroy'])->name('collaborateur.destroy');
        Route::post('/update/collaborateur/{uuid}', [CollaborateurController::class, 'update'])->name('collaborateur.update');

        // end collaborateur route
        // profile route

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::post('/update/profile/{uuid}', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/update/mot-passe/{uuid}', [ProfileController::class, 'updateMp'])->name('mot-passe.update');
        // end profile route

        // email route
        Route::get('/send-mail', [MailController::class, 'index'])->name('send_mail');

        // company route
        Route::get('/company', [CompanyController::class, 'index'])->name('company');
        Route::post('/store/company', [CompanyController::class, 'store'])->name('company.store');
        Route::post('/destroy/company', [CompanyController::class, 'destroy'])->name('company.destroy');
        Route::post('/update/company/{uuid}', [CompanyController::class, 'update'])->name('company.update');
        Route::get('/show/company/{uuid}', [CompanyController::class, 'show'])->name('company.show');

        Route::post('/active/company', [CompanyController::class, 'toActive'])->name('company.active');
        Route::post('/block/company', [CompanyController::class, 'toBlock'])->name('company.block');

        // transporteur route
        Route::get('/transporteur', [TransporteurController::class, 'index'])->name('transporteur');
        Route::post('/store/transporteur', [TransporteurController::class, 'store'])->name('transporteur.store');
        Route::post('/destroy/transporteur', [TransporteurController::class, 'destroy'])->name('transporteur.destroy');
        Route::post('/update/transporteur/{uuid}', [TransporteurController::class, 'update'])->name('transporteur.update');
        Route::get('/show/transporteur/{uuid}', [TransporteurController::class, 'show'])->name('transporteur.show');
        // transitaire route
        Route::get('/transitaire', [TransitaireController::class, 'index'])->name('transitaire');
        Route::post('/store/transitaire', [TransitaireController::class, 'store'])->name('transitaire.store');
        Route::post('/destroy/transitaire', [TransitaireController::class, 'destroy'])->name('transitaire.destroy');
        Route::post('/update/transitaire/{uuid}', [TransitaireController::class, 'update'])->name('transitaire.update');
        Route::get('/show/transitaire/{uuid}', [TransitaireController::class, 'show'])->name('transitaire.show');
        // clients route
        Route::get('/client', [ClientController::class, 'index'])->name('client');
        Route::post('/store/client', [ClientController::class, 'store'])->name('client.store');
        Route::post('/destroy/client', [ClientController::class, 'destroy'])->name('client.destroy');
        Route::post('/update/client/{uuid}', [ClientController::class, 'update'])->name('client.update');
        Route::get('/show/client/{uuid}', [ClientController::class, 'show'])->name('client.show');
        // Category Route
        Route::get('/category', [CategoryController::class, 'index'])->name('category');
        Route::post('/store/category', [CategoryController::class, 'store'])->name('category.store');
        Route::post('/update/category/{uuid}', [CategoryController::class, 'update'])->name('category.update');
        Route::post('/destroy/category/{uuid}', [CategoryController::class, 'destroy'])->name('category.destroy');
        // Marque Route
        Route::get('/marque', [MarqueController::class, 'index'])->name('marque');
        Route::post('/marque/store/', [MarqueController::class, 'store'])->name('marque.store');
        Route::post('/marque/update/{uuid}', [MarqueController::class, 'update'])->name('marque.update');
        Route::post('/marque/destroy/{uuid}', [MarqueController::class, 'destroy'])->name('marque.destroy');
        // Ship source Route
        Route::get('/ship_source', [SourceController::class, 'index'])->name('ship_source');
        Route::post('/store/ship_source', [SourceController::class, 'store'])->name('ship_source.store');
        Route::post('/update/ship_source/{uuid}', [SourceController::class, 'update'])->name('ship_source.update');
        Route::post('/destroy/ship_source/{uuid}', [SourceController::class, 'destroy'])->name('ship_source.destroy');
        // Article Model Route
        Route::get('/article_model', [ModelController::class, 'index'])->name('article_model');
        Route::post('/store/article_model', [ModelController::class, 'store'])->name('article_model.store');
        Route::post('/update/article_model/{uuid}', [ModelController::class, 'update'])->name('article_model.update');
        Route::post('/destroy/article_model/{uuid}', [ModelController::class, 'destroy'])->name('article_model.destroy');
        // Article Family Route
        Route::get('/article_family', [FamilyController::class, 'index'])->name('article_family');
        Route::get('show/article_family', [FamilyController::class, 'show'])->name('article_family.show');
        Route::post('/store/article_family', [FamilyController::class, 'store'])->name('article_family.store');
        Route::post('/update/article_family/{uuid}', [FamilyController::class, 'update'])->name('article_family.update');
        Route::post('/destroy/article_family/{uuid}', [FamilyController::class, 'destroy'])->name('article_family.destroy');

        // Product route
        Route::get('/article', [ArticleController::class, 'index'])->name('article.index');
        Route::post('/article/store/', [ArticleController::class, 'store'])->name('article.store');
        Route::get('/article/show/{uuid}', [ArticleController::class, 'show'])->name('article.show');
        Route::post('/article/update/{uuid}', [ArticleController::class, 'update'])->name('article.update');
        Route::post('/article/destroy/{uuid}', [ArticleController::class, 'destroy'])->name('article.destroy');
            // article local machine route
            Route::post('/article/local_machine/{uuid}', [ArticleController::class, 'markToFabrication'])->name('local_machine.add');
            Route::post('/article/markToOutUsine/{uuid}', [ArticleController::class, 'markToOutUsine'])->name('local_machine.markToOutUsine');
            Route::post('/article/markToWaitExpedit/{uuid}', [ArticleController::class, 'markToWaitExpedit'])->name('local_machine.markToWaitExpedit');
            Route::post('/article/markToExpedite/{uuid}', [ArticleController::class, 'markToExpedite'])->name('local_machine.markToExpedite');
            Route::post('/article/markToarrivedPod/{uuid}', [ArticleController::class, 'markToarrivedPod'])->name('local_machine.markToarrivedPod');


        // Sourcing route
        Route::get('/sourcing', [SourcingController::class, 'index'])->name('sourcing.index');
        Route::get('/sourcing/create', [SourcingController::class, 'create'])->name('sourcing.create');
        Route::post('/store/sourcing', [SourcingController::class, 'store'])->name('sourcing.store');
        Route::post('/update/sourcing/{uuid}', [SourcingController::class, 'update'])->name('sourcing.update');
        Route::post('/update/sourcing/product/{uuid}', [SourcingController::class, 'updateProductSourcing'])->name('sourcing.deletteproduct');
        Route::post('/destroy/sourcing/{uuid}', [SourcingController::class, 'destroy'])->name('sourcing.destroy');
        Route::get('/show/sourcing/{uuid}', [SourcingController::class, 'show'])->name('sourcing.show');
        // mise a jour du statut de sourcing
        Route::post('/statut-to-started/{uuid}', [SourcingController::class, 'ToStartedSourcing'])->name('statut.ToStarted');
        Route::post('/statut-to-start-validate-doc/{uuid}', [SourcingController::class, 'TostartValidateDoc'])->name('statut.TostartValidateDoc');
        Route::post('/statut-to-refused/{uuid}', [SourcingController::class, 'ToRefused'])->name('statut.refused');
        Route::post('/statut-to-draft/{uuid}', [SourcingController::class, 'ToDraft'])->name('statut.draft');
        // Doc sourcing validate action
        Route::post('/validate/sourcing/{id}', [SourcingController::class, 'validate_sourcing'])->name('validate.sourcing');
        Route::post('/refused/sourcing/{id}', [SourcingController::class, 'refused_sourcing'])->name('refused.sourcing');
        Route::post('/add/document', [SourcingController::class, 'add_documents'])->name('sourcing.add_documents');
        Route::post('/edit/document/{id}', [SourcingController::class, 'edit_documents'])->name('sourcing.edit_documents');
        Route::post('/receiv/document/{uuid}', [SourcingController::class, 'receptCommercialFact'])->name('sourcing.receptCommercialFact');

        Route::get('/getProductsByFamily/{familyId}', [SourcingController::class, 'getProductsByFamily'])->name('getByFamily');
        Route::post('/add-new-product/{uuid}', [SourcingController::class, 'editProductSourcing'])->name('sourcing.editProduct');

        // declaration import
        Route::post('/declaration-import{uuid}', [SourcingController::class, 'updateDeclaration'])->name('declaration-import.update');

        // Config Route

        Route::get('/config', [ConfigController::class, 'index'])->name('config.index');
        Route::post('store/document', [ConfigController::class, 'store'])->name('config.store');
        Route::get('update/document/{uuid}', [ConfigController::class, 'update'])->name('config.update');
        Route::post('destroy/document/{uuid}', [ConfigController::class, 'destroy'])->name('config.destroy');

            // devise route
            Route::get('/devise', [ConfigController::class, 'indexDevice'])->name('devise.index');
            Route::post('/store/devise', [ConfigController::class, 'addDevice'])->name('devise.store');
            Route::post('/edit/devise/{uuid}', [ConfigController::class, 'editDevice'])->name('devise.update');
            Route::post('/edit/dollar/{uuid}', [ConfigController::class, 'editDollars'])->name('dollar.update');

            // Document requis
            Route::get('/document-requis', [DocumentRequisController::class, 'index'])->name('document-requis');
            Route::post('/document-store', [DocumentRequisController::class, 'store'])->name('document_store');
            Route::post('/document-update/{uuid}', [DocumentRequisController::class, 'update'])->name('document_update');
            Route::post('/document-destroy/{uuid}', [DocumentRequisController::class, 'destroy'])->name('document_destroy');

            // config familly group
            Route::get('/familly/group',[ConfigController::class, 'indexFamillyGroup'])->name('index.familly.group');
            Route::post('/store-familly-group',[ConfigController::class, 'addFamillyGroup'])->name('store.familly.group');
            Route::post('/familly-group-destroy/{uuid}', [ConfigController::class, 'destroyFamillyGroup'])->name('destroyFamillyGroup');


        // Odre de transite route
        Route::get('/od_transite', [OdTransiteController::class, 'index'])->name('od_transite.index');
        Route::post('/store/od_transite', [OdTransiteController::class, 'store'])->name('od_transite.store');
        Route::post('/update/od_transite{uuid}', [OdTransiteController::class, 'update'])->name('od_transite.update');
        Route::get('/show/od_transite{uuid}', [OdTransiteController::class, 'show'])->name('od_transite.show');
        Route::post('/destroy/od_transite/{uuid}', [OdTransiteController::class, 'destroy'])->name('od_transite.destroy');
            // transite document route
            Route::post('delette/doc/transite/{uuid}', [OdTransiteController::class, 'delette_doc_transite'])->name('od_transite.delette_doc');
            Route::post('/od_transite_document', [OdTransiteController::class, 'addTransiteDoc'])->name('od_transite_doc.add');
            Route::post('/transit-receive-document', [OdTransiteController::class, 'receive_doc_transite'])->name('od_transite_doc.receive');
            Route::get('/transit-downloadOtPDF/{id}', [OdTransiteController::class, 'downloadOtPDF'])->name('downloadOtPDF');

        // Odre de livraison route
        Route::get('/od_livraisons', [OdLivraisonController::class, 'index'])->name('od_livraisons.index');
        Route::post('/store/od_livraisons/{uuid}', [OdLivraisonController::class, 'store'])->name('od_livraisons.store');
        Route::post('/update/od_livraisons/{uuid}', [OdLivraisonController::class, 'update'])->name('od_livraisons.update');
        Route::post('/destroy/od_livraisons/{uuid}', [OdLivraisonController::class, 'destroy'])->name('od_livraisons.destroy');
        Route::get('/show/od_livraison/{uuid}', [OdLivraisonController::class, 'show'])->name('od_livraisons.show');
            // transite document route
            Route::post('/add/livraison_document', [OdLivraisonController::class, 'addLivraisonDoc'])->name('od_livraisons.add');
            Route::post('/destroy/livraison_document/{uuid}', [OdLivraisonController::class, 'delette_doc_livraison'])->name('od_livraison_doc.destroy');

            Route::get('/download-ot-PDF/{id}', [OdLivraisonController::class, 'downloadOtPDF'])->name('od_livraison.downloadOtPDF');

            // fonction envoie par mail de l'ordre de transport
            Route::post('/send-ot-email/{id}', [OdLivraisonController::class, 'sendOtEmail'])->name('send.ot.email');

        // Gestion de stock Reception (in sourcing)

        Route::post('/store/stock_reception', [StockController::class, 'receiveProducts'])->name('stock_reception.store');
        Route::post('/store/stockaction', [StockController::class, 'stockProducts'])->name('stockaction.store');

        Route::get('/stock/mouvement', [StockController::class, 'stockMouvement'])->name('stock.mouvement');
        Route::post('/stock/add', [StockController::class, 'addStockProducts'])->name('stock.add.store');
        Route::post('/stock/remove', [StockController::class, 'removeStockProducts'])->name('stock.remove');
            // stock Entrepot route
            Route::get('/stock/entrepot', [EntrepotController::class, 'index'])->name('stock.entrepot');
            Route::post('/store/stock_entrepot', [EntrepotController::class, 'store'])->name('stock_entrepot.store');
            Route::post('/update/stock_entrepot/{uuid}', [EntrepotController::class, 'update'])->name('stock_entrepot.update');
            Route::post('/destroy/stock_entrepot/{uuid}', [EntrepotController::class, 'destroy'])->name('stock_entrepot.destroy');
            Route::get('/stock/entrepot/show/{uuid}', [EntrepotController::class, 'show'])->name('stock_entrepot.show');


        // Export Odre d'expeditions

        Route::get('/export/od-expedition', [OdreExpeditionController::class, 'index'])->name('odre_expedition.index');
        Route::post('/store/odre_expedition', [OdreExpeditionController::class, 'store'])->name('odre_expedition.store');
        Route::get('/show/odre_expedition/{uuid}', [OdreExpeditionController::class, 'show'])->name('odre_expedition.show');
        Route::post('/update/odre_expedition/{uuid}', [OdreExpeditionController::class, 'update'])->name('odre_expedition.update');
        Route::post('/destroy/odre_expedition/{uuid}', [OdreExpeditionController::class, 'destroy'])->name('odre_expedition.destroy');

        Route::post('/declaration-export{uuid}', [OdreExpeditionController::class, 'updateDeclaration'])->name('declaration-export.update');


            Route::post('/update/odre_expedition/product/{uuid}', [OdreExpeditionController::class, 'updateProductExpedition'])->name('expedition.deletteproduct');

            Route::post('/add-new-product-exp/{uuid}', [OdreExpeditionController::class, 'editProductExpedition'])->name('expedition.editProduct');

        Route::post('/mark-to-factured/{uuid}', [OdreExpeditionController::class, 'marckToFactured'])->name('expedition.marckToFactured');
            Route::post('/destroy/exp-file/{uuid}', [OdreExpeditionController::class, 'destroy_file'])->name('expedition.fil.destroy');
            Route::post('/add/exp_document/{uuid}', [OdreExpeditionController::class, 'addExpDoc'])->name('expedition.add');
            // status odre expedition
            Route::post('/expedition-to-started/{uuid}', [OdreExpeditionController::class, 'ToStarted'])->name('expedition.ToStarted');
            Route::post('/expedition-to-validate/{uuid}', [OdreExpeditionController::class, 'ToValidate'])->name('expedition.validate');
            // Route::post('/expedition-to-transit/{uuid}', [OdreExpeditionController::class, 'ToTransit'])->name('expedition.transit');
            Route::post('/expedition-to-wait-expedite/{uuid}', [OdreExpeditionController::class, 'ToWaitExpedite'])->name('expedition.wait_expedite');
            Route::post('/expedition-to-ready/{uuid}', [OdreExpeditionController::class, 'ToReady'])->name('expedition.ready');

            // Ordre de transite To expedition
            Route::get('/export/transit/index', [ExpTransitController::class, 'index'])->name('transit.to_expedition.index');
            Route::post('/transit-export/to-expedition', [ExpTransitController::class, 'store'])->name('transit.to_expedition.store');
            Route::post('/transit-export/destroy/{uuid}', [ExpTransitController::class, 'destroy'])->name('transit.to_expedition.destroy');
            Route::get('/show/transit/{uuid}', [ExpTransitController::class, 'show'])->name('transit.to_expedition.show');
            Route::post('/update/transit/{uuid}', [ExpTransitController::class, 'update'])->name('transit.to_expedition.update');

            //Transit fille
            Route::post('/destroy/transit_document/{uuid}', [ExpTransitController::class, 'delette_doc_transit'])->name('transit.delette_doc');
            Route::post('/add/transit_document/', [ExpTransitController::class, 'addTransitDoc'])->name('transit_doc.add');


            // Ordre de transport To expedition
            Route::get('/export/transport/index', [ExTransportController::class, 'index'])->name('transport.to_expedition.index');
            Route::post('/transport-export/to-expedition', [ExTransportController::class, 'store'])->name('transport.to_expedition.store');
            Route::post('/update/transpor/to-expedition/{uuid}', [ExTransportController::class, 'update'])->name('transport.update');
            Route::post('/destroy/to-expedition/{uuid}', [ExTransportController::class, 'destroy'])->name('transport.destroy');
            Route::get('/show/transport/{uuid}', [ExTransportController::class, 'show'])->name('expTransport.show');
            Route::post('/destockage-export', [ExTransportController::class, 'destockage'])->name('export.destockage');

        // Facturation
        Route::get('/facturation-index', [FacturationController::class, 'index'])->name('facturation');
        Route::post('/store/facturation', [FacturationController::class, 'store'])->name('facturation.store');
        Route::get('/show/facturation/{uuid}', [FacturationController::class, 'show'])->name('facturation.show');
        Route::get('/edit/facturation/{uuid}', [FacturationController::class, 'edit'])->name('facturation.edit');
        Route::post('/update/facturation/{uuid}', [FacturationController::class, 'update'])->name('facturation.update');
        Route::post('/destroy/facturation/{uuid}', [FacturationController::class, 'destroy'])->name('facturation.destroy');
        
        Route::post('/destroy/prestationLines/{uuid}', [FacturationController::class, 'destroyPrestationLines'])->name('destroyPrestationLines');


        Route::post('/marck_to_good_pay/{uuid}', [FacturationController::class, 'marck_to_good_pay'])->name('marck_to_good_pay');
        Route::post('/marck_payed/{uuid}', [FacturationController::class, 'marck_payed'])->name('marck_payed');
        Route::post('/marck_canceled/{uuid}', [FacturationController::class, 'marck_canceled'])->name('marck_canceled');
        //Refacturation

        Route::get('/refacturation-index', [RefacturationController::class, 'index'])->name('refacturation');
        Route::post('/store/refacturation', [RefacturationController::class, 'store'])->name('refacturation.store');
        Route::get('/show/refacturation/{uuid}', [RefacturationController::class, 'show'])->name('refacturation.show');
        Route::post('/destroy/refacturation/{uuid}', [RefacturationController::class, 'destroy'])->name('refacturation.destroy');
        Route::get('/edit/refacturation/{uuid}', [RefacturationController::class, 'edit'])->name('refacturation.edit');
        Route::post('/update/refacturation/{uuid}', [RefacturationController::class, 'update'])->name('refacturation.update');
            // change state refacturation
            Route::post('/marckToSend/refacturation/{uuid}', [RefacturationController::class, 'marckToSend'])->name('refacturation.marckToSend');

            Route::post('/marckToConceled/refacturation/{uuid}', [RefacturationController::class, 'marckToConceled'])->name('refacturation.marckToConceled');

            Route::post('/marckToPayed/refacturation/{uuid}', [RefacturationController::class, 'marckToPayed'])->name('refacturation.marckToPayed');

            Route::post('/send-invoice-email/{id}', [RefacturationController::class, 'sendInvoiceEmail'])->name('send.invoice.email');
            Route::post('/delete.prestationLine/{id}', [RefacturationController::class, 'delettePrestationLine'])->name('delete.prestationLine');

        // Route::get('/downloadPDF/{id}', [RefacturationController::class, 'downloadPDF'])->name('refacturation.downloadPDF');
        // Route::get('/send-facture', [RefacturationController::class, 'send_facture'])->name('refacturation.send_facture');
        Route::get('/downloadPDF/{id}', [RefacturationController::class, 'downloadPDF'])->name('refacturation.downloadPDF');
        Route::post('/send-facture/{id}', [RefacturationController::class, 'send_facture'])->name('refacturation.send_facture');


        // Fact Proforma
        Route::get('/proforma-index', [FactProformaController::class, 'index'])->name('proforma');
        Route::get('/proforma-create', [FactProformaController::class, 'create'])->name('proforma.create');
        Route::get('/proforma-create-transit', [FactProformaController::class, 'createTransit'])->name('proforma.createEdit');
        Route::post('/proforma-store', [FactProformaController::class, 'store'])->name('proforma.store');

        Route::get('/facture_proforma-index', [FactureProformaController::class, 'index'])->name('facture_proforma.index');
        Route::get('/facture_proforma-create', [FactureProformaController::class, 'create'])->name('facture_proforma.create');
        Route::post('/facture_proforma-store', [FactureProformaController::class, 'store'])->name('facture_proforma.store');

        // endPoint Pour les filtre
        Route::get('/destinations/{transporteurUuid}/{porteCharUuid?}', [GrilleTarifController::class, 'getDestinations'])->name('destinations');

        // Exemple dans votre fichier web.php




        // Role Permission
        Route::get('/role', [RoleController::class, 'index'])->name('role');
        Route::post('/role-create', [RoleController::class, 'store'])->name('role.store');
        Route::post('/role-edit/{id}', [RoleController::class, 'update'])->name('role.edit');
        Route::post('/role-destroy/{id}', [RoleController::class, 'destroy'])->name('role.destroy');
        Route::get('/permission/{id}', [RoleController::class, 'permission'])->name('permission');
        Route::post('/permission-create', [RoleController::class, 'permissionStore'])->name('permission.store');
        Route::post('/group-create', [RoleController::class, 'groupStore'])->name('group.store');

        Route::post('/role-permission/{id}', [RoleController::class, 'rolePermissionSave'])->name('permission.save');


        Route::get('/index-grille', [ConfigController::class, 'indexGrille'])->name('grille.index');
        Route::post('/add-destinations', [GrilleTarifController::class, 'storeDestinations'])->name('storeDestinations');
        Route::post('/destroy-destinations/{uuid}', [GrilleTarifController::class, 'destroyDestinations'])->name('destroyDestinations');

        Route::post('/add-porteChar', [GrilleTarifController::class, 'storePorteChar'])->name('storePorteChar');
        Route::post('/destroy-porteChar/{uuid}', [GrilleTarifController::class, 'destroyPorteChar'])->name('destroyPorteChar');

        Route::post('/add-grille', [GrilleTarifController::class, 'store'])->name('offre.store');
        Route::post('/edit-grille/{id}', [GrilleTarifController::class, 'update'])->name('offre.update');
        Route::post('/add-grille-transit', [GrilleTarifController::class, 'storeTransit'])->name('offre.storeTransit');
        Route::post('/edit-grille-transit/{id}', [GrilleTarifController::class, 'updateTransit'])->name('offre.updateTransit');

        // transit had
        Route::get('/transit-config-grille', [GrilleTarifController::class, 'transitGrille'])->name('config.transit.grille');
        Route::post('/transit-add-had', [GrilleTarifController::class, 'storeHad'])->name('transit_had.store');
        Route::post('/destroy-had/{uuid}', [GrilleTarifController::class, 'destroyHad'])->name('destroyHad');
        // Config regime 
        Route::get('/regime', [RegimeController::class, 'index'])->name('regime');
        Route::post('/regime/store', [RegimeController::class, 'store'])->name('regime.store');
        Route::post('/regime/destroy/{uuid}', [RegimeController::class, 'destroy'])->name('regime.destroy');
        // config destination
        Route::get('/destination-index', [DestinationController::class, 'index'])->name('destination.index');
        Route::post('/destination-store', [DestinationController::class, 'store'])->name('destination.store');
        Route::post('/destination-update{uuid}', [DestinationController::class, 'update'])->name('destination.update');
        Route::post('/destination-destroy{uuid}', [DestinationController::class, 'destroy'])->name('destination.destroy');
        // config point d'arret
        Route::get('/arret-index', [ArretController::class, 'index'])->name('arret.index');
        Route::post('/arret-store', [ArretController::class, 'store'])->name('arret.store');
        Route::post('/arret-update{uuid}', [ArretController::class, 'update'])->name('arret.update');
        Route::post('/arret-destroy{uuid}', [ArretController::class, 'destroy'])->name('arret.destroy');

        // sign gnature cacher interne configuration
        Route::get('/signature', [ConfigController::class, 'indexSign'])->name('signature.index');
        Route::post('/signature/store', [ConfigController::class, 'addSign'])->name('signature.store');
        Route::post('/signature/edit{uuid}', [ConfigController::class, 'editSign'])->name('signature.edit');
        Route::post('/signature/destroy/{uuid}', [ConfigController::class, 'destroySign'])->name('signature.destroySign');


        // Module de gestion documentaire
        Route::get('/manager-dossier', [ManageDocumentController::class, 'index'])->name('manager_dossier.index');
        Route::get('/agentStatDocument', [ManageDocumentController::class, 'statistique'])->name('manager_dossier.stat');
        Route::post('/assign-dossier/{uuid}', [ManageDocumentController::class, 'assign'])->name('manage_folder.assign');
        Route::post('/update-dossier/{uuid}', [ManageDocumentController::class, 'update'])->name('manage_folder.update');

        Route::get('/test-email', [ManageDocumentController::class, 'checkEtaAndSendMail']);


            // commentaire du document
            Route::post('/insert-comment', [CommentController::class, 'store'])->name('comment.store');
            // api nbr dossier par agent 
            Route::get('/agent-folder/{uuid}', [ManageDocumentController::class, 'apiFolderByUser'])->name('apiFolderByUser');
            Route::get('/flowchartAgent', [ManageDocumentController::class, 'flowchartAgent'])->name('flowchartAgent');

            Route::post('/update/status-folder/', [ManageDocumentController::class, 'updateStatusFolder'])->name('updateStatusFolder');

        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
  
        Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/show/{uuid}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/update/{uuid}', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

        Route::get('/orders/clients', [OrderController::class, 'index_client'])->name('orders.index_client');
        Route::post('/orders/receivOrder/{uuid}', [OrderController::class, 'receivOrder'])->name('expedition.confirmOrder');


        // Module de rapport
        

        Route::get('/report-facture', [RapportController::class, 'reportFacture'])->name('report.facture');
        Route::get('/report-facture-customer', [RapportController::class, 'reportFactureCustomer'])->name('report.facture.customer');
        Route::get('/report-sourcing', [RapportController::class, 'reportSourcing'])->name('report.sourcing');
        // Route::get('/report-article', [RapportController::class, 'reportArticle'])->name('report.article');
        Route::get('/report-expedition', [RapportController::class, 'reportExpedition'])->name('report.expedition');
        Route::get('/report-exped-filiale', [RapportController::class, 'rapportExpByFiliale'])->name('rapportExpByFiliale');
        // Route::get('/report-transport', [RapportController::class, 'transportReport'])->name('report.transport');

        // Route::get('/livraisons', [RapportController::class, 'transportReport'])->name('report.livraisons');
        Route::get('/report-transport', [RapportController::class, 'transportReport'])->name('report.transport');
        Route::get('/report-livraisons', [RapportController::class, 'getLivraisons'])->name('report.livraisons');
        Route::get('/report-transit', [RapportController::class, 'transitReport'])->name('report.transit');

    

        // Statistic views des articles par statut
        Route::get('/article/inFabrication', [Stock::class, 'inFabrication'])->name('inFabrication');
        Route::get('/article/insortiUsine', [Stock::class, 'insortiUsine'])->name('insortiUsine');
        Route::get('/article/enExpedition', [Stock::class, 'enExpedition'])->name('enExpedition');
        Route::get('/article/arriverAuPod', [Stock::class, 'arriverAuPod'])->name('arriverAuPod');
        Route::get('/article/stocked', [Stock::class, 'stocked'])->name('stocked');
        Route::get('/article/expEnCours', [Stock::class, 'expEnCours'])->name('expEnCours');
        Route::get('/article/delivered', [Stock::class, 'delivered'])->name('delivered');
        Route::get('/article/allProduction', [Stock::class, 'allProduction'])->name('allProduction');



        // web.php

        // interface transitaire
        Route::get('/transitairesform',function(){

            return view('admin.transitaire.ordreTransit');
        });

        // web.php

        Route::get('/notifications/mark-as-read/{id}',[MailController::class,'markAsRead'])->name('notif.markToRead');

        
    });

});


/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/

Route::prefix('user')->name('user.')->group(function(){

    Route::middleware('guest')->group(function(){


    });

    Route::middleware(['auth', 'user-access:' . User::TYPE_USER])->group(function () {

        Route::get('/home', [HomeController::class, 'index'])->name('home');


    });

});

/*------------------------------------------
--------------------------------------------
All Manager Routes List
--------------------------------------------
--------------------------------------------*/

Route::prefix('manager')->name('manager.')->group(function(){

    Route::middleware('guest')->group(function(){

    });

    Route::middleware(['auth', 'user-access:' . User::TYPE_MANAGER])->group(function () {
        Route::get('/home', [HomeController::class, 'managerHome'])->name('home');
    });

});
Route::prefix('transporteur')->name('transporteur.')->group(function(){

    Route::middleware('guest')->group(function(){

    });

    Route::middleware(['auth', 'user-access:' . User::TYPE_TRANSPORTEUR])->group(function () {
        Route::get('/tr/index', [TrController::class, 'index'])->name('index');
        Route::get('/ordreTrIndex', [TrController::class, 'ordreTrIndex'])->name('ordreTrIndex');
    });

});

