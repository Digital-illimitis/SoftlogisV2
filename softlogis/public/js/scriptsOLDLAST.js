$(".wrapper").on('click', '.deleteConfirmation', function () {
    var type = $(this).data('type');
    var title = $(this).data('title');
    var message = $(this).data('message');
    var id = $(this).data('id');
    var uuid = $(this).data('uuid');
    var token = $(this).data('token');
    var url = $(this).data('url');
    var urlback = $(this).data('urlback');
    var param = $(this).data('param');
    var param2 = $(this).data('param2');
    var param3 = $(this).data('param3');
    showConfirm_submit(id, uuid, token, url, title, message, param, param2, param3, urlback);
});

function notifier(type, message) {
    Lobibox.notify(type, {
		pauseDelayOnHover: true,
		size: 'mini',
		rounded: true,
		delayIndicator: true,
		continueDelayOnInactiveTab: false,
		position: 'top right',
		msg: message
	});
}

function showConfirm_submit(id, uuid, token, url, title, message, param, param2, param3, urlback) {
    Swal.fire({
            title: title,
            text: message,
            icon: "warning",
            buttons: true,
            dangerMode: true,

            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, continuer !',
            cancelButtonText: 'Annuler',
            confirmButtonClass: 'btn btn-warning',
            cancelButtonClass: 'btn btn-danger ml-1',
        })
        .then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        id: id,
                        uuid: uuid,
                        _token: token,
                        param: param,
                        param2: param2,
                        urlback: urlback
                    },
                    dataType: "json",

                    beforeSend: function () { // if form submit
                        Swal.fire({
                            title: "En cours de traitement...",
                            text: "Patientez un instant",
                            imageUrl: "/assets/images/loading.gif",
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
                    },
                    success: function (data) {
                        if (data.type === "success") { //if formData forme is very good
                            // Swal.fire(data.message, {
                            //     icon: "success"
                            // });
                            // window.location.href =data.urlback;
                            sendSuccess(data.title, data.message, data.urlback);

                        } else {
                            Swal.fire(data.message, {});
                        }
                    },
                    error: function (data) {
                        if (data.type === "error") { // if error occured
                            Swal.fire(data.message, {});
                        }
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                /*Swal.fire({
                    title: 'Cancelled',
                    text: 'Your imaginary file is safe :)',
                    type: 'error',
                    confirmButtonClass: 'btn btn-success',
                })*/
            }

        });
}


function loading() {
    Swal.fire({
        // title: "En cours de traitement...",
        text: "Traitement en cours",
        imageUrl: "/assets/images/loading.gif",
        imageWidth: 50,
        imageHeight: 50,
        showConfirmButton: false,
        allowOutsideClick: true
    });
}

//debut fonction sendSuccess
function sendSuccess(title, message, urlback = '') { // retour en cas de success d'envoi de formulaire
    if (urlback != '') {
        if (urlback == 'back') {
            //Si url de retour exist
            Swal.fire({
                icon: 'success',
                //title: title,
                text: message,
                showConfirmButton: false,
                timer: 3000
            });
            setTimeout(() => {
                location.reload();
            }, 2000);
        } else {
            //Si url de retour exist
            Swal.fire({
                icon: 'success',
                //title: title,
                text: message,
                showConfirmButton: false,
                timer: 2000
            });
            setTimeout(() => {
                window.location.href = urlback;
            }, 2000);
        }
    } else {
        //Si url de retour exist pas dans le retour du formulaire
        Swal.fire({
            icon: 'success',
            //title: title,
            text: message,
            showConfirmButton: true,
            // timer: 2000
        })
        $('.sendForm')[0].reset();
    }
}

function SendError(title, messageError) { //fonction pour envoi de formulaire chargement loading
    Swal.fire({
        icon: 'error',
        title: title,
        text: messageError,
        confirmButtonText: 'FERMER'
    })
} //fin de la focntion SendError

$(".wrapper").on('submit', '.submitForm', function (e) {
    e.preventDefault();
    var action = $(this).attr('action');
    var formData = new FormData(this);

    $.ajax({
        url: action,
        type: 'POST',
        data: formData,
        async: false,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () { // if form submit
            loading();
        },
        success: function (data) {
            if (data.type == "success") { //if formData forme is very good
                sendSuccess(data.title, data.message, data.urlback);
            } else {
                SendError(data.title, data.message);
            }
        },
        error: function (data) {
            if (data.type == "error") { // if error occured
                SendError("messageError");
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});



	// chart 4

            // console.log(clickedUrl);
            var route= $('#chart4').attr('route');
            // alert('ok');
              var formData = {
                  'sourcing': true,
              };
              if (route) {
                
              $.ajax({
                  url:route ,
                  type: 'GET',
                  data: formData,
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  beforeSend: function() { // if form submit
                      console.log('data');
                  },
                  success: function(data) {
                      console.log(data.agents);
                      var options = {
                          series: [{
                              name: 'Total Dossier',
                              data: data.nb_dossiers
                          }, {
                              name: 'Dossier en cours',
                              data: data.nb_dossiers_in_progress
                          }, {
                              name: 'Dossier Terminé',
                              data: data.nb_dossiers_finish
                          }],
                          chart: {
                              foreColor: '#9ba7b2',
                              type: 'bar',
                              height: 360
                          },
                          plotOptions: {
                              bar: {
                                  horizontal: false,
                                  columnWidth: '55%',
                                  endingShape: 'rounded'
                              },
                          },
                          dataLabels: {
                              enabled: false
                          },
                          stroke: {
                              show: true,
                              width: 2,
                              colors: ['transparent']
                          },
                          title: {
                              text: 'Taux de traitement documentaire par agent',
                              align: 'left',
                              style: {
                                  fontSize: '14px'
                              }
                          },
                          colors: ['#0d6efd', "#212529", '#ffc107'],
                          xaxis: {
                              categories:data.agents,
  
                          },
                          yaxis: {
                              title: {
                                  text: '$ (thousands)'
                              }
                          },
                          fill: {
                              opacity: 1
                          },
                          tooltip: {
                              y: {
                                  formatter: function(val) {
                                      return "$ " + val + " thousands"
                                  }
                              }
                          }
                      };
  
                      var chart = new ApexCharts(document.querySelector("#chart4"), options);
                      chart.render();
                  }
              });
    
            }

$('.folderCheck').on('click', function () {
    var docuuid = $(this).val();
    var sourcing = $(this).attr('sourcing');
    var clickedUrl = $(this).attr('clickedUrl');
    console.log(clickedUrl);
  
    var formData={
        'sourcing': sourcing,
        'docuuid': docuuid,
        'status': true,
    };
    $.ajax({
        url: clickedUrl,
        type: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() { // if form submit
            //loading();
        },
        success: function(data) {
            // console.log("goog".data);
            notifier("success", "Document receptionné avec succes");
        }
    });
});

$(document).on('change blur', '.selectedProductUuid', function () {
    var selectedOption = $(this).find('option:selected');
    var selectedProductId = selectedOption.val(); 
    var selectedProductUuid = selectedOption.data('uuid'); 
    var clickedUrl = '/tag-products-by-numero-serie/' + selectedProductId;

    // Cibler uniquement les éléments dans la ligne sélectionnée
    var $row = $(this).closest('.add_new_prod');
    var $designation = $row.find('.designation');
    var $longueur = $row.find('.longueur');
    var $largeur = $row.find('.largeur');
    var $hauteur = $row.find('.hauteur');
    var $poids = $row.find('.poids');

    $.ajax({
        url: clickedUrl,
        type: 'GET',
        beforeSend: function() {
            // 
        },
        success: function(response) {
            var product = response.products;
            // Mettre à jour les valeurs des champs dans la ligne sélectionnée
            $designation.attr('placeholder', response.productByfamilly);
            $longueur.attr('placeholder', product.longueur);
            $largeur.attr('placeholder', product.largeur);
            $hauteur.attr('placeholder', product.hauteur);
            $poids.attr('placeholder', product.poid_tonne);
        },
        error: function(xhr, status, error) {
            // 
        }
    });
});
$(".add_new_product").on('click', '.sup_new_box_doc', function() {
    var i= $(this,'.sup_new_box_doc').attr('id');
     $('#'+i).remove();
});

// Script pour cloner un bloc d'ajout de produit OT
$(".add_new_box_product").on("click", function () {
    var $clone = $('.add_new_prod:last').clone();
    
    $clone.find('input[type="number"]').val(0); 
    $clone.find('input[type="text"]').val(''); 
    $clone.find('input[type="text"]').attr('placeholder', ''); 

    $clone.find('.selectedProductUuid').val(''); 
    
    // Attribution d'identifiants uniques aux éléments clonés
    var i = $('.add_new_prod').length;
    $clone.find('.selectedProductUuid').attr('id', 'single-select-field-' + i);
    $clone.find('.designation').attr('id', 'designation_' + i); 
    $clone.find('.longueur').attr('id', 'longueur_' + i); 
    $clone.find('.largeur').attr('id', 'largeur_' + i); 
    $clone.find('.hauteur').attr('id', 'hauteur_' + i); 
    $clone.find('.poids').attr('id', 'poids_' + i); 
    
    // Insertion de la ligne clonée après la dernière ligne existante
    $clone.insertAfter('.add_new_prod:last');
    
    // Mise à jour de l'identifiant pour la prochaine ligne clonée
    i++;
    $clone.attr('id', i);
    $clone.find('.sup_new_box_doc').attr('id', i);
    
    // Réinitialisation du menu déroulant
    $('#single-select-field-' + i).val('');
});




$(".add_new_content").on('click', '.sup_new_box_doc', function() {
    var i= $(this,'.sup_new_box_doc').attr('id');
     $('#'+i).remove();
});

// window.dataLayer = window.dataLayer || [];
//   function gtag(){dataLayer.push(arguments);}
//   gtag('js', new Date());

//   gtag('config', 'UA-23581568-13');
function readURL(input) {
    if (input.files && input.files[0]) {

        var reader = new FileReader();

        reader.onload = function (e) {
            $('.image-upload-wrap').hide();

            $('.file-upload-image').attr('src', e.target.result);
            $('.file-upload-content').show();

            $('.image-title').html(input.files[0].name);
        };

        reader.readAsDataURL(input.files[0]);

    } else {
        removeUpload();
    }
}

function removeUpload() {
    $('.file-upload-input').replaceWith($('.file-upload-input').clone());
    $('.file-upload-content').hide();
    $('.image-upload-wrap').show();
}
$('.image-upload-wrap').bind('dragover', function () {
    $('.image-upload-wrap').addClass('image-dropping');
});
$('.image-upload-wrap').bind('dragleave', function () {
    $('.image-upload-wrap').removeClass('image-dropping');
});


$(".add_new_box_doc ").on("click", function () {
    // alert('okok');
    var $clone= $('.add_new_doc:last').clone();
    $clone.insertAfter('.add_new_doc:last');
    var i=$('.add_new_doc:last').attr('id');
    i= Number(i)+1;
    $('.add_new_doc:last').attr('id',i);
    // t="p"+i;
    $('.sup_new_box_doc:last').attr('id',i);
    p="p"+i;
    $('.docTitle:last').attr('id',p);
    $('.docTitle:last').val('');
    $('.fileDoc:last').val('');
    
    $('.changeDocument:last').attr('indexe',i);
    
});

$(".add_new_content").on('click', '.sup_new_box_doc', function() {
    var i= $(this,'.sup_new_box_doc').attr('id');
     $('#'+i).remove();
});

// fin de script de clone

$('.add_new_content').on('change', '.changeDocument', function() {
    var val= $(this).val();
    var desc= $(this).attr("description");
    var i= $(this).attr('indexe');
    if (val!="") {
        $('#p'+i).val(desc); 
        $('#p'+i).prop("readonly", true); 
    } else {

        $('#p'+i).prop("readonly", false);
    }
    $('#p'+i).val("");
});



function addNewDocument() {
    // Clone un modèle de document
    const documentContainer = document.getElementById('docu_content');
    const documentTemplate = document.createElement('div');
    documentTemplate.className = 'row col-12';
    documentTemplate.innerHTML = `
                <div class="col-4 mb-3">
                    <input type="text" name="name[]" class="form-control" placeholder="Titre du fichier">
                </div>
                <div class="col-4">
                    <input type="file" accept=".pdf, .doc, .docx, .xls, .xlsx" class="form-control" name="files[]" multiple>
                </div>
                <div class="col-1 delete-document">
                    <button type="button" class="btn btn-outline-danger border border-1 border-danger delete-document-button" onclick="deleteDocSourcing(this)"><i class="bx bx-trash"></i></button>
                </div>
            `;

    // Ajoute le nouveau bloc en dessous de la liste existante
    documentContainer.appendChild(documentTemplate);
}



function deleteDocSourcing(button) {
    // Supprime le bloc parent du bouton de suppression
    const documentContainer = document.getElementById('docu_content');
    const rowToDelete = button.parentNode.parentNode;
    documentContainer.removeChild(rowToDelete);
}

// edit doc form action todoList
function editDocument() {
    // Clone un modèle de document
    const documentEditContainer = document.getElementById('docu_edit_content');
    const documentTemplate = document.createElement('div');
    documentTemplate.className = 'row col-12';
    documentTemplate.innerHTML = `
            <div class="col-5 mb-3">
                <input type="text" name="name" class="form-control" placeholder="Titre du fichier">
            </div>
            <div class="col-6">
                <input type="file" accept=".pdf, .doc, .docx, .xls, .xlsx" class="form-control" name="files[]" multiple>
            </div>
            <div class="col-1 delete-document">
                <button type="button" class="btn btn-outline-danger border border-1 border-danger delete-document-button" onclick="deleteEditDocSourcing(this)"><i class="bx bx-trash"></i></button>
            </div>
        `;

    // Ajoute le nouveau bloc en dessous de la liste existante
    documentEditContainer.appendChild(documentTemplate);
}

function deleteEditDocSourcing(button) {
    // Supprime le bloc parent du bouton de suppression
    const documentEditContainer = document.getElementById('docu_edit_content');
    const rowToDelete = button.parentNode.parentNode;
    documentEditContainer.removeChild(rowToDelete);
}


// edit form action todoList
function editNewRow() {
    const cloneEditLigneProduct = document.getElementById('clone_edit_ligne_prodt');
    const editRow = cloneEditLigneProduct.cloneNode(true);
    const qtyInput = editRow.querySelector('input[name="qty[]"]');
    qtyInput.value = '';
    const productSelect = editRow.querySelector('select[name="product_id[]"]');
    productSelect.value = '';
    cloneEditLigneProduct.parentNode.appendChild(editRow);
}

function deleteEditRow(button) {
    button.parentNode.parentNode.parentNode.removeChild(button.parentNode.parentNode);
}

// Document de ordre de transite
function addNewDoctransite() {
    // Clone un modèle de document
    const documentContainer = document.getElementById('doc_transite_container');
    const documentTemplate = document.createElement('div');
    documentTemplate.className = 'row col-12';
    documentTemplate.innerHTML = `
            <div class="col-5 mb-3">
                <input type="text" name="name[]" class="form-control" placeholder="Titre du fichier">
            </div>
            <div class="col-6">
                <input type="file" accept=".pdf, .doc, .docx, .xls, .xlsx" class="form-control" name="files[]" multiple>
            </div>
            <div class="col-1 delete-document">
                <button type="button" class="btn btn-outline-danger border border-1 border-danger delete-document-button" onclick="deleteDocument(this)"><i class="bx bx-trash"></i></button>
            </div>
        `;

    // Ajoute le nouveau bloc en dessous de la liste existante
    documentContainer.appendChild(documentTemplate);
}

function deleteDocument(button) {
    // Supprime le bloc parent du bouton de suppression
    const documentContainer = document.getElementById('doc_transite_container');
    const rowToDelete = button.parentNode.parentNode;
    documentContainer.removeChild(rowToDelete);
}



// Documents Odre de livraison

function addNewDocLivraison() {
    // Clone un modèle de document
    const documentContainer = document.getElementById('doc_livraison_container');
    const documentTemplate = document.createElement('div');
    documentTemplate.className = 'row col-12';
    documentTemplate.innerHTML = `
            <div class="col-5 mb-3">
                <input type="text" name="name[]" class="form-control" placeholder="Titre du fichier">
            </div>
            <div class="col-6">
                <input type="file" accept=".pdf, .doc, .docx, .xls, .xlsx" class="form-control" name="files[]" multiple>
            </div>
            <div class="col-1 delete-document">
                <button type="button" class="btn btn-outline-danger border border-1 border-danger delete-document-button" onclick="deleteDocument(this)"><i class="bx bx-trash"></i></button>
            </div>
        `;
    // Ajoute le nouveau bloc en dessous de la liste existante
    documentContainer.appendChild(documentTemplate);
}

function downloadFile(url) {
    const link = document.createElement('a');
    link.href = url;
    link.download = filename;
    link.click();
}


function addExpDoc() {
    // Clone un modèle de document
    const documentContainer = document.getElementById('docu_expedition');
    const documentTemplate = document.createElement('div');
    documentTemplate.className = 'row col-12';
    documentTemplate.innerHTML = `
            <div class="col-5 mb-3">
                <input type="text" name="name[]" class="form-control" placeholder="Titre du fichier">
            </div>
            <div class="col-6">
                <input type="file" accept=".pdf, .doc, .docx, .xls, .xlsx" class="form-control" name="files[]" multiple>
            </div>
            <div class="col-1 delete-document">
                <button type="button" class="btn btn-secondary bg-light border-0 delete-document-button" onclick="deleteDocExpedition(this)"><i class="bx bx-trash text-secondary"></i></button>
            </div>
        `;

    // Ajoute le nouveau bloc en dessous de la liste existante
    documentContainer.appendChild(documentTemplate);
}

function deleteDocExpedition(button) {
    // Supprime le bloc parent du bouton de suppression
    const documentContainer = document.getElementById('docu_expedition');
    const rowToDelete = button.parentNode.parentNode;
    documentContainer.removeChild(rowToDelete);
}

// Mouvement de stock add class js
$(document).ready(function () {
    $("#buttonIn").click(function () {
        $("#blockIn").show();
        $("#blockOut").hide();
    });

    $("#buttonOut").click(function () {
        $("#blockIn").hide();
        $("#blockOut").show();
    });

    // Affiche le bloc "In" par défaut
    $("#blockIn").show();
    $("#blockOut").hide();
});

// EXPORT ordre de transite
function addExpDoctransite() {
    // Clone un modèle de document
    const documentExportContainer = document.getElementById('doc_transite_export');
    const documentTemplate = document.createElement('div');
    documentTemplate.className = 'row col-12';
    documentTemplate.innerHTML = `
            <div class="col-5 mb-3">
                <input type="text" name="name[]" class="form-control" placeholder="Titre du fichier">
            </div>
            <div class="col-6">
                <input type="file" accept=".pdf, .doc, .docx, .xls, .xlsx" class="form-control" name="files[]" multiple>
            </div>
            <div class="col-1 delet-document">
                <button type="button" class="btn btn-outline-danger border border-1 border-danger delete-document-utton" onclick="deleteDocExpTransite(this)"><i class="bx bx-trash"></i></button>
            </div>
        `;

    // Ajoute le nouveau bloc en dessous de la liste existante
    documentExportContainer.appendChild(documentTemplate);
}

function deleteDocExpTransite(button) {
    // Supprime le bloc parent du bouton de suppression
    const documentContainer = document.getElementById('doc_transite_export');
    const rowToDelete = button.parentNode.parentNode;
    documentContainer.removeChild(rowToDelete);
}


// EXPORT ordre de transport Doc
function addExpDoctransport() {
    // Clone un modèle de document
    const documentExportContainer = document.getElementById('doc_transport_export');
    const documentTemplate = document.createElement('div');
    documentTemplate.className = 'row col-12';
    documentTemplate.innerHTML = `
            <div class="col-5 mb-3">
                <input type="text" name="name[]" class="form-control" placeholder="Titre du fichier">
            </div>
            <div class="col-6">
                <input type="file" accept=".pdf, .doc, .docx, .xls, .xlsx" class="form-control" name="files[]" multiple>
            </div>
            <div class="col-1 delet-document">
                <button type="button" class="btn btn-outline-danger border border-1 border-danger delete-document-utton" onclick="deleteDocExpTransport(this)"><i class="bx bx-trash"></i></button>
            </div>
        `;

    // Ajoute le nouveau bloc en dessous de la liste existante
    documentExportContainer.appendChild(documentTemplate);
}

function deleteDocExpTransport(button) {
    // Supprime le bloc parent du bouton de suppression
    const documentContainer = document.getElementById('doc_transport_export');
    const rowToDelete = button.parentNode.parentNode;
    documentContainer.removeChild(rowToDelete);
}


$(document).ready(function () {
    // Get references to the select input and the voie-transport-block
    var $typeSelect = $('#type');
    var $voieTransportBlock = $('#voie-transport-block');

    // Initial state
    $voieTransportBlock.hide();

    // Function to handle the select change event
    $typeSelect.on('change', function () {
        if ($typeSelect.val() === 'transporteur') {
            $voieTransportBlock.show();
        } else {
            $voieTransportBlock.hide();
        }
    });
});

$(document).ready(function () {
    // Get references to the select input and the voie-transport-block
    var $typeSelect = $('#typeAdd');
    var $voieTransportBlock = $('#voie-transport-block-add');

    // Initial state
    $voieTransportBlock.hide();

    // Function to handle the select change event
    $typeSelect.on('change', function () {
        if ($typeSelect.val() === 'transporteur') {
            $voieTransportBlock.show();
        } else {
            $voieTransportBlock.hide();
        }
    });
});

const typeSelect = document.getElementById('typeEdit');
const blockTransporteur = document.getElementById('voie-transport-block-edit');

typeSelect.addEventListener('change', () => {
    if (typeSelect.value === 'transporteur') {
        blockTransporteur.style.display = 'block';
    } else {
        blockTransporteur.style.display = 'none';
    }
});

// Vérification de l'état initial
if (typeSelect.value === 'transporteur') {
    blockTransporteur.style.display = 'block';
} else {
    blockTransporteur.style.display = 'none';
}



function addNewRowExp() {
    const cloneLigneProduct = document.getElementById('clone_ligne_prodt');
    const newRow = cloneLigneProduct.cloneNode(true);
    const familleSelect = newRow.querySelector('select[name="famille_id"]');
    const productSelect = newRow.querySelector('select[name="product_id[]"]');
    const uniqueId = Date.now();
    familleSelect.id = 'families_select_' + uniqueId;
    productSelect.id = 'products_select_' + uniqueId;

    familleSelect.value = '';
    productSelect.value = '';

    const productOptions = newRow.querySelectorAll('.product-option');
    for (let i = 0; i < productOptions.length; i++) {
        productOptions[i].style.display = 'block';
    }

    // Ajoute le nouveau bloc cloné en dessous du bloc d'origine
    cloneLigneProduct.parentNode.appendChild(newRow);

    // Ajoute le filtre dynamique pour la nouvelle ligne
    familleSelect.addEventListener('change', function () {
        var selectedFamilleId = familleSelect.value;

        for (var i = 0; i < productOptions.length; i++) {
            var option = productOptions[i];
            var familleId = option.getAttribute('data-famille-exp-id');

            // Afficher ou masquer l'option en fonction de la famille sélectionnée
            option.style.display = (selectedFamilleId === '' || selectedFamilleId === familleId) ? 'block' : 'none';
        }
    });
}




// Expedition lign product add


// function addNewRowExp() {
//     // Clone le bloc "Ligne de produit"
//     const cloneLigneProduct = document.getElementById('clone_ligne_prodt');
//     const newRow = cloneLigneProduct.cloneNode(true);

//     // Efface la valeur du champ "qty"
//     const qtyInput = newRow.querySelector('input[name="qty[]"]');
//     qtyInput.value = '';

//     // Réinitialise la sélection du champ de produit
//     const productSelect = newRow.querySelector('select[name="product_id[]"]');
//     productSelect.value = '';

//     // Ajoute le nouveau bloc cloné en dessous du bloc d'origine
//     cloneLigneProduct.parentNode.appendChild(newRow);
// }

function deleteRow(button) {
    // Supprime le bloc parent du bouton de suppression
    button.parentNode.parentNode.parentNode.removeChild(button.parentNode.parentNode);
}





function editNewRow() {
    const EditCloneLigneProduct = document.getElementById('clone_edit_ligne_prodt');
    const editRow = EditCloneLigneProduct.cloneNode(true);

    // Génère des identifiants uniques pour les éléments select de familles et de produits
    const familleSelectEdit = editRow.querySelector('select[name="famille_id"]');
    const productSelectEdit = editRow.querySelector('select[name="product_id[]"]');
    const uniqueId = Date.now();
    familleSelectEdit.id = 'families_select_' + uniqueId;
    productSelectEdit.id = 'products_select_' + uniqueId;

    // Réinitialise la sélection des champs de famille et de produit
    familleSelectEdit.value = '';
    productSelectEdit.value = '';

    // Réinitialise la sélection des options de produit
    const productOptions = editRow.querySelectorAll('.product-option-edit');
    for (let i = 0; i < productOptions.length; i++) {
        productOptions[i].style.display = 'block';
    }

    // Ajoute le nouveau bloc cloné en dessous du bloc d'origine
    EditCloneLigneProduct.parentNode.appendChild(editRow);

    // Ajoute le filtre dynamique pour la nouvelle ligne
    familleSelectEdit.addEventListener('change', function () {
        var selectedFamilleId = familleSelectEdit.value;

        for (var i = 0; i < productOptions.length; i++) {
            var option = productOptions[i];
            var familleId = option.getAttribute('data-famille-edit-id');

            // Afficher ou masquer l'option en fonction de la famille sélectionnée
            option.style.display = (selectedFamilleId === '' || selectedFamilleId === familleId) ? 'block' : 'none';
        }
    });
}



function toggleDisplay(view) {
    if (view === 'idMensuelBlock') {
        document.getElementById('idMensuelBlock').style.display = 'block';
        document.getElementById('idHebdomadaireBlock').style.display = 'none';
        document.getElementById('idMensuel').classList.add('active');
        document.getElementById('idHebdomadaire').classList.remove('active');
    }
}

function toggleDispla(view) {
    if (view === 'idHebdomadaireBlock') {
        document.getElementById('idHebdomadaireBlock').style.display = 'block';
        document.getElementById('idMensuelBlock').style.display = 'none';
        document.getElementById('idHebdomadaire').classList.add('active');
        document.getElementById('idMensuel').classList.remove('active');
    }
}


function rotationDisplayIn(view) {
    if (view === 'idRotationStockIn') {
        document.getElementById('idRotationStockIn').style.display = 'block';
        document.getElementById('idRotationStockOut').style.display = 'none';
        document.getElementById('btnRotationStockIn').classList.add('active');
        document.getElementById('btnRotationStockOut').classList.remove('active');
    }
}

function rotationDisplayOut(view) {
    if (view === 'idRotationStockOut') {
        document.getElementById('idRotationStockOut').style.display = 'block';
        document.getElementById('idRotationStockIn').style.display = 'none';
        document.getElementById('btnRotationStockOut').classList.add('active');
        document.getElementById('btnRotationStockIn').classList.remove('active');
    }
}

// Block importation switch sourcing transit and transprt

function switchDisplaySourcing(view) {
    if (view === 'blockSourcing') {
        document.getElementById('blockSourcing').style.display = 'block';
        document.getElementById('blockTransit').style.display = 'none';
        document.getElementById('blockTransport').style.display = 'none';
        document.getElementById('btnswitchSourcing').classList.add('active');
        document.getElementById('btnswitchTransit').classList.remove('active');
        document.getElementById('btnswitchtransport').classList.remove('active');
    }
}

function switchDisplayTransit(view) {
    if (view === 'blockTransit') {
        document.getElementById('blockTransit').style.display = 'block';
        document.getElementById('blockSourcing').style.display = 'none';
        document.getElementById('blockTransport').style.display = 'none';
        document.getElementById('btnswitchTransit').classList.add('active');
        document.getElementById('btnswitchSourcing').classList.remove('active');
        document.getElementById('btnswitchtransport').classList.remove('active');
    }
}

function switchDisplayTransport(view) {
    if (view === 'blockTransport') {
        document.getElementById('blockTransport').style.display = 'block';
        document.getElementById('blockSourcing').style.display = 'none';
        document.getElementById('blockTransit').style.display = 'none';
        document.getElementById('btnswitchtransport').classList.add('active');
        document.getElementById('btnswitchSourcing').classList.remove('active');
        document.getElementById('btnswitchTransit').classList.remove('active');
    }
}

// btn swict import hebdomadaire mensuel
function toggleDisplayEtat(view) {
    if (view === 'blockMensueletat') {
        document.getElementById('blockMensueletat').style.display = 'block';
        document.getElementById('blockHebdoetat').style.display = 'none';
        document.getElementById('etatMensuelBtn').classList.add('active');
        document.getElementById('etatHebdoBtn').classList.remove('active');
    }
}

function toggleDisplayEtatHebdo(view) {
    if (view === 'blockHebdoetat') {
        document.getElementById('blockHebdoetat').style.display = 'block';
        document.getElementById('blockMensueletat').style.display = 'none';
        document.getElementById('etatHebdoBtn').classList.add('active');
        document.getElementById('etatMensuelBtn').classList.remove('active');
    }
}

function toggleDisplayBlockExpAll(view) {
    if (view === 'blockGlobalExp') {
        document.getElementById('blockGlobalExp').style.display = 'block';
        document.getElementById('blockMensuelExp').style.display = 'none';
        document.getElementById('btnGlobalExp').classList.add('active');
        document.getElementById('btnMensuelExp').classList.remove('active');
    }
}

function toggleDisplayBlockExpMensuel(view) {
    if (view === 'blockMensuelExp') {
        document.getElementById('blockMensuelExp').style.display = 'block';
        document.getElementById('blockGlobalExp').style.display = 'none';
        document.getElementById('btnMensuelExp').classList.add('active');
        document.getElementById('btnGlobalExp').classList.remove('active');
    }
}


document.addEventListener('DOMContentLoaded', function () {
    const inputModelFacture = document.getElementById('inputModelFacture');
    const input47 = document.getElementById('input47');
    const input46 = document.getElementById('input46');
    const prestataireUuidInput = document.getElementById('prestataireUuid');

    inputModelFacture.addEventListener('change', updatePrestataireUuid);
    input46.addEventListener('change', updatePrestataireUuid);

    function updatePrestataireUuid() {
        const selectedType = inputModelFacture.value === 'transit' ? 'transitaire' : 'transporteur';

        if (selectedType === 'transitaire') {
            const selectedTransitaire = input47.value;
            prestataireUuidInput.value = selectedTransitaire;
        } else if (selectedType === 'transporteur') {
            const selectedTransporteur = input46.value;
            prestataireUuidInput.value = selectedTransporteur;
        }
    }
});

function searchProductsByBonCommand(uniqueId) {
    var input = document.getElementById(`bon_commande_input_${uniqueId}`).value;
    if (!input.trim()) {
        return;
    }
    var url = '/search-products-by-bon-command/' + input;
    fetch(url)
        .then(response => response.json())
        .then(data => {
            var resultsContainer = document.getElementById(`search_resultsByBon_${uniqueId}`);
            resultsContainer.innerHTML = '';

            if (data.products.length === 0) {
                resultsContainer.innerHTML = 'Aucun résultat trouvé.';
                return;
            }
            data.products.forEach(product => {
                var option = document.createElement('div');
                option.classList.add('search-result-bon');
                option.innerText = product.numero_bon_commande;
                option.onclick = function () {
                    document.getElementById(`bon_commande_input_${uniqueId}`).value = product.numero_bon_commande;
                    document.getElementById(`selected_product_id_by_bon_${uniqueId}`).value = product.uuid;
                    resultsContainer.innerHTML = '';
                };
                resultsContainer.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));
}

function searchProductsByNumeroSerie(uniqueId) {
    var input = document.getElementById(`numero_serie_input_${uniqueId}`).value;
    if (!input.trim()) {
        return;
    }
    var url = '/search-products-by-numero-serie/' + input;
    fetch(url)
        .then(response => response.json())
        .then(data => {
            var resultsContainer = document.getElementById(`search_results_${uniqueId}`);
            resultsContainer.innerHTML = '';

            if (data.products.length === 0) {
                resultsContainer.innerHTML = 'Aucun résultat trouvé.';
                return;
            }

            data.products.forEach(product => {
                var option = document.createElement('div');
                option.classList.add('search-result');
                option.innerText = product.numero_serie;
                option.onclick = function () {
                    document.getElementById(`numero_serie_input_${uniqueId}`).value = product.numero_serie;
                    document.getElementById(`selected_product_id_by_serie_${uniqueId}`).value = product.uuid;
                    resultsContainer.innerHTML = '';
                    document.getElementById('search_resultsByBon').innerHTML = '';
                };
                resultsContainer.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));
}

function addNewRow() {
    const cloneLigneProduct = document.getElementById('clone_ligne_prodt');
    const newRow = cloneLigneProduct.cloneNode(true);
    cloneLigneProduct.parentNode.appendChild(newRow);
}

function editoNewRow() {
    const cloneLigneProduct = document.getElementById('clone_edit_ligne_prodt');
    const newRow = cloneLigneProduct.cloneNode(true);
    cloneLigneProduct.parentNode.appendChild(newRow);
}

function addnewBlockProduct() {
    // Clone un modèle de document
    const documentExportContainer = document.getElementById('productBlock');
    const documentTemplate = document.createElement('div');
    const uniqueId = Date.now(); // Utilisez un timestamp unique comme identifiant
    documentTemplate.className = 'row col-12';
    documentTemplate.innerHTML = `
            <div class="col-12 d-flex justify-content-between py-auto align-items-center self-align-center">
            <div class="col-5" style="position: relative;">
            <label for="bon_commande_input_${uniqueId}" class="form-label">Bon de commande</label>
            <input type="text" class="form-control col-3 products_select" name="product_uuid[]" id="bon_commande_input_${uniqueId}" oninput="searchProductsByBonCommand(${uniqueId})">
            <div id="search_resultsByBon_${uniqueId}"
                style="
                width: 280px;
                position: absolute;
                z-index: 1000;
                max-height: 200px;
                overflow-y: auto;
                border: 1px solid #ccc;
                background-color: #fff;">
            </div>
            <input type="hidden" class="form-control col-3" value="" name="product_uuid[]" id="selected_product_id_by_bon_${uniqueId}">
        </div>

        <div class="col-6" style="position: relative;">
            <label for="numero_serie_input_${uniqueId}" class="form-label">N° serie</label>
            <input type="text" class="form-control col-3 products_select" name="product_uuid[]" id="numero_serie_input_${uniqueId}" oninput="searchProductsByNumeroSerie(${uniqueId})">
            <div id="search_results_${uniqueId}"
                style="
                    width: 280px;
                    position: absolute;
                    z-index: 1000;
                    max-height: 200px;
                    overflow-y: auto;
                    border: 1px solid #ccc;
                    background-color: #fff;">
            </div>
            <input type="hidden" class="form-control col-3" value="" name="product_uuid[]" id="selected_product_id_by_serie_${uniqueId}">
        </div>
            <div class="col-1 text-center justify-content-center mt-4">
                <button class="delete-button btn-outline-danger btn" type="button" onclick="deleteRow(this)"><i class="fadeIn animated bx bx-x"></i></button>
            </div>
        </div>


    `;
    documentExportContainer.appendChild(documentTemplate);
}

function deleteproductBlock(button) {
    const documentContainer = document.getElementById('productBlock');
    const rowToDelete = button.parentNode.parentNode;
    documentContainer.removeChild(rowToDelete);
}


function cloneProductRow() {
    var originalRow = document.querySelector('.product-item');
    var newRow = originalRow.cloneNode(true);
    newRow.querySelectorAll('input[type="text"]').forEach(function (input) {
        input.value = '';
    });

    var deleteButton = document.createElement('a');
    deleteButton.setAttribute('type', 'button');
    deleteButton.setAttribute('onclick', 'removeProductRow(this)');

    // Ajouter l'icône à la nouvelle ligne
    var trashIcon = document.createElement('i');
    trashIcon.setAttribute('class', 'bx bxs-trash');
    trashIcon.style.fontSize = '1.5em';
    trashIcon.style.background = 'transparent';
    trashIcon.style.color = '#dc3545';
    deleteButton.appendChild(trashIcon);

    newRow.appendChild(deleteButton);
    document.getElementById('content-block').appendChild(newRow);
}

function removeProductRow(button) {
    var rowToRemove = button.parentNode;
    rowToRemove.parentNode.removeChild(rowToRemove);
}


function tggleFilterBlock(view) {
    if (view === 'blockCategory') {
        document.getElementById('blockCategory').style.display = 'block';
        document.querySelector('.container-slider').style.display = 'block';
        document.querySelector('.container-blockMarque').style.display = 'none';
        document.querySelector('.container-blockFamille').style.display = 'none';
        document.querySelector('.container-blockStatus').style.display = 'none';
        document.getElementById('blockmarque').style.display = 'none';
        document.getElementById('blockFamille').style.display = 'none';
        document.getElementById('blockStatus').style.display = 'none';
    }
}

function toggleFilterBoc(view) {
    if (view === 'blockMarque') {
        document.getElementById('blockmarque').style.display = 'block';
        document.querySelector('.container-blockMarque').style.display = 'block';
        document.querySelector('.container-slider').style.display = 'none';
        document.querySelector('.container-blockFamille').style.display = 'none';
        document.querySelector('.container-blockStatus').style.display = 'none';
        document.getElementById('blockCategory').style.display = 'none';
        document.getElementById('blockFamille').style.display = 'none';
        document.getElementById('blockStatus').style.display = 'none';
    }
}

function toggleFilteBloc(view) {
    if (view === 'blockFamille') {
        document.getElementById('blockFamille').style.display = 'block';
        document.querySelector('.container-blockFamille').style.display = 'block';
        document.querySelector('.container-slider').style.display = 'none';
        document.querySelector('.container-blockMarque').style.display = 'none';
        document.querySelector('.container-blockStatus').style.display = 'none';
        document.getElementById('blockmarque').style.display = 'none';
        document.getElementById('blockCategory').style.display = 'none';
        document.getElementById('blockStatus').style.display = 'none';
    }
}
function toggleFilteBlocStatus(view) {
    if (view === 'blockStatus') {
        document.getElementById('blockStatus').style.display = 'block';
        document.querySelector('.container-blockStatus').style.display = 'block';
        document.querySelector('.container-slider').style.display = 'none';
        document.querySelector('.container-blockMarque').style.display = 'none';
        document.querySelector('.container-blockFamille').style.display = 'none';
        document.getElementById('blockmarque').style.display = 'none';
        document.getElementById('blockCategory').style.display = 'none';
        document.getElementById('blockFamille').style.display = 'none';
    }
}


function cloneBlock() {
    let blockToClone = document.querySelector('.row.mt-2');
    let clonedBlock = blockToClone.cloneNode(true);

    // Vider les valeurs des inputs clonés
    let inputs = clonedBlock.querySelectorAll('input');
    inputs.forEach(input => {
        input.value = '';
    });

    document.addEventListener('input', event => {
        if (event.target && (event.target.name === 'prixUnitaire[]' || event.target.name === 'qty[]')) {
            const prestation = event.target.closest('.row.mt-2');
            const prixUnitaire = prestation.querySelector('[name="prixUnitaire[]"]').value;
            const qty = prestation.querySelector('[name="qty[]"]').value;
            const total = prestation.querySelector('[name="totalLigne[]"]');
            total.value = (prixUnitaire * qty);
        }
    });


    let deleteButton = clonedBlock.querySelector('.delete-btn');
    deleteButton.addEventListener('click', function () {
        clonedBlock.remove();
    });

    let container = document.getElementById('container');
    container.appendChild(clonedBlock);


}

function cloneBlockDoc() {
    let blockToClone = document.querySelector('.docBlock');
    let clonedBlockDoc = blockToClone.cloneNode(true);

    // Vider les valeurs des inputs clonés
    let inputs = clonedBlockDoc.querySelectorAll('input');
    inputs.forEach(input => {
        input.value = '';
    });
    let selects = clonedBlockDoc.querySelectorAll('select');
    selects.forEach(select => {
        select.value = '';
    });



    let container = document.getElementById('contentBlockDoc');
    container.appendChild(clonedBlockDoc);
    let deleteButton = clonedBlockDoc.querySelector('.delete-btn-doc');
    deleteButton.addEventListener('click', function () {
        clonedBlockDoc.remove();
    });

}


document.addEventListener('DOMContentLoaded', function() {
    // Votre code JavaScript ici
    var statusData = {
        labels: ["Livré", "Conforme", "Non conforme", /* ... autres statuts ... */],
        datasets: [{
            data: [50, 30, 20],
            backgroundColor: ["#28a745", "#007bff", "#ffc107", /* ... autres couleurs ... */],
        }],
    };

    // Configuration du graphique
    var statusChartConfig = {
        type: 'pie', // ou 'pie' pour un graphique en secteurs
        data: statusData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: true,
                position: 'right',
            },
        },
    };

    // Récupérer le contexte du canvas et créer le graphique
    var statusChartCanvas = document.getElementById('statusChart').getContext('2d');
    var statusChart = new Chart(statusChartCanvas, statusChartConfig);
});

