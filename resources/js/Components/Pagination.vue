<template>
  <nav>
    <ul class="pagination">
      <li v-if="pagination.prev" class="page-item">
        <a @click.prevent="goToPage(pagination.prev)" class="page-link" href="#">Previous</a>
      </li>
      <li v-for="page in pagination.pages" :key="page" :class="{ 'active': page === pagination.current }" class="page-item">
        <a @click.prevent="goToPage(page)" class="page-link" href="#">{{ page }}</a>
      </li>
      <li v-if="pagination.next" class="page-item">
        <a @click.prevent="goToPage(pagination.next)" class="page-link" href="#">Next</a>
      </li>
    </ul>
  </nav>
</template>

<script>
import { usePage } from '@inertiajs/vue3';

export default {
  props: {
    pagination: {
      type: Object,
      required: true,
    },
  },
  methods: {
    goToPage(page) {
      this.$inertia.visit(this.pagination.url + '?page=' + page);
    },
  },
};
</script>

<style>
/* Add your custom styles here */
</style>