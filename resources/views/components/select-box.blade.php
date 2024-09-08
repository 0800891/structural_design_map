<div>
    <select class="form-select" aria-label="Default select example">
        <option selected>選択してください</option>
        @foreach($options as $key => $value)
            <option value="{{$key}}">{{$value}}</option>
        @endforeach
    </select>
</div>