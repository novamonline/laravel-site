
<page-editor action="/pages/{{ $page->id ?? '' }}" pg_id="{{ $page->id }}">

</page-editor>
<form action="/pages/{{ $page->id ?? '' }}" method="POST">
    @csrf
    @isset($page->id) @method('PUT') @endisset


    {{-- <div class="form-group row">
        <div class="col">
            <label for="type">Page type</label>
            <select id="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" name="type">
                <option>(select one)</option>
                @foreach ($object = ['PageController' => 'Basic Page', 'BlogController' => 'Blog Page'] as $type => $info)
                    {!! $selectOption($object, 'type', $page->type, $info) !!}
                @endforeach
            </select>
            <small id="helpTypeId" class="form-text text-muted">Help text</small>
        </div>
        <div class="col">
            <label for="label">Page Under</label>
            <select id="page_id" class="form-control{{ $errors->has('page_id') ? ' is-invalid' : '' }}" name="page_id">
                <option>(select one)</option>
                <option value="-1">Top Most</option>
                @foreach($Pages->resource as $pg)
                    {!! $selectOption($Pages->resource, 'page_id', $page->page_id ?? old('page_id'), $pg->url) !!}
                @endforeach
            </select>
            <small id="helpLabelkId" class="form-text text-muted">Help text</small>
            </div>
    </div>
    <div class="form-group">
        <label for="title">Page Title</label>
        <input type="text" class="form-control" name="title" id="title" aria-describedby="helpTitleId" placeholder="title" value="{{ $pg->title ?? old('title') }}">
        <small id="helpTitleId" class="form-text text-muted">Help text</small>
    </div>
    <div class="form-group row">
        <div class="col">
            <label for="label">Menu Label</label>
            <input type="text" class="form-control" name="label" id="label" aria-describedby="helpLabelkId"
                placeholder="label that shows on menus" value="{{ $page->label ?? old('label') }}">
            <small id="helpLabelkId" class="form-text text-muted">Help text</small>
        </div>
        <div class="col">
            <label for="link">Link Segment</label>
            <input type="text" class="form-control" name="link" id="link" aria-describedby="helpLinkId" placeholder="last part of the link" value="{{ $pg->link ?? old('link') }}">
            <small id="helpLinkId" class="form-text text-muted">Help text</small>
        </div>
    </div>
    <div class="form-group row">
        <div class="col">
            <label for="layout">Template</label>
            <select id="layout" class="form-control{{ $errors->has('layout') ? ' is-invalid' : '' }}" name="layout">
                <option>(select one)</option>
                @foreach ($Templates as $tplt)
                {!! $selectOption($Templates, 'path', $page->layout, $tplt['name']." Template") !!}
                @endforeach
            </select>
            <small id="helpLinkId" class="form-text text-muted">Help text</small>
        </div>
        <div class="col">
            <label for="view">Layout</label>
            <select id="view" class="form-control{{ $errors->has('view') ? ' is-invalid' : '' }}" name="view">
                <option>(select one)</option>
                {!! $selectOption('view', $page->view, "$page->view Layout") !!}
            </select>
            <small id="helpLabelkId" class="form-text text-muted">Help text</small>
        </div>
    </div>
    <div class="form-group">
        <button class="btn btn-primary" name="version" value="draft">
            Save Draft <span class="badge badge-primary">...</span>
        </button>
        <button class="btn btn-primary" name="version" value="live">
            Publish <span class="badge badge-primary">...</span>
        </button>
    </div> --}}
</form>
