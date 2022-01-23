<template>
  <div class="card shadow">
    <div class="card-body p-3">
      <div class="media">
        <div class="media-body">
          <h6 class="mb-0 text-dark font-weight-bold">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="16"
              height="16"
              fill="currentColor"
              class="bi bi-person-circle"
              viewBox="0 0 16 16"
            >
              <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
              <path
                fill-rule="evenodd"
                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"
              />
            </svg>
            <span class="ml-2">{{ contactName }}</span>
          </h6>
          <ul class="list-unstyled text-smoke text-smoke">
            <li class="d-flex flex-row">
              <div class="align-bottom">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-envelope"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"
                  />
                </svg>
              </div>
              <div class="px-2 align-top align-self-center">
                {{ contactEmail }}
              </div>
            </li>
            <li class="d-flex flex-row">
              <div class="align-bottom">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-telephone"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"
                  />
                </svg>
              </div>
              <div class="px-2 align-top align-self-center">
                {{ contactPhone }}
              </div>
            </li>
          </ul>
        </div>
      </div>

      <a href="#" class="card-link" @click.prevent="editContact">Update</a>
      <a href="#" class="card-link" @click.prevent="removeContact">Remove</a>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    contactData: {
      type: Object,
      required: true,
      default: () => {
        return {
          id: null,
          name: null,
          email: null,
          phone: null,
        };
      },
    },
  },
  computed: {
    contactId() {
      return this.contactData.id;
    },
    contactName() {
      return this.contactData.name;
    },
    contactEmail() {
      return this.contactData.email;
    },
    contactPhone() {
      return this.contactData.phone;
    },
  },
  methods: {
    editContact: function () {
      this.$emit("editContact", this.contactData);
    },
    removeContact: function () {
      this.$emit("removeContact", this.contactData);
    },
  },
};
</script>
