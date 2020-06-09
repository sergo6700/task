<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card :title="$t('login')">
        <ValidationObserver v-slot="{ handleSubmit }">
          <form @submit.prevent="handleSubmit(login)" @keydown="form.onKeydown($event)">
            <!-- Email -->
            <ValidationProvider name="email" rules="required|email" v-slot="{ errors }">
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
                <div class="col-md-7">
                  <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control"
                         type="email" name="email">
                  <has-error :form="form" field="email"/>
                  <span class="text-danger"><small>{{ errors[0] }}</small></span>
                </div>
              </div>
            </ValidationProvider>
            <!-- Password -->
            <ValidationProvider name="password" rules="required|min:6" v-slot="{errors}">
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">{{ $t('password') }}</label>
                <div class="col-md-7">
                  <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }"
                         class="form-control" type="password" name="password">
                  <has-error :form="form" field="password"/>
                  <span class="text-danger"><small>{{ errors[0] }}</small></span>
                </div>
              </div>
            </ValidationProvider>
            <!-- Remember Me -->
            <div class="form-group row">
              <div class="col-md-3"/>
              <div class="col-md-7 d-flex">
                <checkbox v-model="remember" name="remember">
                  {{ $t('remember_me') }}
                </checkbox>
                <router-link :to="{ name: 'password.request' }" class="small ml-auto my-auto">
                  {{ $t('forgot_password') }}
                </router-link>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-7 offset-md-3 d-flex">
                <!-- Submit Button -->
                <v-button :loading="form.busy">
                  {{ $t('login') }}
                </v-button>
              </div>
            </div>
          </form>
        </ValidationObserver>
      </card>
    </div>
  </div>
</template>

<script>
  import Form from 'vform'

  export default {
    middleware: 'guest',

    metaInfo() {
      return {title: this.$t('login')}
    },

    data: () => ({
      form: new Form({
        email     : '',
        password  : ''
      }),
      remember: false
    }),

    methods: {
      async login() {
        // Submit the form.
        try{
            const {data} =   await this.form.post('/api/login')
            // Save the token.
            this.$store.dispatch('auth/saveToken', {
              token     : data.token,
              remember  : this.remember
            })
        }
        catch{

        }
        // Fetch the user.
        await this.$store.dispatch('auth/fetchUser')

        // Redirect home.
        this.$router.push({name: 'home'})
      }
    }
  }
</script>
