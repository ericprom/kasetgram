<template>
  <canvas ref="chart" :width="width" :height="height"></canvas>
</template>

<script>
import Chart from 'chart.js'
export default {
  name: 'vue-chart',
  props: {
    config: Object,
    width: Number,
    height: Number
  },
  data(){
    return {
      chart: ''
    }
  },
  watch: {
    'data.labels' () {
      this.chart.update()
    },
    'data.datasets' () {
      this.chart.update()
    }
  },
  methods: {
    createChart () {
      this.chart = new Chart(this.$refs.chart, {
        type: this.config.type,
        data: this.config.data,
        options: this.config.options
      })
    },
    update () {
      this.chart.update()
    }
  },
  mounted () {
    this.createChart()
  },
  beforeDestroy () {
    this.chart.destroy()
  }
}
</script>