<header>
    
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand gap-3 justify-content-end">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
            </div>
            <div class="position-relative search-bar d-lg-block d-none" id="current-datetime">
            </div>
              <div class="top-menu ms-auto">
                
                <ul class="navbar-nav align-items-center gap-1">
                

                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#"
                            data-bs-toggle="dropdown"><span class="alert-count">{{! $unreadNotifications ? 0 : count($unreadNotifications)}}</span>
                            <i class='bx bx-bell'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;">
                                <div class="msg-header">
                                    <p class="msg-header-title">Notifications</p>
                                    <p class="msg-header-badge">{{! $unreadNotifications ? 0 : count($unreadNotifications)}} Recents</p>
                                </div>
                            </a>
                            @if(Auth::user()->id_role == 8)
                            <div class="header-notifications-list scroll overflow-auto" style="max-height: 600px">
                                @foreach($allNotifications as $notification)
                                @if($notification->data['title'] == "Instruction de commande" OR $notification->data['title'] == "Enregistrement")
                                <a class="dropdown-item notification-item" data-id="{{ $notification->id }}" href="{{ route('admin.notif.markToRead',$notification->id) }}">
                                        <div class="d-flex align-items-center">
                                            <div class="notify bg-light-danger text-danger" title="{{ $notification->data['user'] }}"><i class='bx bx-bell'></i></div>
                                            <div class="flex-grow-1 {{ $notification->read_at === null ? 'read' : '' }}">
                                                <h6 class="msg-name">
                                                    {{ $notification->data['title'] }} 
                                                    <span class="msg-time float-end">
                                                        {{-- {{ \Carbon\Carbon::parse($notification->data['date'])->locale('fr')->diffForHumans() }}  --}}
                                                        {{ \Carbon\Carbon::parse($notification->data['date']) }} 
                                                    </span>
                                                </h6>
                                                
                                                <p class="msg-info">{{ $notification->data['action'] }}</p>
                                            </div>
                                        </div>
                                </a>
                                @endif
                                @endforeach
                            </div>
                            @elseif(Auth::user()->id_role == 7)
                            <div class="header-notifications-list scroll overflow-auto" style="max-height: 600px">
                                @foreach($allNotifications as $notification)
                                @if($notification->data['title'] == "Instruction de commande")
                                <a class="dropdown-item notification-item" data-id="{{ $notification->id }}" href="{{ route('admin.notif.markToRead',$notification->id) }}">
                                        <div class="d-flex align-items-center">
                                            <div class="notify bg-light-danger text-danger" title="{{ $notification->data['user'] }}"><i class='bx bx-bell'></i></div>
                                            <div class="flex-grow-1 {{ $notification->read_at === null ? 'read' : '' }}">
                                                <h6 class="msg-name">
                                                    {{ $notification->data['title'] }} 
                                                    <span class="msg-time float-end">
                                                        {{-- {{ \Carbon\Carbon::parse($notification->data['date'])->locale('fr')->diffForHumans() }}  --}}
                                                        {{ \Carbon\Carbon::parse($notification->data['date']) }} 
                                                    </span>
                                                </h6>
                                                
                                                <p class="msg-info">{{ $notification->data['action'] }}</p>
                                            </div>
                                        </div>
                                </a>
                                @endif
                                @endforeach
                            </div>
                            @elseif(Auth::user()->id_role == 9)
                            <div class="header-notifications-list scroll overflow-auto" style="max-height: 600px">
                                @foreach($allNotifications as $notification)
                                @if($notification->data['title'] == "Enregistrement - Livraison")
                                <a class="dropdown-item notification-item" data-id="{{ $notification->id }}" href="{{ route('admin.notif.markToRead',$notification->id) }}">
                                        <div class="d-flex align-items-center">
                                            <div class="notify bg-light-danger text-danger" title="{{ $notification->data['user'] }}"><i class='bx bx-bell'></i></div>
                                            <div class="flex-grow-1 {{ $notification->read_at === null ? 'read' : '' }}">
                                                <h6 class="msg-name">
                                                    {{ $notification->data['title'] }} 
                                                    <span class="msg-time float-end">
                                                        {{-- {{ \Carbon\Carbon::parse($notification->data['date'])->locale('fr')->diffForHumans() }}  --}}
                                                        {{ \Carbon\Carbon::parse($notification->data['date']) }} 
                                                    </span>
                                                </h6>
                                                
                                                <p class="msg-info">{{ $notification->data['action'] }}</p>
                                            </div>
                                        </div>
                                </a>
                                @endif
                                @endforeach
                            </div>
                            @elseif(Auth::user()->id_role == 10)
                            <div class="header-notifications-list scroll overflow-auto" style="max-height: 600px">
                                @foreach($allNotifications as $notification)
                                @if($notification->data['title'] == "Ajout de Document - Ordre de transit" OR $notification->data['title'] == "Enregistrement - Ordre de transit")
                                <a class="dropdown-item notification-item" data-id="{{ $notification->id }}" href="{{ route('admin.notif.markToRead',$notification->id) }}">
                                        <div class="d-flex align-items-center">
                                            <div class="notify bg-light-danger text-danger" title="{{ $notification->data['user'] }}"><i class='bx bx-bell'></i></div>
                                            <div class="flex-grow-1 {{ $notification->read_at === null ? 'read' : '' }}">
                                                <h6 class="msg-name">
                                                    {{ $notification->data['title'] }} 
                                                    <span class="msg-time float-end">
                                                        {{-- {{ \Carbon\Carbon::parse($notification->data['date'])->locale('fr')->diffForHumans() }}  --}}
                                                        {{ \Carbon\Carbon::parse($notification->data['date']) }} 
                                                    </span>
                                                </h6>
                                                
                                                <p class="msg-info">{{ $notification->data['action'] }}</p>
                                            </div>
                                        </div>
                                </a>
                                @endif
                                @endforeach
                            </div>
                            @else
                            <div class="header-notifications-list scroll overflow-auto" style="max-height: 600px">
                                @foreach($allNotifications as $notification)
                                <a class="dropdown-item notification-item" data-id="{{ $notification->id }}" href="{{ route('admin.notif.markToRead',$notification->id) }}">
                                        <div class="d-flex align-items-center">
                                            <div class="notify bg-light-danger text-danger" title="{{ $notification->data['user'] }}"><i class='bx bx-bell'></i></div>
                                            <div class="flex-grow-1 {{ $notification->read_at === null ? 'read' : '' }}">
                                                <h6 class="msg-name">
                                                    {{ $notification->data['title'] }} 
                                                    <span class="msg-time float-end">
                                                        {{-- {{ \Carbon\Carbon::parse($notification->data['date'])->locale('fr')->diffForHumans() }}  --}}
                                                        {{ \Carbon\Carbon::parse($notification->data['date']) }} 
                                                    </span>
                                                </h6>
                                                
                                                <p class="msg-info">{{ $notification->data['action'] }}</p>
                                            </div>
                                        </div>
                                </a>
                                @endforeach
                            </div>
                            @endif
                            
                        </div>
                    </li>
                    
                </ul>
            </div>
            <div class="user-box dropdown px-3">
                <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                    @if (!empty(Auth::user()->avatar))
                        <img src="{{ asset("avatars/".auth()->user()->avatar) }}" class="user-img" alt="user avatar">
                    @elseif (auth()->user()->avatar === "default.jpg")
                        <img src="{{ asset("root/default-logo.jpg")}}" class="user-img" alt="user avatar">
                    @endif
                    
                    <div class="user-info">
                        <p class="user-name mb-0">{{ auth()->user()->name. ' ' .auth()->user()->lastname }}</p>
                        <p class="designattion mb-0">{{  auth()->user()->role->name ?? '--'}}</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('admin.profile') }}"><i class="bx bx-user fs-5"></i><span>Mon Profil</span></a>
                    </li>
                    <li>
                        <div class="dropdown-divider mb-0"></div>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                           <i class="bx bx-log-out-circle"></i><span>Deconnexion</span>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    
    {{-- <script>

       document.addEventListener('DOMContentLoaded', function () {
        const notificationItems = document.querySelectorAll('.notification-item');

        notificationItems.forEach(item => {
        item.addEventListener('click', function () {
            const notificationId = this.getAttribute('data-id');

            fetch(`/notifications/mark-as-read/${notificationId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (response.ok) {
                    // Retire la notification de l'affichage après l'avoir marquée comme lue
                    this.remove();

                    fetch('/notifications/unread-count')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('notification-count').innerText = data.unread_count;
                    });

                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        });
    });
});


    </script> --}}

</header>
