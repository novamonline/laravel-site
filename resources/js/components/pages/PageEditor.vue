<template>
    <form :action="action" method="POST" @submit.prevent="storePage" @change="checkField" @keyup="checkField">
        <div :class="[alert_class, 'alert']" role="alert">
            <h4 class="alert-heading"></h4>
            <p>{{ message }}</p>
            <p class="mb-0"></p>
        </div>
        <template v-if="page.id">
        <input type="hidden" name="_method" value="PUT" />
        </template>
        <div class="form-group row">
            <div class="col">
                <label for="type">Page type</label>
                <select id="page_type" :class="[{'is-invalid': errors.type.length}, 'form-control']" name="type" v-model="page.type">
                    <option>(select one)</option>
                    <option v-for="(page_type, index) in PageTypes" :value="page_type.name" :key="'pg-type-'+index">{{ page_type.info }}</option>
                </select>
                <small id="helpTypeId" class="form-text text-muted">Help text</small>
                <span class="invalid-feedback" v-if="errors.type.length">{{ errors.type.join('<br/>') }}</span>
            </div>
            <div class="col">
                <label for="label">Placement</label>
                <select id="page_id" :class="[{'is-invalid': errors.page_id.length}, 'form-control']" name="page_id" v-model="page.page_id">
                    <option value="">(select one)</option>
                    <option value="-1">Topmost Page</option>
                    <option v-for="(page, index) in Pages" :value="page.id" :key="page.id  || 'pg-page_id-'+index"> -> /{{ page.url }}</option>
                </select>
                <small id="helpLabelkId" class="form-text text-muted">Help text</small>
                <span class="invalid-feedback" v-if="errors.page_id.length">{{ errors.page_id.join('<br/>') }}</span>
            </div>
        </div>
        <div class="form-group">
            <label for="title">Page Title</label>
            <input type="text" :class="[{'is-invalid': errors.title.length}, 'form-control']" name="title" id="title" aria-describedby="helpTitleId" placeholder="title" v-model="page.title">
            <small id="helpTitleId" class="form-text text-muted">Help text [{{ errors.title.length }}]</small>
            <span class="invalid-feedback" v-if="errors.title.length">{{ errors.title.join('<br/>') }}</span>
        </div>
        <div class="form-group row">
            <div class="col">
                <label for="label">Menu Label</label>
                <input type="text" :class="[{'is-invalid': errors.label.length}, 'form-control']" name="label" id="label" aria-describedby="helpTitleId" placeholder="label" v-model="page.label">
                <small id="helpTitleId" class="form-text text-muted">Help text [{{ errors.label.length }}]</small>
                <span class="invalid-feedback" v-if="errors.label.length" v-html="errors.label.join('<br/>')"></span>
            </div>
            <div class="col">
                <label for="link">Link Segment</label>
                <input type="text" :class="[{'is-invalid': errors.link.length}, 'form-control']" name="link" id="link" aria-describedby="helpLinkId" placeholder="link" v-model="page.link">
                <small id="helpLinkId" class="form-text text-muted" v-if="!errors.link.length">Help text</small>
                <span class="invalid-feedback" v-if="errors.link.length" v-html="errors.link.join('<br />')"></span>
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
                <span class="invalid-feedback" v-if="errors.layout.length" v-html="errors.layout.join('<br/>')"></span>
            </div>
            <div class="col">
                <label for="view">Layout</label>
                <select id="view" :class="[{'is-invalid': errors.view.length}, 'form-control']" name="view" v-model="page.view">
                    <option value="">(Select One)</option>
                    <option v-for="(page, index) in Layouts" :value="page.path" :key="'pg-view-'+( 'page-view-'+index)">{{ page.name }}</option>
                </select>
                <small id="helpViewId" class="form-text text-muted">Help text</small>
                <span class="invalid-feedback" v-if="errors.view.length">{{ errors.view.join('<br/>') }}</span>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-primary" :name="'version'" value="draft">
                Save Draft <span class="badge badge-primary">...</span>
            </button>
            <button class="btn btn-primary" :name="'version'" value="live">
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
            base: {
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
            page:this.base,
            errors: {},
            Layouts: {},
            Pages: {},
            PageTypes: {},
            Templates: {},
            obj: {},
            message: "",
            alert_class: "collapse"
        }
    },
    computed: {
        paged(){
            return this.base;
        }
    },
    created(){
        let $self = this, $page_data = '/pages/' + !(this.pg_id? 'create': this.pg_id);
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
                .catch(err => {

                });
    },
    updated(){
        // axios.get('/pages/create')
        // .then(res => console.log(res.data))
        // .catch();
        this.created();
    },
    methods: {
        checkField(field){
            var $input = $(field.target).attr('name');
            this.errors[$input] = [];
        },
        storePage(form){
            let $self = this, $data = {}, $form = $(form.target), $post = $form.serializeArray();
            $post.forEach(input => { $data[input.name] = input.value; });
            axios({
                url: $form.attr('action'),
                method: $data['_method'] || 'post',
                data: $data
            })
            .then( res => {
                $self.alert_class = "alert-success";
            })
            .catch( err => {
                $self.alert_class = "alert-danger";
                $self.message = err.response.data.message;
                let $errors = err.response.data.errors;
                _.forOwn($errors, (arr, k) => $self.errors[k] = arr );
            });
        }
    }
}
</script>

<style>

</style>
