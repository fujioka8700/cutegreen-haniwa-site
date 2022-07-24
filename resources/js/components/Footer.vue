<template>
  <footer class="footer">
    <button class="button button--link" @click="logout" v-if="isLogin">Logout</button>
    <RouterLink
      class="button button--link"
      :class="{ 'footer__routerlink' : isLogin }"
      to="/login"
    >
      Login / Register
    </RouterLink>
  </footer>
</template>

<script>
import { mapGetters, mapState } from 'vuex';

export default {
  computed: {
    ...mapState({
      apiStatus: state => state.auth.apiStatus
    }),
    ...mapGetters({
      isLogin: 'auth/check'
    })
  },
  methods: {
    async logout() {
      await this.$store.dispatch('auth/logout');

      if(this.apiStatus) {
        this.$router.push('/login');
      }
    }
  }
}
</script>

<style scoped>
.footer__routerlink {
  text-decoration: none;
  color: #8a8a8a;
  pointer-events: none;
}
</style>
