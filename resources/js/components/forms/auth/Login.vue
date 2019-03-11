<template>
<form method="POST" action="/login" @submit.prevent="login" id="login">
    <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-right">Username</label>
        <div class="col-md-6">
            <input id="email" type="email" :class="[{ 'is-invalid': errors.email.length }, 'form-control']" v-model="email" name="email" required autofocus>
            <span class="invalid-feedback" role="alert" v-if="errors.email.length"> <strong v-html="errors.email.join('<br/>')"></strong> </span>
        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
        <div class="col-md-6">
            <input id="password" type="password" :class="[{'is-invalid': errors.password.length }, 'form-control']" v-model="password" name="password" required autofocus>
            <span class="invalid-feedback" role="alert" v-if="errors.password.length"> <strong v-text="errors.password.join('<br/>')"></strong> </span>
        </div>
    </div>

    <div class="form-group row">
        <label for="account" class="col-md-4 col-form-label text-md-right">Account</label>
        <div class="col-md-6">
            <div class="form-group">
                <select id="account" :class="[{'is-invalid': errors.account.length}, 'form-control']" v-model="account" name="account">
                    <option>(select one)</option>
                    <option value="admin">Log in as an Admin</option>
                    <option value="manager">Log in as a Manager</option>
                    <option value="editor">Log in as an Editor</option>
                    <option value="user">Log in as a User</option>
                </select>
            </div>
            <span class="invalid-feedback" role="alert" v-if="errors.account.length"> <strong v-html="errors.password.join('<br/>')"></strong> </span>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6 offset-md-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" v-model="remember" />
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-4">
            <button type="submit" class="btn btn-primary">Login</button>
            <a class="btn btn-link" :href="route.password"> Forgot Your Password?</a>
        </div>
    </div>
</form>
</template>

<script>
export default {
    name: "login",
    props: ['route'],
    data(){
        return {
            email: "",
            password: "",
            account: "",
            remember: false,
            errors: {
                email: [],
                password: [],
                account: []
            },
            message: ""
        }
    },
    methods: {
        login(submit){
            let data = {};
            let $form = $(submit.target);
            let $post = $form.serializeArray();
            $post.forEach( p => data[p.name] = p.value);
            console.log(data);

            axios.post($form.attr('action'), data)
                 .then( res => {
                     window.location.reload();
                 } )
                 .catch( err => {
                     let $res = err.response.data;
                     $res.errors.account = [];
                     console.log($res);
                     this.errors = $res.errors;
                     this.message = $res.message;
                 } );
        }
    }
}
</script>

<style>

</style>
