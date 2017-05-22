@if(!is_null($object->content_group_id))
    <li class="content_group title">
            <h4>
                @if(Illuminate\Support\Facades\Auth::user()->level >= $reqlevel)
                    <input type="submit" value = "Leave" name = 'delete' onclick="return $(this).val('{{$object->id*2}}')">
                @endif
                <?php $name = App\class_link_table::where('content_group_id',$object->content_group)->whereNotNull('group_name')->get()->first()->group_name ?>
                    <a href="{{url("content/specialperm/$name")}}">{{$name}}</a>
            </h4>
            <ul>
            @foreach($object->content_group_id as $content)

                @include('specialperm/layout/show',['object' => $content])

            @endforeach
        </ul>
    </li>
@endif