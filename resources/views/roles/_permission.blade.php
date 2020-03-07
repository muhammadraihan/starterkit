<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr" id="{{ isset($title) ? Str::slug($title) :  'permissionHeading' }}">
                <h2 role="button" data-toggle="collapse" href="#" aria-expanded="{{ isset($closed) ? 'true' : 'false' }}"
                    aria-controls="dd-{{ isset($title) ? Str::slug($title) :  'permissionHeading' }}">
                    {{ $title ?? 'Override Permissions' }} {!! isset($user) ? '<span class="text-danger">(' .
                        $user->getDirectPermissions()->count() . ')</span>' : '' !!}
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10"
                        data-original-title="Collapse"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content" id="dd-{{ isset($title) ? Str::slug($title) :  'permissionHeading' }}" class="card-collapse collapse {{ $closed ?? 'in' }}" role="tab" aria-labelledby="dd-{{ isset($title) ? Str::slug($title) :  'permissionHeading' }}">
                    <div class="row">
                        @foreach($permissions as $permission)
                        @php
                        $permission_found = null;
                        if( isset($role) ) {
                        $permission_found = $role->hasPermissionTo($permission->name);
                        }
                        if( isset($user)) {
                        $permission_found = $user->hasDirectPermission($permission->name);
                        }
                        @endphp
                        <div class="col-md-3">
                            <div class="checkbox">
                                <label class="{{ Str::contains($permission->name, 'delete') ? 'text-danger' : '' }}">
                                    {{ Form::checkbox("permissions[]", $permission->name, $permission_found, isset($options) ? $options : []) }}
                                    {{ $permission->name }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>