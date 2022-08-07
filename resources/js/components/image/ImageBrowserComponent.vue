<template>
  <div>
    <div v-if="images.length > 0" class="image-browser">
      <img class="img-fluid" :src="currentImageSrc" :alt="currentImageAlt" />
      <div v-if="showPrevButton" @click.prevent="prevImage()" class="ib-button ib-button-prev">
        <i class="fa-solid fa-chevron-left"></i>
      </div>
      <div v-if="showNextButton" @click.prevent="nextImage()" class="ib-button ib-button-next">
        <i class="fa-solid fa-chevron-right"></i>
      </div>
    </div>
    <div v-else>
      {{ __('No images') }}
    </div>
  </div>
</template>
<script>
export default {
  name: "ImageBrowserComponent",
  props: {
    images: Array,
    url: String,
  },
  data() {
    return {
      currenIndex: 0
    }
  },
  computed: {
    currentImageAlt() {
      return this.images[this.currenIndex].filename;
    },
    currentImageSrc() {
      return this.url + '/' + this.images[this.currenIndex].filename;
    },
    showPrevButton() {
      return this.images.length > 1 && this.currenIndex > 0;
    },
    showNextButton() {
      return this.images.length > 1 && this.currenIndex < this.images.length - 1;
    }
  },
  methods: {
    prevImage() {
      this.currenIndex--;
      if(this.currenIndex < 0)
        this.currenIndex = 0;
    },
    nextImage() {
      if(this.currenIndex < this.images.length - 1) {
        this.currenIndex++;
      }
    }
  }
}
</script>
