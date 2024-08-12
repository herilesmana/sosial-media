<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';

const content = ref('');
const attachment = ref(null);
const posts = ref([]);
const commentContent = ref('');
const user = usePage().props.auth.user;

const handleFileUpload = (event) => {
  attachment.value = event.target.files[0];
};

const createPost = async () => {
  if (!content.value.trim() && !attachment.value) {
    alert('Post content or attachment is required.');
    return;
  }

  const formData = new FormData();
  formData.append('content', content.value);
  if (attachment.value) {
    formData.append('attachment', attachment.value);
  }

  try {
    await axios.post('/posts', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });
    content.value = '';
    attachment.value = null;
    fetchPosts(); // Refresh posts after creating a new one
  } catch (error) {
    console.error('There was an error creating the post:', error);
  }
};

const fetchPosts = async () => {
  try {
    const response = await axios.get('/posts');
    posts.value = response.data;
  } catch (error) {
    console.error('Error fetching posts:', error);
  }
};

const createComment = async (postId) => {
  if (!commentContent.value.trim()) {
    alert('Comment content cannot be empty.');
    return;
  }

  try {
    await axios.post('/comments', {
      post_id: postId,
      content: commentContent.value,
    });
    commentContent.value = '';
    fetchPosts(); // Refresh posts to show the new comment
  } catch (error) {
    console.error('There was an error posting the comment:', error);
  }
};

const formatDate = (date) => {
  return new Date(date).toLocaleString();
};

const getAttachmentUrl = (path) => {
  return `/storage/${path}`;
};

onMounted(() => {
  fetchPosts();
});
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
                <a
                  v-if="post.attachment"
                  :href="getAttachmentUrl(post.attachment)"
                  target="_blank"
                  class="text-blue-500 hover:underline"
                >
                  View Attachment
                </a>
              </div>

              <!-- Comments section -->
              <hr />
              <div class="post-comments mt-3">
                <div class="comment" v-for="comment in post.comments" :key="comment.id">
                  <p class="text-sm"><strong>{{ comment.user.name }}:</strong> {{ comment.content }}</p>
                  <p class="text-xs text-gray-500">{{ formatDate(comment.created_at) }}</p>
                </div>

                <div v-if="user" class="comment-form mt-3">
                  <form @submit.prevent="createComment(post.id)" class="flex flex-col space-y-4">
                    <textarea
                      v-model="commentContent"
                      class="w-full p-3 border border-gray-300 rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"
                      placeholder="Write a comment..."
                      rows="2"
                    ></textarea>

                    <div>
                      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        Comment
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
