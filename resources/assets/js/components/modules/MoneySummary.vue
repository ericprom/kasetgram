<template>
  <div class="row">
    <div :class="config.class">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>{{formatMoney(total.cash)}} </h3>
          <p>เงินสด</p>
        </div>
        <div class="icon">
          <i class="fa fa-money"></i>
        </div>
      </div>
    </div>
    <div :class="config.class">
      <div class="small-box bg-green">
        <div class="inner">
          <h3>{{formatMoney(total.transfer)}} </h3>
          <p>เงินโอน</p>
        </div>
        <div class="icon">
          <i class="fa fa-money"></i>
        </div>
      </div>
    </div>
    <div :class="config.class">
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>{{formatMoney(total.cheque)}} </h3>
          <p>เชค</p>
        </div>
        <div class="icon">
          <i class="fa fa-money"></i>
        </div>
      </div>
    </div>
    <div :class="config.class">
      <div class="small-box bg-red">
        <div class="inner">
          <h3>{{formatMoney(total.credit)}} </h3>
          <p>บัตรเครดิต</p>
        </div>
        <div class="icon">
          <i class="fa fa-money"></i>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import axios from 'axios'
  export default {
    name: 'money-summary',
    props: ['configs'],
    data() {
      return {
        config:{},
        total: {
          cash: 0,
          transfer: 0,
          cheque: 0,
          credit: 0
        }
      }
    },
    created() {
      this.config = this.configs
      var query = this.createQuery()
      this.fetchData(query)
    },
    methods: {
      createQuery(){
        var query = [];
        query.push(this.config.api+'?summary=1')
        return query.join('')
      },
      searchData(data) {
        var search = [];
        Object.keys(data).forEach(function(key) {
          search.push('&'+key+'='+data[key]);
        });

        var query = this.createQuery()+search.join('')
        this.fetchData(query)
      },
      fetchData(query) {
        var self = this
        axios.get(query)
          .then(({ data }) =>{
            this.total = data
          })
      }
    }
  }
</script>