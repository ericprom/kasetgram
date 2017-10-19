import Vue from 'vue'

const requireContext = require.context('./modules', false, /.*\.js$/)

const modules = requireContext.keys()
  .map(file =>
    [file.replace(/(^.\/)|(\.js$)/g, ''), requireContext(file)]
  )
  .reduce((modules, [name, module]) => {
    modules[name] = module
    return modules
  }, {})
  
Object.keys(modules).forEach(function(key) {
  Vue.mixin(modules[key]['default'])
});
