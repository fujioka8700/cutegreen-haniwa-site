<template>
  <div>
    <h2>Plant Form</h2>
    <form @submit.prevent="submit">
      <div class="form-group">
        <label for="exampleFormControlFile1">Example file input</label>
        <input type="file" class="form-control-file" id="exampleFormControlFile1" @change="onFilechange">
      </div>
      <div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        plant: null
      }
    },
    methods: {
      onFilechange(event) {
        this.plant = event.target.files[0];
      },
      async submit() {
        const formData = new FormData();
        formData.append('plant', this.plant);
        const response = await axios.post('/api/plants', formData);
      }
    }
  }

</script>
