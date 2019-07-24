<div class="user-megamenu">
    {!! render($form['user-role']) !!}
    <div class="row">
        <div class="col @if ($form['is_owner']['#value'] == 1)col-xs-6 @endif">
            {!! render($form['my_account']) !!}
            {!! render($form['my_messages']) !!}
            {!! render($form['logout']) !!}
        </div>
        @if ($form['is_owner']['#value'] == 1)
        <div class="col col-user-menu col-xs-6">
            {!! render($form['my_companies']) !!}
            {!! render($form['my_tours']) !!}
        </div>
        @endif
    </div>
</div>
