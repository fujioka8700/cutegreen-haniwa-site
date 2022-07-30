<template>
  <footer class="footer">
    <small>Copyright (c) CuteGreen All Rights Reserved.</small>
  </footer>
</template>

<script>
  import {
    mapState
  } from 'vuex';

  export default {
    computed: {
      ...mapState({
        apiStatus: state => state.auth.apiStatus
      }),
    },
  }

</script>
