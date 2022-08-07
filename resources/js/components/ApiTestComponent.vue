<template>
  <span>{{ __('Api response') }} (Vue): {{ msg }}</span>
</template>

<script>
export default {
  name: "ApiTestComponent",
  props: {
    url: String,
  },
  async mounted() {
    let response = await axios.post(this.url, {}, {
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      }
    });
    this.msg = response.data.api;
  },
  data() {
    return {
      msg: '---',
    }
  }
}
</script>
