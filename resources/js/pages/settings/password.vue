<template>
  <card :title="$t('your_password')">
    <ValidationObserver v-slot="{ handleSubmit }">

      <form @submit.prevent="handleSubmit(update)" @keydown="form.onKeydown($event)">
        <alert-success :form="form" :message="$t('password_updated')"/>

        <!-- Password -->
        <ValidationProvider name="password" rules="required|min:6" v-slot="{errors}">
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('new_password') }}</label>
            <div class="col-md-7">
              <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control"
                     type="password" name="password">
              <has-error :form="form" field="password"/>
              <span class="text-danger">{{ errors[0] }}</span>
            </div>
          </div>
        </ValidationProvider>

        <ValidationProvider name="password_confirmation" rules="required|min:6|confirmed:password" v-slot="{errors}">
          <!-- Password Confirmation -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('confirm_password') }}</label>
            <div class="col-md-7">
              <input v-model="form.password_confirmation"
                     :class="{'is-invalid': form.errors.has('password_confirmation') }" class="form-control"
                     type="password" name="password_confirmation">
              <has-error :form="form" field="password_confirmation"/>
              <span class="text-danger">{{ errors[0] }}</span>
            </div>
          </div>
        </ValidationProvider>

        <!-- Submit Button -->
        <div class="form-group row">
          <div class="col-md-9 ml-md-auto">
            <v-button :loading="form.busy" type="success">
              {{ $t('update') }}
            </v-button>
          </div>
        </div>
      </form>
    </ValidationObserver>
  </card>
</template>

<script>
  import Form from 'vform'

  export default {
    scrollToTop: false,

    metaInfo() {
      return {title: this.$t('settings')}
    },

    data: () => ({
      form: new Form({
        password: '',
        password_confirmation: ''
      })
    }),

    methods: {
      async update() {
        await this.form.patch('/api/settings/password').then((response) => {

        }).catch((response) => {

        })
        this.form.reset()
      }
    }
  }
</script>
