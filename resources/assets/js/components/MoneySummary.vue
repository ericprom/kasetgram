<template>
  <div class="row">
    <div :class="config.calss">
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
    <div :class="config.calss">
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
    <div :class="config.calss">
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
    <div :class="config.calss">
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
      this.searchData(this.config.from, this.config.to)
    },
    methods: {
      searchData(from,to) {
        var self = this
        axios.get(this.config.api+'?form='+from+'&to='+to)
          .then(({ data }) =>{
            this.total = data
          })
      }
    }
  }
</script>