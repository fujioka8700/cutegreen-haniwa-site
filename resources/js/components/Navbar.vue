<template>
  <header>
    <nav class="navbar nav__inner--offset">
      <div v-if="isLogin" class="nav__overray">
        <PictureForm v-model="showForm" />
      </div>
      <RouterLink class="navbar__brand nav__brand" to="/">
        CuteGreen
      </RouterLink>
      <div class="navbar__menu">
        <div class="navbar__item" v-if="isLogin">
          <button class="button" @click="showForm = !showForm">
            <i class="icon ion-md-add"></i>
            Submit a photo
          </button>
        </div>
      </div>
      <div class="navbar__item" v-if="!isLogin">
        <RouterLink class="button button--link" to="/login">
          Login / Register
        </RouterLink>
      </div>
      <div class="d-flex align-items-center" v-if="isLogin">
        <span class="navbar__item" v-if="isLogin">
          <nobr>
            {{ username }}
          </nobr>
        </span>
        <button class="ml-1 button button--link" @click="logout">Logout</button>
      </div>
    </nav>
  </header>
</template>

<script>
  import {
    mapGetters
  } from 'vuex';
  import PictureForm from './PictureForm';

  export default {
    components: {
      PictureForm
    },
    data() {
      return {
        showForm: false
      }
    },
    computed: {
      ...mapGetters({
        isLogin: 'auth/check'
      }),
      username() {
        return this.$store.getters['auth/username'];
      }
    },
    methods: {
      async logout() {
        await this.$store.dispatch('auth/logout');

        if (this.apiStatus) {
          this.$router.push('/login');
        }
      }
    }
  }

</script>
