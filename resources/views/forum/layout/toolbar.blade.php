        <div class="container">
        @if($type == 'commentpost')
                <form method = 'POST' action="{{url_remove(url()->current())}}">
            @else
                <form method = 'POST' action="{{url()->current()}}">
                @endif
                {{ csrf_field() }}
                @if(auth_level(6))
                    <input type="submit" name = 'type' value ='ban' onclick="return $(this).append($($('<input>').attr('name','reason').val(prompt('Reason for ban'))))">
                    <input type="submit" name = 'type' value="remove" onclick="return confirm('Are you sure you arent supposed to ban this comment ?')">
                    @else
                    <input type="submit" name = 'type' value="remove" onclick="return confirm('Are you 100% sure you want to delete this comment?')">
                    @endif
                <input type="submit" name = 'type' value ='edit'>
                <input type="number" name = "id" value = '{{$object->id}}' hidden>
            </form>
        </div>