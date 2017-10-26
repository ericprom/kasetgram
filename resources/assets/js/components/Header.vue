<template>
  <header class="main-header">
    <a class="logo">
      <span class="logo-mini">{{companyAbbr}}</span>
      <span class="logo-lg"><b>{{companyName}}</b></span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu" v-if="authenticated">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img :src="user.avatar" :alt="user.name" v-if="user.avatar" class="user-image">
              <span class="hidden-xs">{{ user.name }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img :src="user.avatar" :alt="user.name" v-if="user.avatar" class="img-circle">

                <p>
                  {{ user.name }}
                  <small>Smart Farmer</small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <router-link :to="{ name: 'account' }" class="btn btn-default btn-flat">
                  โปรไฟล์
                  </router-link>
                </div>
                <div class="pull-right">
                  <a @click.prevent="logout" class="btn btn-default btn-flat">ออกจากระบบ</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
</template>

<script>
  export default {
    name: 'Header',
    data(){
      return {
        companyName: 'Smart Farmer',
        companyAbbr: 'SF',
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
      logout () {
        Store.dispatch('logout')
        this.$router.push({ name: 'welcome' })
      }
    }
  };
</script>