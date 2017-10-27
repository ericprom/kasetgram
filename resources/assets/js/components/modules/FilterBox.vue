<template>
  <div class="box box-primary">
    <div class="box-body">
      <div class="row">
        <div class="col-sm-4">
          <select v-model="timer" class="form-control" @change="selectedTime(timer)">
            <option v-for="timer in timers" :value="timer">
              {{ timer.name }}  
            </option>
          </select>
        </div>
        <div class="col-sm-3">
          <datepicker v-model="start" :configs="datepicker" @dp-change.prevent="updateFilter"></datepicker>
        </div>
        <div class="col-sm-3">
          <datepicker v-model="end" :configs="datepicker" @dp-change.prevent="updateFilter"></datepicker>
        </div>
        <div class="col-sm-2">
          <button type="button" class="btn btn-primary btn-block" @click.prevent="searchItem">
            <i class="fa fa-filter"></i> Filter
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import moment from 'moment'
  export default {
    name: 'filter-box',
    data() {
      return {
        datepicker: {
          format: 'DD/MM/YYYY',
          useCurrent: false,
        },
        timers: Store.getters.timers,
        timer: Store.getters.timers[2],
        start: moment().format('DD/MM/YYYY'),
        end: moment().format('DD/MM/YYYY'),
        filter:{
          from: '',
          to: '',
        },
      }
    },
    methods: {
      selectedTime(val) {
        this.timer = val
        this.changeTime()
      },
      changeTime() {
        if(this.timer.id !== 'custom') {
          var select = this.dateFilter(this.timer.id)
          this.start = select.start
          this.end = select.end
        }
      },
      updateFilter () {
        this.changeTime()
      }, 
      searchItem (){
        this.filter.from = this.saveDate(this.start)
        this.filter.to = this.saveDate(this.end)
        this.$emit('filter', this.filter)
      },
    }
  }
</script>