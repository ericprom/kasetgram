<template>
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img :src="user.avatar" :alt="user.name" v-if="user.avatar" class="img-circle" >
        </div>
        <div class="pull-left info">
          <p v-if="authenticated">{{ user.name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview" v-for="row in menus" :class="{ 'active': $route.name === row.uri }">
          <router-link :to="{ name: row.uri }">
            <i :class="row.icon"></i> 
            <span>{{ row.label }}</span> 
          </router-link>
          <ul v-show="row.hasOwnProperty('children') && typeof row.children.length != 'undefined'" class="treeview-menu">
            <li v-for="child in row.children">
              <router-link :to="{ name: child.uri }">
                <i :class="child.icon"></i> {{ child.label }}
              </router-link>
            </li>
          </ul> 
         
        </li>
      </ul>
    </section>
  </aside>
</template>

<script>
  import axios from 'axios'
  export default {
    name: 'Sidebar',
    data() {
      return {
        menus: []
      }
    },
    computed: {
      user () {
        return Store.getters.authUser
      },
      authenticated () {
        return Store.getters.authCheck
      }
    },
    methods: {
      init () {
        axios.post('/api/v1/datalist/menus')
        .then(({ data }) =>{
          this.menus = data.menus
        })
        Store.dispatch('createDatalist')
      }
    },
    beforeMount(){
      this.init()
    },
  };
</script>