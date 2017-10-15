<template>
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="http://www.newsshare.in/wp-content/uploads/2017/04/Miniclip-8-Ball-Pool-Avatar-15.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p v-if="authenticated">{{ user.name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview" v-for="row in menus" :class="{ 'active': $route.name === row.name }">
          <router-link :to="{ name: row.name }">
            <i :class="row.icon"></i> 
            <span>{{ row.title }}</span> 
          </router-link>
          <ul v-show="row.hasOwnProperty('child') && typeof row.child.length != 'undefined'" class="treeview-menu">
            <li v-for="child in row.child">
              <router-link :to="{ name: child.name }">
                <i :class="child.icon"></i> {{ child.title }}
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
        menus: Store.getters.authMenus
      };
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
      createMenus () {
        axios.post('/api/v1/auth/menus')
          .then(({ data }) => { 
            Store.dispatch('saveMenus', data.menus)
          })
          .catch(({ data }) =>{
            console.log(data)
          })
      }
    },
    beforeMount(){
      this.createMenus()
    },
  };
</script>