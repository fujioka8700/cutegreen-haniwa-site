<template>
  <div v-if="plant">
    Plant Detail
    <img :src="plant.url" alt="">
    <p>{{ plant.owner.name }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      plant: null
    }
  },
  props: {
    id: {
      type: String,
      required: true
    }
  },
  methods: {
    async fetchPlant(){
      const response = await axios.get(`/api/plants/${this.id}`);

      this.plant = response.data;
    }
  },
  watch: {
    $route: {
      handler() {
        this.fetchPlant();
      },
      immediate: true
    }
  }
}
</script>
