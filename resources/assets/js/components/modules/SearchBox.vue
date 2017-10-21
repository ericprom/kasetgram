<template>
  <div class="box box-primary">
    <div class="box-body">
      <div class="input-group input-group-sm">
        <input type="text" name="search" class="form-control pull-right" v-model="search.keyword">
        <div class="input-group-btn">
          <button type="button" class="btn btn-default" @click.prevent="searchItem(search.keyword)">
            <i class="fa fa-search"></i> ค้นหา
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    name: 'search-box',
    data() {
      return {
        search:{
          keyword:""
        },
      }
    },
    methods: {
      searchItem (){
        this.$emit('search', this.search)
      },
    }
  }
</script>