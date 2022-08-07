<template>
  <div>
    <div v-if="isActive === 1">
      <i class="fa-solid fa-check text-success"></i> <br>
      <button @click.prevent="toggle()" class="btn btn-danger btn-sm">
        {{ __('Deactivate') }}
      </button>
    </div>
    <div v-else>
      <i class="fa-solid fa-xmark text-danger"></i> <br>
      <button @click.prevent="toggle()" class="btn btn-success btn-sm">
        {{ __('Activate') }}
      </button>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    url: String,
    active: Number,
    id: String,
  },
  data() {
    return {
      isActive: this.active,
    }
  },
  methods: {
    async toggle() {
      try {
        const response = await axios.put(this.url + '/' + this.id);
        this.isActive = response.data.active;
      } catch (e) {
        console.log(e)
      }
    },
  }
}
</script>
