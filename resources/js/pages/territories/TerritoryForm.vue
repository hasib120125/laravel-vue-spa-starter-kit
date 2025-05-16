<template>
    <div class="space-y-4">
        <h2 class="text-xl font-bold">{{ isEdit ? 'Edit Territory' : 'Add Territory' }}</h2>

        <form @submit.prevent="saveTerritory" class="space-y-2">
            <div>
                <input v-model="form.name" class="border p-2 rounded block w-full" placeholder="Name" />
                <p v-if="errors.name" class="text-red-600 text-sm">{{ errors.name[0] }}</p>
            </div>

            <div>
                <input v-model="form.phone" class="border p-2 rounded block w-full" placeholder="Phone" />
                <p v-if="errors.phone" class="text-red-600 text-sm">{{ errors.phone[0] }}</p>
            </div>

            <div>
                <select v-model="form.customer_id" class="border p-2 rounded block w-full">
                    <option value="" disabled>Select Customer</option>
                    <option v-for="c in customers" :key="c.id" :value="c.id">{{ c.name }}</option>
                </select>
                <p v-if="errors.customer_id" class="text-red-600 text-sm">{{ errors.customer_id[0] }}</p>
            </div>

            <div class="flex gap-2">
                <button class="bg-green-500 text-white px-4 py-2 rounded" type="submit">
                    {{ isEdit ? 'Update' : 'Add' }}
                </button>
                <button @click.prevent="cancel" class="bg-gray-500 text-white px-4 py-2 rounded">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import axios from 'axios'
import { onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const form = ref({ name: '', phone: '', customer_id: '', id: null })
const customers = ref([])
const errors = ref({})
const isEdit = ref(false)

const route = useRoute()
const router = useRouter()

const fetchCustomers = async () => {
    const res = await axios.get('/api/all-customers')
    customers.value = res.data
}

onMounted(async () => {
    await fetchCustomers()

    if (route.params.id) {
        isEdit.value = true
        const res = await axios.get(`/api/territories/${route.params.id}`)
        form.value = res.data
    }
})

const saveTerritory = async () => {
    errors.value = {} // reset errors before submission

    try {
        if (isEdit.value) {
            await axios.put(`/api/territories/${form.value.id}`, form.value)
        } else {
            await axios.post('/api/territories', form.value)
        }
        router.push('/territories')
    } catch (err) {
        if (err.response && err.response.status === 422) {
            errors.value = err.response.data.errors
        }
    }
}

const cancel = () => {
    router.push('/territories')
}
</script>
