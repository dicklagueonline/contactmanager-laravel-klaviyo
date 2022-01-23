<template>
  <div class="modal fade" tabindex="-1" aria-hidden="true" ref="modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Contact</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
            @click.prevent="closeModal"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body px-4">
          <form>
            <div class="form-group">
              <label>Name</label>
              <input
                v-model="name"
                type="text"
                class="form-control"
                placeholder="Contact's name"
                v-bind:class="{ 'is-invalid': !!errors && !!errors.firstname }"
              />
              <div
                class="invalid-feedback"
                v-if="!!errors && !!errors.firstname"
              >
                <strong
                  v-for="(error, index) in errors.firstname"
                  :key="index"
                  >{{ error }}</strong
                >
              </div>
            </div>
            <div class="form-group">
              <label>Email Address</label>
              <input
                v-model="email"
                type="email"
                class="form-control"
                placeholder="Contact's email address"
                v-bind:class="{ 'is-invalid': !!errors && !!errors.email }"
              />
              <div class="invalid-feedback" v-if="!!errors && !!errors.email">
                <strong v-for="(error, index) in errors.email" :key="index">{{
                  error
                }}</strong>
              </div>
            </div>
            <div class="form-group">
              <label>Phone Number</label>
              <input
                v-model="phone"
                type="tel"
                class="form-control"
                placeholder="Contact's phone or mobile number"
                v-bind:class="{ 'is-invalid': !!errors && !!errors.phone }"
              />
              <div class="invalid-feedback" v-if="!!errors && !!errors.phone">
                <strong v-for="(error, index) in errors.phone" :key="index">{{
                  error
                }}</strong>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-dismiss="modal"
            @click.prevent="closeModal"
          >
            Close
          </button>
          <button
            type="button"
            class="btn btn-primary"
            @click.prevent="SaveContact"
          >
            Save Contact
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    value: false,
    userId: {
      type: Number | String,
      required: true,
    },
  },
  data() {
    return {
      modalElem: null,

      name: null,
      email: null,
      phone: null,

      errors: {},
    };
  },
  watch: {
    value(a) {
      if (a) {
        $(this.modalElem).modal("show");
      } else {
        $(this.modalElem).modal("hide");
      }
    },
  },
  methods: {
    closeModal: function () {
      this.errors = {};
      this.name = null;
      this.email = null;
      this.phone = null;
      this.$emit("input", false);
    },
    SaveContact: function () {
      var data = new FormData();

      data.append("firstname", this.name);
      data.append("email", this.email);
      data.append("phone", this.phone);

      axios({
        method: "post",
        url: `/user/contact`,
        headers: {
          "Contentt-Type": "multipart/form-data",
          Accept: "application/vnd.api+json",
        },
        data: data,
        responseType: "json",
      })
        .then((xhr) => {
          this.$emit("contact:created", xhr.data.data);
          this.$emit("input", false);
        })
        .catch((err) => {
          this.errors = err.response.data.errors;
        });
    },
  },
  mounted() {
    this.modalElem = this.$refs.modal;

    $(this.modalElem).on("hidden.bs.modal", () => {
      this.closeModal();
    });
  },
};
</script>
