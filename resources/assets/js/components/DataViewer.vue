<template>
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        <i class="fa fa-list"></i> {{config.title}}
      </h3>
      <div class="box-tools pull-right">
        <span class="badge bg-light-blue">{{pagination.total}}</span>
      </div>
    </div>
    <div class="box-body no-padding">
      <table class="table">
        <thead>
          <tr>
            <th v-for="column in config.columns" :style="{ width: column.width + '%' }">
              <span>{{column.name}}</span>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="row in items">
            <td v-for="(value, key) in row" v-if="isHidden(key)">
              <span v-for="(val, idx) in value" v-if="isArray(value)">
                {{displayData(val.name, idx)}}
              </span>
              <span v-if="isObject(value)">
                {{displayData(value.name, key)}}
              </span>
              <span v-if="!isArray(value) && !isObject(value)">
                {{displayData(value, key)}}
              </span>
            </td>
            <td v-if="isEditable()" width="10%">
              <div class="pull-right">
                <button type="button" class="btn btn-box-tool" @click.prevent="updateData(row)">
                  <i class="fa fa-edit" style="font-size: 18px;"></i>
                </button>
                <button type="button" class="btn btn-box-tool" @click.prevent="deleteData(row)">
                  <i class="fa fa-ban" style="font-size: 18px;"></i>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="box-footer">
      <div class="pull-right">
        <span style="margin-right:10px;">
          <span style="margin-right:10px;">{{pagination.from}} - {{pagination.to}} of {{pagination.total}} </span>
          <div class="btn-group btn-group-sm" role="group" aria-label="Small button group"> 
            <button type="button" class="btn btn-default"  
              @click.prevent="changePage(pagination.current_page - 1)"
              :disabled="pagination.current_page <= 1">
              <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </button> 
            <button type="button" class="btn btn-default"  
              @click.prevent="changePage(pagination.current_page + 1)"
              :disabled="pagination.current_page >= pagination.last_page">
              <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </button> 
          </div>
        </span>
      </div>
    </div>
  </div>
</template>
<script>
  import Vue from 'vue'
  import axios from 'axios'
  import moment from 'moment'
  export default {
    name: 'data-viewer',
    props: ['configs'],
    data() {
      return {
        config:{},
        items: [],
        pagination: {
          total: 0, 
          per_page: 10,
          from: 1, 
          to: 0,
          current_page: 1
        },
        offset: 4
      }
    },
    created() {
      this.config = this.configs
      Store.dispatch('updateQuery','')
      var query = this.createQuery(this.pagination.current_page)
      this.fetchData(query)
    },
    computed: {
      pagesNumber (query) {
        if (!this.pagination.to) {
            return []
        }
        var from = this.pagination.current_page - this.offset
        if (from < 1) {
            from = 1
        }
        var to = from + (this.offset * 2)
        if (to >= this.pagination.last_page) {
            to = this.pagination.last_page
        }
        var pagesArray = []
        while (from <= to) {
            pagesArray.push(from)
            from++
        }
        return pagesArray
      }
    },
    methods: {
      createQuery(page){
        var query = [];
        query.push(this.config.api)
        query.push('?page='+page)
        query.push(Store.getters.searchQuery)
        return query.join('')
      },
      searchData(data) {
        var search = [];
        Object.keys(data).forEach(function(key) {
          search.push('&'+key+'='+data[key]);
        });
        Store.dispatch('updateQuery',search.join(''))
        var query = this.createQuery(this.pagination.current_page)
        this.fetchData(query)
      },
      reloadData() {
        var query = this.createQuery(this.pagination.current_page)
        this.fetchData(query)
      },
      fetchData(query) {
        var self = this
        axios.get(query)
          .then(function(response) {
            self.items = response.data.data.data
            self.pagination = response.data.pagination
          })
          .catch(function(response) {
            console.log(response)
          })
      },
      updateData (data){
        this.$emit('update', data)
      },
      deleteData (data){
        this.$emit('delete', data)
      },
      changePage (page) {
        this.pagination.current_page = page
        var query = this.createQuery(page)
        this.fetchData(query)
      },
      isHidden( key ) {
        if(this.config.hidden && this.config.hidden.indexOf(key) >= 0){
          return false
        }
        else{
          return true
        }
      },
      isEditable( ) {
        if(this.config.edit){
          return true
        }
        else{
          return false
        }
      },
      displayData(data, key){
        if(key && key.indexOf('date') > -1){
          return this.displayDate(data)
        }
        else{
          return data
        }
      },
    }
  }
</script>