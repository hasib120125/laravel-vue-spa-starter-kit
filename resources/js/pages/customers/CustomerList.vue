<template>
    <div class="space-y-4">
        <h2 class="text-xl font-bold">Customer Management</h2>

        <div class="flex justify-between items-center">
            <router-link to="/customers/create">
                <button class="bg-blue-500 text-white px-4 py-2 rounded">
                    Add Customer
                </button>
            </router-link>

            <input v-model="search" @input="fetchCustomers" class="border px-3 py-2 rounded ml-auto w-64"
                placeholder="Search name or phone" type="text" />
        </div>

        <table class="table-auto w-full border-collapse border border-gray-300 mt-4">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Phone</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="c in customers.data" :key="c.id">
                    <td class="border px-4 py-2">{{ c.name }}</td>
                    <td class="border px-4 py-2">{{ c.phone }}</td>
                    <td class="border px-4 py-2">
                        <router-link :to="`/customers/${c.id}/edit`"
                            class="text-blue-600 hover:underline mr-2">Edit</router-link>
                        <button @click="askDelete(c)" class="text-red-600 hover:underline">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <div v-if="customers.last_page > 1" class="flex gap-2 mt-4">
            <button v-for="page in customers.last_page" :key="page" @click="fetchCustomers(page)" :class="[
                'px-3 py-1 border rounded',
                customers.current_page === page ? 'bg-blue-500 text-white' : ''
            ]">
                {{ page }}
            </button>
        </div>

        <!-- Confirm Modal -->
        <div v-if="showConfirm" class="fixed inset-0 bg-opacity-30 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded shadow-lg w-96 space-y-4">
                <h3 class="text-lg font-semibold">Are you sure?</h3>
                <p>You are about to delete <strong>{{ customerToDelete?.name }}</strong>.</p>
                <div class="flex justify-end gap-2">
                    <button @click="showConfirm = false" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                    <button @click="confirmDelete" class="px-4 py-2 bg-red-600 text-white rounded">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios'
import { onMounted, ref } from 'vue'

const customers = ref({
    data: [],
    current_page: 1,
    last_page: 1,
})

const search = ref('')
const currentPage = ref(1)

const showConfirm = ref(false)
const customerToDelete = ref(null)

const fetchCustomers = async (page = 1) => {
    currentPage.value = page
    const res = await axios.get('/api/customers', {
        params: { search: search.value, page: page }
    })
    customers.value = res.data
}

const askDelete = (customer) => {
    customerToDelete.value = customer
    showConfirm.value = true
}

const confirmDelete = async () => {
    if (customerToDelete.value) {
        await axios.delete(`/api/customers/${customerToDelete.value.id}`)
        showConfirm.value = false
        customerToDelete.value = null
        fetchCustomers(currentPage.value)
    }
}

onMounted(() => fetchCustomers())
</script>
