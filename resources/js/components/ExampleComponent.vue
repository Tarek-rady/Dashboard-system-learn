<template>
  <div class="p-4 bg-white rounded shadow">
    <h3 class="font-bold text-gray-800">Name: {{ name }}</h3>
    <p class="text-gray-500 text-sm">Age: {{ age }}</p>
  </div>
</template>

<script>
export default {
  name: 'UserCard',
  props: {
    name: String,
    age: Number,
  },
};
</script>
