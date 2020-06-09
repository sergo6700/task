<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card :title="$t('verify_email')">
        <ValidationObserver v-slot="{ handleSubmit }">
          <form @submit.prevent="handleSubmit(send)" @keydown="form.onKeydown($event)">
            <alert-success :form="form" :message="status"/>
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
            <!-- Submit Button -->
            <div class="form-group row">
              <div class="col-md-9 ml-md-auto">
                <v-button :loading="form.busy">
                  {{ $t('send_verification_link') }}
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
      return {title: this.$t('verify_email')}
    },

    data: () => ({
      status: '',
      form: new Form({
        email: ''
      })
    }),

    created() {
      if (this.$route.query.email) {
        this.form.email = this.$route.query.email
      }
    },

    methods: {
      async send() {
        const {data} = await this.form.post('/api/email/resend')

        this.status = data.status

        this.form.reset()
      }
    }
  }
</script>
