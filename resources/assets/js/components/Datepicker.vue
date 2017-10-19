	
<template>
    <div class='input-group date'>
	    <input type="text"
	     class="form-control input"
	     :class="inputClass"
	     :id="id"
	     :name="name"
	     :placeholder="placeholder"
	     :required="required"
	     :read-only="readOnly"
	     :disabled="disabled">
	    <span class="input-group-addon">
	      <span class="fa fa-calendar"></span>
	    </span>
    </div>
</template>
 
<script>
import moment from 'moment'
import 'eonasdan-bootstrap-datetimepicker'
const events = ['hide', 'show', 'change', 'error', 'update'];
export default {
  name: 'datepicker',
  props: {
    value: {
      default: null,
      required: true,
      validator(value) {
        return value === null || value instanceof Date || typeof value === 'string' || value instanceof String || value instanceof moment
      }
    },
    config: {
      type: Object,
      default: () => ({})
    },
    placeholder: {
      type: String,
      default: ''
    },
    inputClass: {
      type: [String, Object],
      default: ''
    },
    name: {
      type: String,
      default: 'datetime'
    },
    required: {
      type: Boolean,
      default: false
    },
    readOnly: {
      type: Boolean,
      default: false
    },
    disabled: {
      type: Boolean,
      default: false
    },
    wrap: {
      type: Boolean,
      default: false
    },
    id: {
      type: String
    },
  },
  data() {
    return {
      dp: null,
      elem: null
    };
  },
  mounted() {
    if (this.dp) return;
    let node = this.wrap ? this.$el.parentNode : this.$el;
    this.elem = jQuery(node);
    this.elem.datetimepicker(this.config);
    this.dp = this.elem.data('DateTimePicker');
    this.dp.date(this.value);
    this.elem.on('dp.change', this.onChange);
    this.registerEvents();
  },
  beforeDestroy() {
    if (this.dp) {
      this.dp.destroy();
      this.dp = null;
      this.elem = null;
    }
  },
  watch: {
    value(newValue) {
      this.dp && this.dp.date(newValue || null)
    },
    config(newConfig) {
      this.dp && this.dp.options(Object.assign(this.dp.options(), newConfig));
    }
  },
  methods: {
    onChange(event) {
      this.$emit('input', event.date || null);
    },
    registerEvents() {
      events.forEach((name) => {
        this.elem.on('dp.' + name, (...args) => {
          this.$emit('dp-' + name, ...args);
        });
      })
    }
  }
}
</script>
<style scoped>
 
</style>