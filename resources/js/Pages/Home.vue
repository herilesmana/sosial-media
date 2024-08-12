<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Home</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <h3 class="mb-3 text-xl">Create A Post</h3>
                    <div class="post-form">
                        <form @submit.prevent="createPost" class="flex flex-col space-y-4" enctype="multipart/form-data">
                            <textarea
                                v-model="content"
                                class="w-full p-3 border border-gray-300 rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="What's on your mind?"
                                rows="4"
                            ></textarea>
                            
                            <input
                                type="file"
                                @change="handleFileUpload"
                                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />
                            
                            <div>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                                Post
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <h3 class="mb-3 text-xl">All Posts</h3>
                    <div class="post-list">
                        <div v-for="post in posts" :key="post.id" class="post mb-6 p-4 border rounded-lg shadow-sm">
                        <div class="post-header mb-2">
                            <h2 class="font-bold text-lg">{{ post.user.name }}</h2>
                            <p class="text-sm text-gray-500">{{ formatDate(post.created_at) }}</p>
                        </div>
                        <div class="post-content mb-2">
                            <p v-if="post.content">{{ post.content }}</p>
                            <a v-if="post.attachment" :href="getAttachmentUrl(post.attachment)" target="_blank" class="text-blue-500 hover:underline">
                            View Attachment
                            </a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
  data() {
    return {
      content: '',
      attachment: null,
      posts: []
    };
  },
  methods: {
    handleFileUpload(event) {
      this.attachment = event.target.files[0];
    },
    async createPost() {
      if (!this.content.trim() && !this.attachment) {
        alert('Post content or attachment is required.');
        return;
      }

      const formData = new FormData();
      formData.append('content', this.content);
      if (this.attachment) {
        formData.append('attachment', this.attachment);
      }

      try {
        await axios.post('posts', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });
        this.content = '';
        this.attachment = null;
        this.$emit('postCreated');
      } catch (error) {
        console.error('There was an error creating the post:', error);
      }
    },
    async fetchPosts() {
      try {
        const response = await axios.get('posts');
        this.posts = response.data;
      } catch (error) {
        console.error('Error fetching posts:', error);
      }
    },
    formatDate(date) {
      return new Date(date).toLocaleString();
    },
    getAttachmentUrl(path) {
      return `/storage/${path}`;
    }
  },
  created() {
    this.fetchPosts();
  }
};
</script>
