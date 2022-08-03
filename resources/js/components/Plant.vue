<template>
  <div>
    <figure>
      <img :src="item.url" alt="">
    </figure>
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
