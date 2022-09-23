<template>
      <v-pagination
      v-model="page"
      :length="lastPage"
      total-visible="7"
      circle
      />
</template>
<script>
export default {
    name: 'PaginationComponent',
    props:{
        paginateData:{
            type: Object,
            default(rawProps) {
                return {  }
            }
        },
    },
    data () {
      return {
        page: 1,
        lastPage: 10,
      }
    },

    watch:{
        paginateData(value) {
            this.page = this.paginateData.meta.current_page
            this.lastPage = this.paginateData.meta.last_page
        },
        page(value){
            this.$emit('paginate', value)
        }
    },
    created() {
      this.page = this.paginateData.meta.current_page
      this.lastPage = this.paginateData.meta.last_page
    },
}
</script>
