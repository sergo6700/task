<template>
  <card :title="$t('list')">
    <b-table
                show-empty
                small
                striped
                hover
                stacked="md"
                :items="items"
                :fields="fields"
                :current-page="currentPage"
                :per-page="perPage"
                :filter="filter"
                :filterIncludedFields="filterOn"
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"
                :sort-direction="sortDirection"
                @filtered="onFiltered"
            >
                <template v-slot:cell(delete)="data">
                    <b-button variant="danger" @click="deleteUser(data.item.id)" size="sm deleteButton">
                        {{$t('delete')}}
                    </b-button>
                </template>
                <template v-slot:cell(update)="data">
                    <b-button variant="warning" @click="updateUser(data.item.id)" size="sm deleteButton">
                        {{$t('update')}}
                    </b-button>
                </template>
            </b-table>
                <b-pagination
                    v-model="currentPage"
                    :total-rows="totalRows"
                    :per-page="perPage"
                    align="fill"
                    size="sm"
                    class="my-0"
                ></b-pagination>
  </card>
</template>

<script>
import { mapGetters } from 'vuex'
import Swal from 'sweetalert2'

export default {
  middleware: 'auth',

 data: () => ({
     items: null,
     fields: [
                    { key: 'id', label: '#', sortable: true, sortDirection: 'desc' },
                    { key: 'first_name', label: 'Person  Name', sortable: true, sortDirection: 'desc' },
                    { key: 'job', label: 'Person  Job', sortable: true, sortDirection: 'desc' },
                    { key: 'email', label: 'Person email', sortable: true, class: 'text-center' },
                    { key: 'delete', label: 'Delete' },
                    { key: 'update', label: 'Update' }
                ],
                totalRows: 0,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                filterOn: [],
  }),
   
   
  computed: {
    sortOptions() {
        // Create an options list from our fields
        return this.fields
          .filter(f => f.sortable)
          .map(f => {
              return { text: f.label, value: f.key }
          })
      },
    ...mapGetters({
      list   : 'resume/data',
      status : 'resume/status'
    })
  },

  mounted() {
      this.$store.dispatch('resume/fetchResume')
      setTimeout(() => {
        this.items = this.list
        this.totalRows = this.list.length
      },500)
  },
 
  metaInfo () {
    return { title: this.$t('list') }
  },

   methods: {
      onFiltered(filteredItems) {
          // Trigger pagination to update the number of buttons/pages due to filtering
          this.totalRows = filteredItems.length;
          this.currentPage = 1;
      },
      deleteUser(id){
          Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'question',
              showCancelButton: true,
              confirmButtonText: 'Yes, delete it!',
              cancelButtonText: 'No, cancel!',
              reverseButtons: true
          }).then((result) => {
              if(result.value){
                  this.$store.dispatch('resume/deleteResume', id )
                  setTimeout(()=>{
                    if(this.status == '200'){
                      Swal.fire(
                        'Deleted!',
                        'Resume has been deleted :(',
                        'success'
                      );
                      let index = this.items.findIndex(item => item.id === id);
                      this.items.splice(index, 1)
                    }else{
                      Swal.fire(
                          'Error',
                          'Somethings wrong!',
                          'error'
                      )
                    }
                  },400)
              }
              else if (
                  /* Read more about handling dismissals below */
                  result.dismiss === Swal.DismissReason.cancel
              ) {
                  Swal.fire(
                      'Cancelled',
                      'Your Resume is safe :)',
                      'error'
                  )
              }
          });
      },
      updateUser(id){
          this.$router.push({ name: 'resume.update' ,params: {id:id} })
      }
   }
}
</script>
