<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                My Tasks
            </h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-4 text-right">
                    <Link href="/tasks/create" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Create Task
                    </Link>
                </div>

                <div v-if="tasks.length === 0" class="text-gray-600">No tasks yet.</div>

                <div v-else class="space-y-4">
                    <div v-for="task in tasks" :key="task.id" class="bg-white p-4 shadow rounded">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-bold">{{ task.title }}</h3>
                                <p class="text-sm text-gray-600">{{ task.status }}</p>
                            </div>
                            <div class="space-x-2">
                                <Link :href="`/tasks/${task.id}/edit`" class="text-blue-600 m-2 hover:underline">Edit</Link>
                                <form :action="`/tasks/${task.id}`" method="POST" @submit.prevent="deleteTask(task.id)">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, router } from '@inertiajs/vue3';
defineProps({ tasks: Array });

function deleteTask(id) {
    if (confirm('Are you sure?')) {
        router.delete(`/tasks/${id}`);
    }
}
</script>
