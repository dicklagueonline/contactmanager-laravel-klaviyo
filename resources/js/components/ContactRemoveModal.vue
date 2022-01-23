<template>
  <div class="modal fade" tabindex="-1" aria-hidden="true" ref="modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Remove Contact</h5>
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
        <div class="modal-body">
          <p>Are you sure to remove the selected contact?</p>
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
            @click.prevent="removeContact"
          >
            Remove Contact
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
    contactId: {
      type: Number | String,
      required: true,
    },
  },
  data() {
    return {
      modalElem: null,
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
      this.$emit("input", false);
    },
    removeContact: function () {
      axios({
        method: "delete",
        url: `/user/contact/${this.contactId}`,
        headers: {
          Accept: "application/vnd.api+json",
        },
        responseType: "json",
      })
        .then((xhr) => {
          this.$emit("contact:deleted", xhr.data.data);
          this.$emit("input", false);
        })
        .catch((err) => {
          this.errors = err.response.data.errors;

          console.log(this.errors);
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
