<template>
  <nav aria-label="Page navigation example">
    <ul class="pagination">
      <li v-bind:class="{ disabled: !prevPageUrl }" class="page-item">
        <a
          class="page-link"
          href="#"
          aria-label="Previous"
          @click.prevent="paginate(prevPageUrl)"
        >
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <li
        class="page-item"
        v-for="(page, index) in numberPageLinks"
        :key="index"
        v-bind:class="[
          { active: page.page === pagination.current_page },
          { disabled: !page.page },
        ]"
      >
        <span v-if="!page.page" class="page-link">...</span>
        <a
          v-else
          class="page-link"
          href="#"
          @click.prevent="paginate(pagination.base_url + '?page=' + page.page)"
          >{{ page.page }}</a
        >
      </li>
      <li v-bind:class="{ disabled: !nextPageUrl }" class="page-item">
        <a
          class="page-link"
          href="#"
          aria-label="Next"
          @click.prevent="paginate(nextPageUrl)"
        >
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
import { numberLinks } from "../utils/pagination";

export default {
  props: {
    maxVisibleButtons: {
      type: Number,
      required: false,
      default: 5,
    },
    pagination: {
      type: Object,
      required: true,
      default: () => {
        return {
          total_pages: 1,
          current_page: 1,
          base_url: null,
        };
      },
    },
  },
  computed: {
    firstPageUrl() {
      return this.pagination.base_url + "?page=1";
    },
    lastPageUrl() {
      return this.pagination.base_url + "?page=" + this.pagination.total_pages;
    },
    nextPageUrl() {
      if (this.pagination.current_page === this.pagination.total_pages) {
        return null;
      }

      return (
        this.pagination.base_url + "?page=" + (this.pagination.current_page + 1)
      );
    },
    prevPageUrl() {
      if (this.pagination.current_page === 1) {
        return null;
      }

      return (
        this.pagination.base_url + "?page=" + (this.pagination.current_page - 1)
      );
    },
    numberPageLinks() {
      return numberLinks(
        this.pagination.current_page,
        this.pagination.total_pages,
        this.maxVisibleButtons
      );
    },
  },
  methods: {
    paginate: function (url) {
      this.$emit("onPageChanged", { url: url });
    },
  },
};
</script>
