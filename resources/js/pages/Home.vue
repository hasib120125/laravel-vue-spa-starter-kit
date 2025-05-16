<script setup>
import axios from 'axios'
import { onMounted, ref } from 'vue'

const user = ref(null)

onMounted(async () => {
    const res = await axios.get('/api/user')
    user.value = res.data
})
</script>

<template>
    <div>
        <p v-if="user">User: {{ user.name }}</p>
    </div>
</template>