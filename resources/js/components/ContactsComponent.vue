<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="row mb-2">
          <a
            href="#"
            class="btn btn-primary mr-2"
            @click.prevent="createContact"
            >New Contact</a
          >
          <a href="#" class="btn btn-secondary" @click.prevent="importContact"
            >Import Contact</a
          >
        </div>
        <div class="row">
          <div
            class="col-lg-3 col-md-4 col-sm-6 col-xs-12 p-1"
            v-for="(contact, index) in contacts"
            :key="index"
          >
            <contact-card
              :contact-data="contact"
              @editContact="editContact"
              @removeContact="removeContact"
            ></contact-card>
          </div>
        </div>
        <div class="row justify-content-center mt-2">
          <pagination
            :max-visible-buttons="5"
            :pagination="pagination"
            @onPageChanged="paginate"
          ></pagination>
        </div>
      </div>
    </div>

    <contact-update-modal
      v-model="edit_contact"
      :contact-data="contact"
      @contact:updated="updateContactCard"
    ></contact-update-modal>

    <contact-create-modal
      v-model="create_contact"
      :user-id="userDataId"
      @contact:created="reloadContactList"
    ></contact-create-modal>

    <contact-remove-modal
      v-model="delete_contact"
      :contact-id="contact_id"
      @contact:deleted="removeContactCard"
    ></contact-remove-modal>

    <contact-import-modal
      v-model="import_contact"
      :user-id="userDataId"
      @contact:imported="reloadContactList"
    ></contact-import-modal>
  </div>
</template>

<script>
import Pagination from "./Pagination.vue";
import ContactCard from "./ContactCard.vue";
import ContactUpdateModal from "./ContactUpdateModal.vue";
import ContactCreateModal from "./ContactCreateModal.vue";
import ContactRemoveModal from "./ContactRemoveModal.vue";
import ContactImportModal from "./ContactImportModal.vue";

export default {
  components: {
    Pagination,
    ContactCard,
    ContactUpdateModal,
    ContactCreateModal,
    ContactRemoveModal,
    ContactImportModal,
  },
  props: {
    userDataId: {
      type: Number | String,
      required: true,
    },
  },
  data() {
    return {
      contacts: [],
      contact: {},
      contact_id: null,
      pagination: {},
      edit_contact: false,
      create_contact: false,
      delete_contact: false,
      import_contact: false,
    };
  },
  methods: {
    fetchContacts: function (url) {
      url = url || `/user/contact/lists`;

      axios
        .get(url)
        .then((xhr) => {
          this.contacts = xhr.data.data;
          this.pagination = {
            total_pages: xhr.data.meta.last_page,
            current_page: xhr.data.meta.current_page,
            base_url: xhr.data.meta.path,
          };
        })
        .catch((err) => console.log(err));
    },
    paginate: function (url) {
      this.fetchContacts(url.url);
    },
    editContact: function (contact) {
      this.contact = contact;
      this.edit_contact = true;
    },
    createContact: function () {
      this.create_contact = true;
    },
    removeContact: function (contact) {
      this.contact_id = contact.id;
      this.delete_contact = true;
    },
    importContact: function () {
      this.import_contact = true;
    },
    updateContactCard: function (contact) {
      let index = this.contacts.findIndex((item) => item.id === contact.id);

      if (index > 0) {
        this.contacts[index] = contact;
      }
    },
    reloadContactList: function () {
      this.fetchContacts(
        this.pagination.base_url + "?page=" + this.pagination.current_page
      );
    },
    removeContactCard: function (contact) {
      this.contact_id = null;
      this.fetchContacts(
        this.pagination.base_url + "?page=" + this.pagination.current_page
      );
    },
  },
  created() {
    this.fetchContacts();
  },
};
</script>
