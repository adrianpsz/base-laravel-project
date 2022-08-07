<template>
  <div>
    <div v-for="(image,index) in images" :key="index" class="input-group mb-3">
      <input type="file" class="form-control" :id="'file' + index" name="images[]">
      <label class="input-group-text" :for="'file' + index">Upload</label>
    </div>
    <button v-show="this.images < this.max" @click.prevent="newImage()" class="btn btn-outline-info btn-sm">
      <i class="fa-solid fa-plus"></i>
      {{ __('New image') }}
    </button>
  </div>
</template>
<script>
export default {
  name: "UploadImagesComponent",
  props: {
    max: Number,
  },
  data() {
    return {
      images: 0,
    }
  },
  methods: {
    newImage() {
      if(this.images < this.max)
        this.images++;
    }
  }
}
</script>
