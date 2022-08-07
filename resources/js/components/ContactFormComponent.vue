<template>
  <section id="contact-form">
    <div class="row">
      <div class="col-12">
        <h3>{{ __("Send a message") }}</h3>
        <span class="marker line"></span>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <p>{{ __("If you have questions or suggestions please contact me via the following form.") }}</p>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div v-show="infoFlag === 1" class="alert alert-success my-2">
          {{ __("The message has been sent properly.") }}
        </div>
        <div v-show="infoFlag === 2" class="alert alert-danger my-2">
          {{ __("An error has occurred. Please try again later.") }}
        </div>
      </div>
    </div>
    <form method="post">
      <div class="row mb-3">
        <div class="col-12">
          <label for="name" class="small">{{ __("Name and Surname") }}:</label>
          <br>
          <input id="name" name="name" type="text" class="form-control"
                 :disabled="isLoading" v-model="fields.name"
                 :placeholder="__('Name and Surname')" required>
          <span class="small text-danger">{{ fieldError.name }}</span>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-12">
          <label for="email" class="small">{{ __("Email") }}:</label>
          <br>
          <input id="email" name="email" type="email" class="form-control"
                 :disabled="isLoading" v-model="fields.email"
                 placeholder="email@email.com" required>
          <span class="small text-danger">{{ fieldError.email }}</span>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-12">
          <label for="subject" class="small">{{ __("Title") }}:</label>
          <br>
          <input id="subject" name="subject" type="text" class="form-control"
                 :disabled="isLoading" v-model="fields.subject"
                 :placeholder='__("Title")' required>
          <span class="small text-danger">{{ fieldError.subject }}</span>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-12">
          <label for="message" class="small">{{ __("Message") }}:</label>
          <br>
          <textarea id="message" name="message" class="form-control"
                    :disabled="isLoading" v-model="fields.message"
                    :placeholder="__('Message')" required></textarea>
          <span class="small text-danger">{{ fieldError.message }}</span>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-12">
          <label for="message" class="small">{{ __("Write the correct sum") }}:</label>
          <br>
          <input class="ncaptcha form-control" type="text" v-model="fields.captcha1" disabled>
          +
          <input class="ncaptcha form-control" type="text" v-model="fields.captcha2" disabled>
          =
          <input class="ncaptcha form-control" type="number" step="1" v-model="fields.captchaScore">
          <br>
          <span class="small text-danger">{{ fieldError.captchaScore }}</span>
          <input type="hidden" v-model="fields.href">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-12">
          <button class="btn btn-primary w-100 mt-3" @click.prevent="submitForm" :disabled="isLoading">
            <i v-show="isLoading" class="fas fa-spinner fa-pulse color-white"></i>
            {{ __("Send a message") }}
          </button>
        </div>
      </div>
    </form>
  </section>
</template>
<script>
export default {
  name: "ContactFormComponent",
  props: {
    url: String,
    name: {
      type: String,
      default: '',
    },
    email: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      isLoading: false,
      fields: {
        name: this.name,
        email: this.email,
        subject: '',
        message: '',
        captcha1: Math.floor(Math.random() * 10),
        captcha2: Math.floor(Math.random() * 10),
        captchaScore: '',
        href: window.location.href
      },
      fieldError: {
        name: '',
        email: '',
        subject: '',
        message: '',
        captchaScore: ''
      },
      infoFlag: 0
    }
  },
  methods: {
    submitForm(event) {
      event.preventDefault();
      this.isLoading = true;
      if(this.validateForm()) {
        this.infoFlag = 0;
        axios.post(this.url, {
          'name': this.fields.name,
          'email': this.fields.email,
          'subject': this.fields.subject,
          'message': this.fields.message,
          'href': this.fields.href
        })
            .then(res => {
              if(res.status === 200) {
                this.infoFlag = 1;
                this.resetForm();
              } else {
                this.infoFlag = 2;
                this.resetForm();
              }
            }).catch(err => {
          //console.log(err);
          this.infoFlag = 2;
          this.resetForm();
        });
      } else {
        this.isLoading = false;
      }
    },
    resetForm() {
      this.isLoading = false;
      this.fields.captcha1 = Math.floor(Math.random() * 10);
      this.fields.captcha2 = Math.floor(Math.random() * 10);
      this.fields.captchaScore = '';
    },
    validateForm() {
      let noError = true;
      // name
      if(!this.fields.name) {
        this.fieldError.name = this.__("The field Name and Surname cannot be empty.");
        noError = false;
      } else if(this.fields.name.length < 3) {
        this.fieldError.name = this.__("Min. 3 signs.");
        noError = false;
      } else if(this.fields.name.length > 255) {
        this.fieldError.name = this.__("Max. 255 signs.");
        noError = false;
      } else
        this.fieldError.name = '';

      // email
      if(!this.fields.email) {
        this.fieldError.email = this.__("The field Email cannot be empty.");
        noError = false;
      } else if(this.fields.email.length < 3) {
        this.fieldError.email = this.__("Min. 3 signs.");
        noError = false;
      } else if(this.fields.email.length > 255) {
        this.fieldError.email = this.__("Max. 255 signs.");
        noError = false;
      } else
        this.fieldError.email = '';

      // subject
      if(!this.fields.subject) {
        this.fieldError.subject = this.__("The filed Title cannot be empty.");
        noError = false;
      } else if(this.fields.subject.length < 3) {
        this.fieldError.subject = this.__("Min. 3 signs.");
        noError = false;
      } else if(this.fields.subject.length > 255) {
        this.fieldError.subject = this.__("Max. 255 signs.");
        noError = false;
      } else
        this.fieldError.subject = '';

      // message
      if(!this.fields.message) {
        this.fieldError.message = this.__("The field Message cannot be empty.");
        noError = false;
      } else if(this.fields.message.length < 3) {
        this.fieldError.message = this.__("Min. 3 signs.");
        noError = false;
      } else if(this.fields.message.length > 255) {
        this.fieldError.message = this.__("Max. 255 signs.");
        noError = false;
      } else
        this.fieldError.message = '';

      // captchaScore
      if(!this.fields.captchaScore) {
        this.fieldError.captchaScore = this.__("The field Result cannot be empty.");
        noError = false;
      } else if(parseInt(this.fields.captcha1) + parseInt(this.fields.captcha2) !== parseInt(this.fields.captchaScore)) {
        this.fieldError.captchaScore = this.__("The sum is not correct!");
        noError = false;
      } else
        this.fieldError.captchaScore = '';

      return noError;
    }
  }
}
</script>
<style lang="scss">

</style>
