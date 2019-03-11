<template>
    <form :action="action" method="POST" @submit.prevent="storePage">
        <input type="hidden" name="_method" value="PUT" v-show="page.id != null">
        <div class="form-group row">
            <div class="col">
                <label for="type">Page type</label>
                <select id="page_type" :class="[{'is-invalid': errors.type.length}, 'form-control']" name="type" v-model="page.type">
                    <option>(select one)</option>
                    <option v-for="(page_type, index) in PageTypes" :value="page_type.name" :key="'pg-type-'+index">{{ page_type.info }}</option>
                </select>
                <small id="helpTypeId" class="form-text text-muted">Help text</small>
            </div>
            <div class="col">
                <label for="label">Placement</label>
                <select id="page_id" :class="[{'is-invalid': errors.page_id.length}, 'form-control']" name="page_id" v-model="page.page_id">
                    <option value="">(select one)</option>
                    <option value="-1">Topmost Page</option>
                    <option v-for="(page, index) in Pages" :value="page.id" :key="page.id  || 'pg-page_id-'+index"> -> /{{ page.url }}</option>
                </select>
                <small id="helpLabelkId" class="form-text text-muted">Help text</small>
            </div>
        </div>
        <div class="form-group">
            <label for="title">Page Title</label>
            <input type="text" :class="[{'is-invalid': errors.title.length}, 'form-control']" name="title" id="title" aria-describedby="helpTitleId" placeholder="title" v-model="page.title">
            <small id="helpTitleId" class="form-text text-muted">Help text</small>
        </div>
        <div class="form-group row">
            <div class="col">
                <label for="label">Menu Label</label>
                <input type="text" :class="[{'is-invalid': errors.label.length}, 'form-control']" name="label" id="label" aria-describedby="helpTitleId" placeholder="label" v-model="page.label">
                <small id="helpTitleId" class="form-text text-muted">Help text</small>
            </div>
            <div class="col">
                <label for="link">Link Segment</label>
                <input type="text" :class="[{'is-invalid': errors.link.length}, 'form-control']" name="link" id="link" aria-describedby="helpLinkId" placeholder="link" v-model="page.link">
                <small id="helpLinkId" class="form-text text-muted">Help text</small>
            </div>
        </div>
        <div class="form-group row">
            <div class="col">
                <label for="layout">Template</label>
                <select id="layout" :class="[{'is-invalid': errors.layout.length}, 'form-control']" name="layout" v-model="page.layout" aria-describedby="helpLayoutId" >
                    <option value="">(select one)</option>
                    <option v-for="(page, index) in Templates" :value="page.path" :key="'pg-layout-'+(page.id || index)">{{ page.name }}</option>
                </select>
                <small id="helpLayoutId" class="form-text text-muted">Help text</small>
            </div>
            <div class="col">
                <label for="view">Layout</label>
                <select id="view" :class="[{'is-invalid': errors.view.length}, 'form-control']" name="view" v-model="page.view">
                    <option value="">(Select One)</option>
                    <option v-for="(page, index) in Layouts" :value="page.path" :key="'pg-view-'+( 'page-view-'+index)">{{ page.name }}</option>
                </select>
                <small id="helpViewId" class="form-text text-muted">Help text</small>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-primary" name="version" value="draft">
                Save Draft <span class="badge badge-primary">...</span>
            </button>
            <button class="btn btn-primary" name="version" value="live">
                Publish <span class="badge badge-primary">...</span>
            </button>
        </div>
    </form>
</template>

<script>
export default {
    name: "page-editor",
    props: ['action', 'pg_id'],
    data(){
        return {
            page : {
                id: this.pg_id || null,
                page_id: -1,
                title: "",
                name: "",
                link: "",
                label: "",
                type: "",
                layout: "",
                view: ""
            },
            errors: {},
            Layouts: {},
            Pages: {},
            PageTypes: {},
            Templates: {},
            obj: {}
        }
    },
    created(){
        let $self = this, $page_data = '/pages/' + !(this.pg_id)? 'create': this.pg_id;
        _.forOwn($self.page, (obj, k) => $self.errors[k] = [] );

        axios.get($page_data )
                .then(res => {
                    let $data = res.data;

                    $self.Pages = $data.Pages;
                    $self.Layouts = $data.Layouts;
                    $self.Templates = $data.Templates;
                    $self.PageTypes = $data.PageTypes;

                    if($data.page && $data.page.length){
                        $self.page = $data.page;
                    }
                    else if($self.page_id != -1 && $self.Pages.length){
                        $self.page = $self.Pages.find( p => p.id == $self.id);
                    }
                })
                .catch(err => console.log(err.response));
    },
    updated(){
        // axios.get('/pages/create')
        // .then(res => console.log(res.data))
        // .catch();
    },
    methods: {
        storePage(form){
            let $self = this, $data = {}, $form = $(form.target), $post = $form.serializeArray();
            $post.forEach(input => { $data[input.name] = input.value; });
            axios({
                url: $form.attr('action'),
                method: $data['_method'] || 'post',
                data: $data
            })
            .then( res => console.log(res.data))
            .catch( err => console.log(err.response.data));
        }
    }
}
</script>

<style>

</style>
