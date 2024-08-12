<?php

 
    if(  \Auth::user() != null ){


//$permissions = \Auth::user()->getAllPermissions();
//
//dd($permissions);

?>

<div class="side-content-wrap">
    <div class="sidebar-left open" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">

            <li class="nav-item @if( strstr( url()->current() , 'welcome') )  active  @endif" >
                <a class="nav-item-hold" href="{{url('backend/welcome')}}">
                    <i class="fas fa-2x fa-home" aria-hidden="true"></i>
                    <span class="nav-text">Accueil</span>
                </a>
            </li>

            <li class="nav-item @if( strstr( url()->current() , 'games/create') )  active  @endif" >
                <a class="nav-item-hold" href="{{ route('jeux.create') }}">
                    <i class="fas fa-2x fa-plus" aria-hidden="true"></i>
                    <span class="nav-text">{{ __('backend.creerjeu') }} </span>
                </a>
            </li>

            @if( \Auth::user()->hasRole('administrateur')  )
                <li class="nav-item @if( strstr( url()->current() , 'games/index') )  active  @endif" >
                    <a class="nav-item-hold" href="{{ route('jeux.index') }}">
                        <i class="fas fa-2x fa-list" aria-hidden="true"></i>
                        <span class="nav-text">{{ __('backend.listejeu') }}

                            <?php
                                $nb_jeux = \App\Jeu::countIsDemandePublie();
                            ?>

                            @if( $nb_jeux > 0)
                                <br /> <span class="badge-pill badge-danger">  {{ $nb_jeux }} </span>
                            @endif

                        </span>
                    </a>
                </li>
                <li class="nav-item @if( strstr( url()->current() , 'games/corbeille') )  active  @endif" >
                    <a class="nav-item-hold" href="{{ route('jeux.corbeille') }}">
                        <i class="fas fa-2x fa-trash-restore-alt" aria-hidden="true"></i>
                        <span class="nav-text">{{ __('backend.corbeillejeu') }}

                            <?php
                            $nb_jeux_supp = \App\Jeu::onlyTrashed()->count();
                            ?>

                            @if( $nb_jeux_supp > 0)
                                <br /> <span class="badge-pill badge-danger">  {{ $nb_jeux_supp }} </span>
                            @endif
                        </span>
                    </a>
                </li>
            @elseif(  \Auth::user()->aUnJeu() )
                <li class="nav-item @if( strstr( url()->current() , 'games/index') )  active  @endif" >
                    <a class="nav-item-hold" href="{{ route('jeux.index') }}">
                        <i class="fas fa-2x fa-list" aria-hidden="true"></i>
                        <span class="nav-text">{{ __('backend.gererjeux') }}
                            <?php
                            $nb_mes_jeux = \App\Jeu::where('user_id', \Auth::user())->count();
                            ?>

                            @if( $nb_mes_jeux > 0)
                                <br /> <span class="badge-pill badge-danger">  {{ $nb_mes_jeux }} </span>
                            @endif
                        </span>
                    </a>
                </li>
                @if(  \Auth::user()->aUnJeuSupprime() )
                <li class="nav-item @if( strstr( url()->current() , 'games/corbeille') )  active  @endif" >
                    <a class="nav-item-hold" href="{{ route('jeux.corbeille') }}">
                        <i class="fas fa-2x fa-trash-restore-alt" aria-hidden="true"></i>
                        <span class="nav-text">{{ __('backend.corbeillejeu') }} </span>
                    </a>
                </li>
                @endif
            @endif

            @can('accès admin')
            <li class="nav-item @if( strstr( url()->current() , 'admin') || strstr( url()->current() , 'sessions') )  active  @endif " data-item="admin" >
                <a class="nav-item-hold " href="#">
                    <i class="fas fa-2x fa-user-shield" aria-hidden="true"></i>
                    <span class="nav-text">Admin</span>
                </a>
                <div class="triangle"></div>
            </li>
            @endcan

            <li class="nav-item">
            @if(  Session::get('rollback') != null )
                <a href="{{ route('users.rollbacklogin' ) }}" class="nav-item-hold" title="Retour à votre compte utilisateur">
                    <i class="fas fa-2x fa-angle-left"></i>
                </a>
            @else
                    <a class="nav-item-hold button-logout">
                        <i class="fas fa-2x fa-sign-out-alt"></i>
                        <span class="nav-text">Déconnexion</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <div class="triangle"></div>

            @endif
            </li>



        </ul>
    </div>
    <div class="sidebar-left-secondary" data-perfect-scrollbar data-suppress-scroll-x="true">

        {{--@can('accès admin')--}}
            <ul class="childNav" data-parent="admin">
                <li class="nav-item">
                    <a href="{{ route('admin.journal') }}"><i class="nav-icon"></i><span class="item-name">Journal</span></a>
                    <a href="{{ route('contenus.index') }}"><i class="nav-icon"></i><span class="item-name">Contenus</span></a>
                    <a href="{{ route('categories.index') }}"><i class="nav-icon"></i><span class="item-name">Catégories</span></a>
                    <a href="{{ route('users.index') }}"><i class="nav-icon"></i><span class="item-name">Utilisateurs</span></a>
                    <a href="{{ route('roles.index') }}"><i class="nav-icon"></i><span class="item-name">Groupes Utilisateurs</span></a>
                    <a href="{{ route('permissions.index') }}"><i class="nav-icon"></i><span class="item-name">Droits</span></a>


                </li>
            </ul>
        {{--@endcan--}}

    </div>
    <div class="sidebar-overlay"></div>

</div>

<?php
    }
?>
