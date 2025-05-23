
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text" style="color:black;">SOFTLOGIS</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li class="">
            <a href="{{ url('/') }}" class="has-arrow active">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title" style="color:black;">Tableau de bord</div>
            </a>
        </li>

        @can('Show Partner')
        <li class="menu-label tex-uppercase" style="color:#0c6dfa;">partenaire</li>
        <li>
            <a href="{{ route('admin.company') }}">
                <div class="parent-icon"><i class="fadeIn animated bx bx-buildings"></i>
                </div>
                <div class="menu-title" style="color:black;">Organisations</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.client') }}">
                <div class="parent-icon"><i class='bx bx-cookie'></i>
                </div>
                <div class="menu-title" style="font-size: 13px !important; color:black;">Clients</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.transporteur') }}">
                <div class="parent-icon"><i class="fadeIn animated bx bx-car"></i>
                </div>
                <div class="menu-title" style="font-size: 13px !important; color:black;">Transporteurs</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.transitaire') }}">
                <div class="parent-icon"><i class="fadeIn animated bx bx-transfer-alt"></i>
                </div>
                <div class="menu-title" style="font-size: 13px !important; color:black;">Transitaires</div>
            </a>
        </li>
        @endcan
            {{-- </ul>
        </li> --}}

        @can('Show Articles')
        <li class="menu-label" style="color:#0c6dfa;">Articles</li>
        <li class="">
            <a href="{{ route('admin.article.index') }}">
                <div class="parent-icon"><i class='bx bx-shopping-bag fs-6'></i>
                </div>
                <div class="menu-title" style="color:black;">Articles</div>
            </a>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;" id="">
                <div class="parent-icon"><i class="fadeIn animated bx bx-equalizer fs-6" id="arrowIcon"></i></div>
                <div class="menu-title" style="color:black;">Variation</div>
            </a>
            <ul id="subMenu">
                <li><a href="{{ route('admin.category') }}" style="color:black;"><i class='bx bx-radio-circle'></i>Categories</a></li>
                <li><a href="{{ route('admin.marque') }}" style="color:black;"><i class='bx bx-radio-circle'></i>Marque</a></li>
                <li><a href="{{ route('admin.ship_source') }}" style="color:black;"><i class='bx bx-radio-circle'></i>Pays D'origine</a></li>
                <li><a href="{{ route('admin.article_model') }}" style="color:black;"><i class='bx bx-radio-circle'></i>Modèle d'articles</a></li>
                <li>
                    <a href="{{ route('admin.article_family') }}">
                        <i class='bx bx-radio-circle' style="color:black;"></i>Designation
                    </a>
                </li>
            </ul>
        </li>
        @endcan

        @canany(['Show Sourcing', 'Show Transit', 'Show Transport'])
            <li class="menu-label" style="color:#0c6dfa;">IMPORT</li>
        @endcanany
        @can('Show Sourcing')
            <li>
                <a href="{{ route('admin.sourcing.index') }}">
                    <div class="parent-icon"><i class="lni lni-link fs-6"></i>
                    </div>
                    <div class="menu-title" style="color:black;">Sourcing</div>
                </a>
            </li>
        @endcan
        @can('Show Transit')
        <li>
            <a href="{{ route('admin.od_transite.index') }}">
                <div class="parent-icon"><i class="fadeIn animated bx bx-hive fs-6"></i>
                </div>
                <div class="menu-title" style="color:black;">Ordre de Transit</div>
            </a>
        </li>
        @endcan
        @can('Show Transport')
        <li>
            <a href="{{ route('admin.od_livraisons.index') }}">
                <div class="parent-icon"><i class="fadeIn animated bx bx-car fs-6"></i>
                </div>
                <div class="menu-title" style="color:black;">Ordre de livraison</div>
            </a>
        </li>
        @endcan
        
        
        @can('Show Transport')
            <li class="menu-label" style="color:#0c6dfa;">DOCUMENTATION</li>
            <li>
                <a href="{{ route('admin.manager_dossier.index') }}">
                    <div class="parent-icon"><i class="lni lni-control-panel fs-6"></i></div>
                    <div class="menu-title" style="color:black;">Gestion Documentaire</div>
                </a>
            </li>
        @endcanany

        @canany('Add Command Statement')
            <li class="menu-label text-uppercase" style="color:#0c6dfa;">Centrale D'achat</li>
            <li>
                <a href="{{ route('admin.orders.index') }}">
                    <div class="parent-icon"><i class='bx bx-cart fs-6'></i></div>
                    <div class="menu-title" style="color:black;">Commandes</div>
                </a>
            </li>
        @endcanany
        @canany('Customer')
            <li>
                <a href="{{ route('admin.orders.index_client') }}">
                    <div class="parent-icon"><i class='bx bx-cart fs-6'></i></div>
                    <div class="menu-title" style="color:black;">Commandes Clients</div>
                </a>
            </li>
        @endcanany

        @canany(['Show Expedition', 'Show Transit', 'Show Transport'])
        <li class="menu-label" style="color:#0c6dfa;">EXPORT</li>
        @endcanany
        @can('Show Expedition')
        <li>
            <a href="{{ route('admin.odre_expedition.index') }}">
                <div class="parent-icon"><i class="lni lni-docker fs-6"></i>
                </div>
                <div class="menu-title" style="color:black;">Ordre d'Expedition</div>
            </a>
        </li>
        @endcan
        @can('Show Transit')
        <li>
            <a href="{{ route('admin.transit.to_expedition.index') }}">
                <div class="parent-icon"><i class="fadeIn animated bx bx-task fs-6"></i>
                </div>
                <div class="menu-title" style="color:black;">Ordre de Transit</div>
            </a>
        </li>
        @endcan
        @can('Show Transport')
        <li>
            <a href="{{ route('admin.transport.to_expedition.index') }}">
                <div class="parent-icon"><i class="fadeIn animated bx bx-task fs-6"></i>
                </div>
                <div class="menu-title" style="color:black;">Ordre de Transport</div>
            </a>
        </li>
        @endcan
        @can('Gerer le Stock')
        <li class="menu-label" style="color:#0c6dfa;">Gestion de Stock</li>
        <li>
            <a href="{{ route('admin.stock.mouvement') }}">
                <div class="parent-icon"><i class="fadeIn animated bx bx-transfer fs-6"></i>
                </div>
                <div class="menu-title" style="color:black;">Mouvement de stock</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.stock.entrepot') }}">
                <div class="parent-icon"><i class="lni lni-dropbox fs-6"></i></i>
                </div>
                <div class="menu-title" style="color:black;">Entrepots</div>
            </a>
        </li>
        @endcan
        @can('Show Facture')
        <li class="menu-label text-uppercase" style="color:#0c6dfa;">Facturation</li>
        <li>
            <a href="{{ route('admin.facturation') }}">
                <div class="parent-icon"><i class="lni lni-notepad fs-6"></i>
                </div>
                <div class="menu-title" style="color:black;">Facture Prestataire</div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.refacturation') }}">
                <div class="parent-icon"><i class="lni lni-amazon-pay fs-6"></i>
                </div>
                <div class="menu-title" style="color:black;">Facture client</div>
            </a>
        </li>
      
        @endcan
        <li class="menu-label text-uppercase" style="color:#0c6dfa;">Offres Tarifaires</li>
        <li>
            <a class="has-arrow" href="javascript:;" id="">
                <div class="parent-icon"><i class="fadeIn animated bx bx-equalizer fs-6" id="arrowIcon"></i></div>
                <div class="menu-title">Grille Tarifaire</div>
            </a>
            <ul id="subMenu">
                <li><a href="{{ route('admin.config.transit.grille')}}"><i class='bx bx-radio-circle'></i>Transitaire</a></li>
                <li><a href="{{ route('admin.proforma') }}"><i class='bx bx-radio-circle'></i>Transporteur</a></li>
            </ul>
        </li>

        <li class="menu-label text-uppercase" style="color:#0c6dfa;">Rapports d'activité</li>
        <li>
            <a class="has-arrow" href="javascript:;" id="">
                <div class="parent-icon"><i class="fadeIn animated bx bx-equalizer fs-6" id="arrowIcon"></i></div>
                <div class="menu-title">Rapports</div>
            </a>
            <ul id="subMenu">
                <li><a href="{{ route('admin.report.facture') }}"><i class='bx bx-radio-circle'></i>Facture prestataire</a></li>
                <li><a href="{{ route('admin.report.facture.customer') }}"><i class='bx bx-radio-circle'></i>Facture client</a></li>
                <li><a href="{{ route('admin.report.sourcing') }}"><i class='bx bx-radio-circle'></i>Sourcing</a></li>
                <li><a href="{{ route('admin.allProduction') }}"><i class='bx bx-radio-circle'></i>Article</a></li>
                <li><a href="{{ route('admin.report.expedition') }}"><i class='bx bx-radio-circle'></i>Expedition</a></li>
                <li><a href="{{ route('admin.rapportExpByFiliale') }}"><i class='bx bx-radio-circle'></i>Expedition par filiale</a></li>
                <li><a href="{{ route('admin.report.transport') }}"><i class='bx bx-radio-circle'></i>Livraison</a></li>
                <li><a href="{{ route('admin.report.transit') }}"><i class='bx bx-radio-circle'></i>Transit</a></li>
            </ul>
        </li>
        @can('Admin Collaborateur')
        <li class="menu-label" style="color:#0c6dfa;">Gestion des Comptes</li>
        <li class="menu-label text-capitalize pt-0 my-0">
            <a href="{{ route('admin.collaborateur.index') }}">
                <div class="parent-icon"><i class="lni lni-consulting fs-6"></i>
                </div>
                <div class="menu-title" style="color:black;">Collaborateurs</div>
            </a>
        </li>
        @endcan

        @can('Admin Collaborateur')
        <li class="menu-label" style="color:#0c6dfa;">Journaux des Tentatives de Connexion</li>
        <li class="menu-label text-capitalize pt-0 my-0">
            <a href="{{ route('admin.admin.logins') }}">
                <div class="parent-icon"><i class="lni lni-consulting fs-6"></i>
                </div>
                <div class="menu-title" style="color:black;">Journaux</div>
            </a>
        </li>
        @endcan
        
        <li class="menu-label py-0 my-0" style="color:#0c6dfa;">Paramètres</li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bx bx-cog fs-6"></i>
                </div>
                <div class="menu-title" style="color:black;">Configuration</div>
            </a>
            <ul>
                {{-- <li> <a href="{{ route('admin.config.index') }}" style="color:black;"><i class='bx bx-radio-circle'></i>Documents</a>
                </li> --}}
                <li> <a href="{{ route('admin.role') }}" style="color:black;"><i class='bx bx-radio-circle'></i>Role</a>
                </li>
                 <li> 
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class="bx bx-cog fs-6"></i>
                        </div>
                        <div class="menu-title">Grille Tarifaire</div>
                    </a>
                    <ul>
                        {{-- <li> <a href="{{ route('admin.config.transit.grille') }}"><i class='bx bx-radio-circle'></i>Transitaire</a> --}}
                        <li> <a href="{{ route('admin.grille.index') }}"><i class='bx bx-radio-circle'></i>Transporteur</a>
                    </ul>
                </li>
                <li> <a href="{{ route('admin.regime') }}" style="color:black;"><i class='bx bx-radio-circle'></i>Regime</a>
                </li>
                <li> <a href="{{ route('admin.index.familly.group') }}" style="color:black;"><i class='bx bx-radio-circle'></i>Family Group</a>
                </li>
                <li> <a href="{{ route('admin.document-requis') }}" style="color:black;"><i class='bx bx-radio-circle'></i>Document requis</a> </li>
                <li> <a href="{{ route('admin.destination.index') }}" style="color:black;"><i class='bx bx-radio-circle'></i>Destination</a> </li>
                
                <li> <a href="{{ route('admin.arret.index') }}" style="color:black;"><i class='bx bx-radio-circle'></i>Point D'arrets</a> </li>
                <li> <a href="{{ route('admin.devise.index') }}" style="color:black;"><i class='bx bx-radio-circle'></i>Taux d'échange</a> </li>
                <li> <a href="{{ route('admin.signature.index') }}" style="color:black;"><i class='bx bx-radio-circle'></i>Signature/Caché</a> </li>
            </ul>
        </li>
       

    </ul>
    <!--end navigation-->
    {{-- <style>
         .metismenu .active {
                color: #0d6efd !important;
                font-weight: 600;
            }
            
            .metismenu .active .parent-icon {
                color: #0d6efd !important;
            }
    </style>
    <script>
        // Sélectionner tous les liens de la sidebar
        const sidebarLinks = document.querySelectorAll('.metismenu a');

        // Parcourir tous les liens et ajouter/supprimer la classe 'active'
        sidebarLinks.forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    </script> --}}
</div>
