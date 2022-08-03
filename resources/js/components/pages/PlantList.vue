<template>
  <div>
    Plant List
    <Plant
      v-for="plant in plants"
      :key="plant.id"
      :item="plant"
    />
  </div>
</template>

<script>
import Plant from '../Plant';

export default {
  components: {
    Plant
  },
  props: {
    page: {
      type: Number,
      required: false,
      default: 1,
    }
  },
  data() {
    return {
      plants: [],
      currentpage: 0,
      lastpage: 0,
    }
  },
  methods: {
    async fetchPicture() {
      const response = await axios.get(`/api/plants?page=${this.page}`);

      this.plants = response.data.data;
      this.currentpage = response.data.current_page;
      this.lastpage = response.data.last_page;
    }
  },
  watch: {
    $route: {
      handler() {
        this.fetchPicture();
      },
      immediate: true
    }
  }
}
</script>
