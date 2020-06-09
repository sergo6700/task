<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card :title="$t('reset_password')">
        <ValidationObserver v-slot="{ handleSubmit }">
          <form @submit.prevent="handleSubmit(reset)" @keydown="form.onKeydown($event)">
            <alert-success :form="form" :message="status"/>
            <!-- Email -->
            <ValidationProvider name="email" rules="required|email" v-slot="{ errors }">
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
                <div class="col-md-7">
                  <input v-model="form.email" :class="{  'is-invalid': form.errors.has('email') }" class="form-control"
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
            <ValidationProvider name="password_confirmation" rules="required|min:6|confirmed:password"
                                v-slot="{errors}">
              <!-- Password Confirmation -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">{{ $t('confirm_password') }}</label>
                <div class="col-md-7">
                  <input v-model="form.password_confirmation"
                         :class="{'is-invalid': form.errors.has('password_confirmation') }" class="form-control"
                         type="password" name="password_confirmation">
                  <has-error :form="form" field="password_confirmation"/>
                  <span class="text-danger"><small>{{ errors[0] }}</small></span>
                </div>
              </div>
            </ValidationProvider>
            <!-- Submit Button -->
            <div class="form-group row">
              <div class="col-md-9 ml-md-auto">
                <v-button :loading="form.busy">
                  {{ $t('reset_password') }}
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
      return {title: this.$t('reset_password')}
    },

    data: () => ({
      status: '',
      form: new Form({
        token                 : '',
        email                 : '',
        password              : '',
        password_confirmation : ''
      })
    }),

    created() {
      this.form.email = this.$route.query.email
      this.form.token = this.$route.params.token
    },

    methods: {
      async reset() {
        try{
            const {data} = await this.form.post('/api/password/reset')

            this.status = data.status
        }
        catch{

        }

        // this.form.reset()
      }
    }
  }
</script>
