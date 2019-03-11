<form action="/sites" method="POST">
    @csrf
<div class="form-group row">
    <div class="col">
        <label for="templates">Select a template</label>
        <select id="templates" class="custom-select">
            @foreach ($templates as $name => $path)
            <option value="{{ $path }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col">
        <label for="layouts">Select a layouut</label>
        <select id="layouts" class="custom-select">
            @foreach ($templates as $name => $path)
            <option value="{{ $path }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-1">
        <label for="templates" class="invisible">...</label>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
</form>