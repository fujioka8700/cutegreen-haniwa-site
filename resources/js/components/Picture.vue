<template>
  <div class="photo">
    <figure class="photo__wrapper">
      <img
        class="photo__image"
        :src="item.url"
        :alt="`Picture by ${item.owner.name}`"
      >
    </figure>
    <RouterLink
      class="photo__overlay"
      :to="`/pictures/${item.id}`"
      :title="`View the picture by ${item.owner.name}`"
    >
      <div class="photo__controls">
        <button
          class="photo__action photo__action--like"
          :class="{ 'photo__action--liked' : item.liked_by_user }"
          title="Like Picture"
          @click.prevent="like"
        >
          <i class="icon ion-md-heart"></i>{{ item.likes_count }}
        </button>
        <a
          class="photo__action"
          title="Download Picture"
          :href="`/pictures/${item.id}/download`"
          @click.stop
        >
          <i class="icon ion-md-arrow-round-down"></i>
        </a>
      </div>
      <div class="photo__username">
        {{ item.owner.name }}
      </div>
    </RouterLink>
  </div>
</template>

<script>
export default {
  props: {
    item: {
      type: Object,
      required: true
    }
  },
  methods: {
    like() {
      this.$emit('like', {
        id: this.item.id,
        liked: this.item.liked_by_user
      });
    }
  }
}
</script>

<style scoped>
figure {
  margin: 0;
}
.photo__username {
  color: white;
  text-decoration: none;
}
a:hover {
  text-decoration: none;
}
</style>
