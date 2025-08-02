<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Create Task
            </h2>
        </template>

        <div class="py-6 max-w-3xl mx-auto">
            <div class="bg-white p-6 rounded shadow space-y-4">
                <form @submit.prevent="submit">
                    <div class="mb-4">
                        <label class="block font-semibold">Title</label>
                        <input v-model="form.title" class="w-full border p-2 rounded" />
                        <div v-if="form.errors.title" class="text-red-600">{{ form.errors.title }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Description</label>
                        <textarea v-model="form.description" class="w-full border p-2 rounded"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Status</label>
                        <select v-model="form.status" class="w-full border p-2 rounded">
                            <option value="pending">Pending</option>
                            <option value="in-progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                        <div v-if="form.errors.status" class="text-red-600">{{ form.errors.status }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Assign To</label>
                        <select
                            v-model="form.assigned_to"
                            class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500"
                        >
                            <!-- <option :value="null">Assign to me (default)</option> -->
                            <option v-for="user in users" :key="user.id" :value="user.id">
                                {{ user.name }}
                            </option>
                        </select>
                    </div>
                    <button type="submit" class="px-4 my-5 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save</button>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    users: Array,
    auth: Object

})

const form = useForm({
    title: '',
    description: '',
    status: 'open',
    assigned_to: props.auth.user.id,
    users: Array
})

function submit() {
    form.post('/tasks');
}
</script>
