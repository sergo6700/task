<template>
  <card :title="$t('your_info')">
    <ValidationObserver v-slot="{ handleSubmit }">
      <form @submit.prevent="handleSubmit(update)" @keydown="form.onKeydown($event)">
        <alert-success :form="form" :message="$t('info_updated')"/>

        <!-- Name -->
        <ValidationProvider name="name" rules="required" v-slot="{ errors }">
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
            <div class="col-md-7">
              <input v-model="form.name" :class="{  'is-invalid': form.errors.has('name')  }" class="form-control"
                     type="text" name="name">
              <has-error :form="form" field="name"/>
              <span class="text-danger">{{ errors[0] }}</span>
            </div>
          </div>
        </ValidationProvider>

        <!-- Email -->
        <ValidationProvider name="email" rules="required|email" v-slot="{ errors }">
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
            <div class="col-md-7">
              <input v-model="form.email" :class="{  'is-invalid': form.errors.has('email') }" class="form-control"
                     type="email" name="email">
              <has-error :form="form" field="email"/>
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
  import {mapGetters} from 'vuex'

  export default {
    scrollToTop: false,

    metaInfo() {
      return {title: this.$t('settings')}
    },

    data: () => ({
      form: new Form({
        name: '',
        email: ''
      })
    }),

    computed: mapGetters({
      user: 'auth/user'
    }),

    created() {
      // Fill the form with user data.
      this.form.keys().forEach(key => {
        this.form[key] = this.user[key]
      })
    },

    methods: {
      async update() {
        const {data} = await this.form.patch('/api/settings/profile')

        this.$store.dispatch('auth/updateUser', {user: data})
      }
    }
  }
</script>
