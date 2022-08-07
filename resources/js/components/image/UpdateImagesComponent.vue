<template>
  <div class="row update-images mb-3">
    <div v-for="(image,index) in images" :key="index" class="col-6 col-lg-4 mb-2">
      <div class="ui-wrapper">
        <img class="img-fluid" :src="imageUrl + '/' + image.filename" :alt="image.filename" />
        <div v-if="!isLoading" class="ui-toolbar">
          <a v-show="index !== 0" href="#" @click.prevent="moveUp(index)"
             class="ui-b ui-b-move ui-b-m-left">
            <i class="fa-solid fa-chevron-left"></i>
          </a>
          <a href="#" @click.prevent="removeImage(image.id)" class="ui-b ui-b-remove">
            <i class="fa-solid fa-trash-can"></i>
          </a>
          <a v-show="index < images.length -1" href="#" @click.prevent="moveDown(index)"
             class="ui-b ui-b-move ui-b-m-right">
            <i class="fa-solid fa-chevron-right"></i>
          </a>
        </div>
        <div v-else class="ui-toolbar ui-loading">
          <i class="fas fa-spinner fa-spin"></i>
        </div>
      </div>
    </div>
    <upload-images :max="maxImages"></upload-images>
  </div>
</template>
<script>
export default {
  name: "UpdateImagesComponent",
  props: {
    models: Array,
    deleteUrl: String,
    imageUrl: String,
    reorderUrl: String,
    max: Number,
  },
  data() {
    return {
      images: this.models,
      isLoading: false,
      msg: '',
      maxImages: this.max,
    }
  },
  methods: {
    async removeImage(id) {
      try {
        this.isLoading = true;
        const response = await axios.delete(this.deleteUrl + '/' + id);
        this.images = response.data.images;
        this.isLoading = false;
        this.maxImages++;
      } catch (e) {
        this.isLoading = false;
      }
    },
    async moveUp(index) {
      try {
        this.isLoading = true;
        const response = await axios.put(this.reorderUrl + '/' + this.images[index].id + '/' + this.images[index - 1].id);
        this.images = response.data.images;
        this.isLoading = false;
      } catch (e) {
        this.isLoading = false;
      }
    },
    async moveDown(index) {
      try {
        this.isLoading = true;
        const response = await axios.put(this.reorderUrl + '/' + this.images[index].id + '/' + this.images[index + 1].id);
        this.images = response.data.images;
        this.isLoading = false;
      } catch (e) {
        this.isLoading = false;
      }
    }
  }
}
</script>
