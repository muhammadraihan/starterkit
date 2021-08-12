@php
$sort_child_menu = collect($submenu)->sortBy('order')->toArray();
@endphp
@foreach ( $sort_child_menu as $child_menu)
<li>
    <a href="{{$child_menu->route_name ? route($child_menu->route_name):'#'}}"
        title="{{$child_menu->menu_title ? $child_menu->menu_title:''}}">
        <i class="{{$child_menu->icon_class ? $child_menu->icon_class:''}}"></i>
        <span class="nav-link-text">{{$child_menu->menu_title ? $child_menu->menu_title:''}}</span>
    </a>
</li>
@endforeach