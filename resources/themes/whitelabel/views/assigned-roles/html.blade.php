<section>
    <div class="container margin-top-20">
        <div class="row">
            <!-- payment form -->
            <form method="post" action="#" id="payment-form" enctype="multipart/form-data" autocomplete="off" class="sky-form boxed clearfix">
                {!! csrf_field() !!}

                <header>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 text-muted">
                            <h2>
                                @if(isset($id))
                                    {!!trans('general.assign_role.assign-role') !!}
                                @else
                                    {!!trans('general.assign_role.create') !!}
                                @endif
                            </h2>
                        </div>
                    </div>
                </header>

                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <!-- Name -->
                        <div class="form-group {{ $errors->first('name', ' has-error') }}">
                            <label for="user_id" class="input">{{trans('general.assign_role.user-name')}} *
                                {{ Form::select('user_id', $user, isset($user_id) ? $user_id : '' ,['readonly', 'class' => 'form-control']) }}
                                {!! $errors->first('user', '<span class="help-block">:message</span>') !!}
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-6 col-sm-offset-3">
                        <!-- Name -->
                        <div class="form-group {{ $errors->first('name', ' has-error') }}">
                            <label for="name" class="input">{{trans('general.assign_role.role-name')}} *
                                {{ Form::select('role_id', $roles, !empty($role_id) ? $role_id : '0' ,['class' => 'form-control']) }}
                                {!! $errors->first('role', '<span class="help-block">:message</span>') !!}
                            </label>
                        </div>
                    </div>

                </div>


            </form>          
        </div>
            
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <button class="btn btn-colored pull-right" {{ (count($user) > 0) ? '' : 'disabled' }}>
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</section> 