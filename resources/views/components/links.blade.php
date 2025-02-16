<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    @foreach($links as $link)
    <li class="nav-item ">
        <a href="{{route($link['route'])}}" class="nav-link {{ Route::is($link['active']) ? 'active' : ''}}">
            <i class="nav-icon {{$link['icon']}}"></i>
            <p>
                {{$link['name']}}
            </p>
        </a>
    </li>
    @endforeach
</ul>
