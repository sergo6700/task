<template>
  <card :title="$t('resume')">
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
          <!-- First Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('first_name') }}</label>
            <div class="col-md-7">
              <input v-model="form.first_name" :class="{ 'is-invalid': form.errors.has('first_name') }" class="form-control" type="text" name="first_name">
              <has-error :form="form" field="first_name" />
            </div>
          </div>

          <!-- Last Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('last_name') }}</label>
            <div class="col-md-7">
              <input v-model="form.last_name" :class="{ 'is-invalid': form.errors.has('last_name') }" class="form-control" type="text" name="last_name">
              <has-error :form="form" field="last_name" />
            </div>
          </div>

          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
            <div class="col-md-7">
              <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
              <has-error :form="form" field="email" />
            </div>
          </div>

          <!-- Job -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('job') }}</label>
            <div class="col-md-7">
              <input v-model="form.job" :class="{ 'is-invalid': form.errors.has('job') }" class="form-control" type="text" name="job">
              <has-error :form="form" field="job" />
            </div>
          </div>

          <!-- About Me -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('about') }}</label>
            <div class="col-md-7">
              <textarea :class="{ 'is-invalid': form.errors.has('about') }" v-model="form.about" rows="8" class="form-control"  name="about">
                  {{form.about}}
              </textarea>
              <has-error :form="form" field="about" />
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button -->
              <v-button :loading="form.busy">
                {{ $t('update') }}
              </v-button>

            </div>
          </div>
        </form>
  </card>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'
import Swal from 'sweetalert2'

export default {
  middleware: 'auth',

  metaInfo () {
    return { title: this.$t('resume') }
  },

  data: () => ({
    form: new Form({
      first_name : '',
      last_name  : '',
      email      : '',
      job        : '',
      about      : '',
    }),
    mustVerifyEmail: false
  }),

  computed: mapGetters({
    resume: 'resume/resume',
    status: 'resume/status'
  }),

  mounted() {
      this.$store.dispatch('resume/editResume', this.$route.params.id)
      setTimeout(() => {
        this.form.keys().forEach(key => {
          this.form[key] = this.resume[key]
        })
      },500)
  },

   methods: {
    async update () {
      await this.form.patch('/api/resume/'+this.$route.params.id).then((result) => {
        if(result){
          Swal.fire(
              'Success!',
              'Resume has been updated :)',
              'success'
          )
          this.$router.push({name: 'resume.list'})
        }else{
          Swal.fire(
            'Error!',
            'Something wrong :(',
            'error'
          )
        }
      })

      this.$store.dispatch('resume/editResume', this.$route.params.id)
    }
  }
}
</script>
