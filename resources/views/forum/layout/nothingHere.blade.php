
@include('forum/layout/nav',['type' =>'nothing','back' => $back,'new' => $type])

@if($type == 'comment')
    <div class="checkhereplsjavascript">
        <div class="container">
            @if(user_edit_permission($back['post']))
                @include('forum/layout/toolbar',['type' => 'post'])
            @endif
            @include('forum/layout/commentpost',['post' => $back['post'],'comment' => 'value'])
            <hr>
        </div>
    </div>
    <br>

@endif

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Error 404 :</b> fun not found <b>*</b>SadFace<b>*</b></div>

                <div class="panel-body">
                    @if($type == 'comment')
                    Nothing here Yet be the first one to comment something
                        @endif

                    @if($type == 'post')
                        No posts here Yet be the first one to post something here !
                        @endif
                    @if($type == 'subtopic')
                        No Sub-Topics Here Get a mod to add one !
                        @endif

                    @if($type == 'maintopic')
                        Place here your Maintopics, this will be the first catogories that they get
                        @endif

                </div>
            </div>
        </div>
    </div>
</div>