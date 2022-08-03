<template>
  <div>
    <RouterLink :to="`/plants/${item.id}`">
      <figure>
        <img :src="item.url" alt="">
      </figure>
    </RouterLink>
    {{item.id}}
  </div>
</template>

<script>
  export default {
    props: {
      item: {
        type: Object,
        required: true,
      }
    }
  }

</script>
