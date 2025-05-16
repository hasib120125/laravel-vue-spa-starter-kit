<template>
    <div class="space-y-4">
        <h2 class="text-xl font-bold">{{ isEdit ? 'Edit Customer' : 'Add Customer' }}</h2>

        <form @submit.prevent="saveCustomer" class="space-y-2">
            <div>
                <input v-model="form.name" class="border p-2 rounded block w-full" placeholder="Name" />
                <p v-if="errors.name" class="text-red-600 text-sm">{{ errors.name[0] }}</p>
            </div>

            <div>
                <input v-model="form.phone" class="border p-2 rounded block w-full" placeholder="Phone" />
                <p v-if="errors.phone" class="text-red-600 text-sm">{{ errors.phone[0] }}</p>
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

const form = ref({ name: '', phone: '', id: null })
const errors = ref({})
const isEdit = ref(false)

const route = useRoute()
const router = useRouter()

onMounted(async () => {
    if (route.params.id) {
        isEdit.value = true
        const res = await axios.get(`/api/customers/${route.params.id}`)
        form.value = res.data
    }
})

const saveCustomer = async () => {
    errors.value = {} // clear previous errors
    try {
        if (isEdit.value) {
            await axios.put(`/api/customers/${form.value.id}`, form.value)
        } else {
            await axios.post('/api/customers', form.value)
        }
        router.push('/customers')
    } catch (err) {
        if (err.response && err.response.status === 422) {
            errors.value = err.response.data.errors
        }
    }
}

const cancel = () => {
    router.push('/customers')
}
</script>
